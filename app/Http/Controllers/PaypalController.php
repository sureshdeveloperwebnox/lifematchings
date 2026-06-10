<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use PayPalHttp\HttpException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Http\Controllers\PackagePaymentController;
use App\Http\Controllers\InitialPaymentController;

class PaypalController extends Controller
{

    public function pay()
    {
      // dd(Session::get('payment_data')['amount']);
        // Creating an environment
        $clientId     = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client       = new PayPalHttpClient($environment);

        if(Session::has('payment_type')){
            $amount = Session::get('payment_data')['amount'];
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        
        // PayPal always uses USD for better compatibility and to avoid currency restrictions
        // Get system default currency
        $systemCurrency = \App\Models\Currency::findOrFail(get_setting('system_default_currency'));
        $systemCurrencyCode = strtoupper((string) $systemCurrency->code);
        
        // Always use USD for PayPal payments
        $currencyCode = 'USD';
        
        // Convert amount to USD if system currency is not USD
        if ($systemCurrencyCode !== 'USD') {
            // Get USD currency for exchange rate reference
            $usdCurrency = \App\Models\Currency::where('code', 'USD')->first();
            
            if ($systemCurrency->exchange_rate > 0) {
                $exchangeRate = floatval($systemCurrency->exchange_rate);
                
                // Handle different exchange rate formats:
                // Format 1: exchange_rate > 1 means "units per USD" (e.g., INR = 83 means 83 INR = 1 USD)
                // Format 2: exchange_rate < 1 means "USD per unit" (e.g., 0.012 means 1 INR = 0.012 USD)
                // Format 3: exchange_rate between 0.5-2 might be "USD per unit" for major currencies
                
                if ($exchangeRate >= 10) {
                    // Large number likely means "units per USD" - divide
                    // Example: INR = 83 means 83 INR = 1 USD, so 999 INR = 999/83 = 12.04 USD
                    $amount = floatval($amount) / $exchangeRate;
                } elseif ($exchangeRate < 0.1) {
                    // Very small number likely means "USD per unit" - multiply
                    // Example: 0.012 means 1 INR = 0.012 USD, so 999 INR = 999 * 0.012 = 11.99 USD
                    $amount = floatval($amount) * $exchangeRate;
                } else {
                    // Medium values: Check currency type
                    // For currencies like EUR, GBP that are close to USD value, likely "USD per unit"
                    if (in_array($systemCurrencyCode, ['EUR', 'GBP', 'AUD', 'CAD', 'NZD', 'CHF'])) {
                        $amount = floatval($amount) * $exchangeRate;
                    } else {
                        // For others, assume "units per USD" and divide
                        $amount = floatval($amount) / $exchangeRate;
                    }
                }
            } else {
                // Fallback: Use approximate conversion rates if exchange_rate is 0 or not set
                // These rates are stored as "1 unit of currency = rate USD"
                $fallbackRates = [
                    'INR' => 0.012,  // 1 INR = 0.012 USD (approx, 1 USD = 83 INR)
                    'EUR' => 1.08,   // 1 EUR = 1.08 USD (approx)
                    'GBP' => 1.27,   // 1 GBP = 1.27 USD (approx)
                ];
                
                if (isset($fallbackRates[$systemCurrencyCode])) {
                    $amount = floatval($amount) * $fallbackRates[$systemCurrencyCode];
                } else {
                    // If no conversion rate available, log warning and use amount as-is
                    \Log::warning('PayPal: No exchange rate for currency ' . $systemCurrencyCode . ', using amount as-is. This may cause payment issues.');
                }
            }
        }
        
        // Round to 2 decimal places for currency
        $amount = number_format((float)$amount, 2, '.', '');

        $request->body = [
                     "intent" => "CAPTURE",
                     "purchase_units" => [[
                         "reference_id" => rand(000000,999999),
                         "amount" => [
                             "value" => $amount,
                            "currency_code" => $currencyCode
                         ]
                     ]],
                     "application_context" => [
                          "cancel_url" => url('paypal/payment/cancel'),
                          "return_url" => url('paypal/payment/done')
                     ]
                 ];
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            return Redirect::to($response->result->links[1]->href);
        }catch (HttpException $ex) {
            // Provide a readable error back to the user
            $message = 'Unable to start PayPal payment.';
            $data = json_decode($ex->getMessage(), true);
            if (json_last_error() === JSON_ERROR_NONE && isset($data['message'])) {
                $message = $data['message'];
            }
            flash(translate($message))->error();
            return redirect()->route('home');
        }
    }


    public function getCancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('payment_data');
        $request->session()->forget('payment_type');
        flash(translate('Payment cancelled'))->success();
    	  return redirect()->route('home');
    }

    public function getDone(Request $request)
    {
        //dd($request->all());
        // Creating an environment
        $clientId     = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client       = new PayPalHttpClient($environment);

        // $response->result->id gives the orderId of the order created above

        $ordersCaptureRequest = new OrdersCaptureRequest($request->token);
        $ordersCaptureRequest->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($ordersCaptureRequest);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if($request->session()->has('payment_type')){

                if ($request->session()->get('payment_type') == 'package_payment') {
                    $packagePaymentController = new PackagePaymentController;
                    return $packagePaymentController->package_payment_done($request->session()->get('payment_data'), json_encode($response));
                }

                elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                  $walletController = new WalletController;
                  return $walletController->wallet_payment_done($request->session()->get('payment_data'), json_encode($response));
                }

                elseif ($request->session()->get('payment_type') == 'initial_payment') {
                    $initialPaymentController = new InitialPaymentController;
                    return $initialPaymentController->payment_done($request->session()->get('payment_data'), json_encode($response));
                }

                else {
                    // Unknown payment type - log and redirect
                    \Log::error('Unknown payment type in PayPal callback: ' . $request->session()->get('payment_type'));
                    flash(translate('Payment completed but payment type was not recognized. Please contact support.'))->warning();
                    $request->session()->forget('payment_data');
                    $request->session()->forget('payment_type');
                    return redirect()->route('home');
                }

            } else {
                // No payment type in session
                \Log::error('PayPal callback received but no payment_type in session');
                flash(translate('Payment session expired. Please try again.'))->error();
                return redirect()->route('home');
            }
        }catch (HttpException $ex) {
            // Handle common PayPal failures gracefully
            $message = 'Payment could not be completed.';
            $issue = null;
            $data = json_decode($ex->getMessage(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (isset($data['details'][0]['issue'])) {
                    $issue = $data['details'][0]['issue'];
                }
                if (isset($data['message'])) {
                    $message = $data['message'];
                }
            }

            if ($issue === 'INSTRUMENT_DECLINED') {
                // Advise the buyer to try a different funding source or PayPal wallet
                $message = 'Your card or funding source was declined. Please try another card or PayPal account.';
            }

            flash(translate($message))->error();
            $request->session()->forget('payment_data');
            $request->session()->forget('payment_type');
            return redirect()->route('home');   
        }
    }
}
