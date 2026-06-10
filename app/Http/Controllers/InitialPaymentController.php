<?php

namespace App\Http\Controllers;

use App\Models\ManualPaymentMethod;
use App\Models\Member;
use App\Models\PackagePayment;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\DbStoreNotification;
use App\Services\FirbaseNotification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Auth;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use Notification;
use Session;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\PaypalController;
use App\Utility\MemberUtility;

class InitialPaymentController extends Controller
{
    public function payment_methods()
    {
        $manual_payments = ManualPaymentMethod::all();
        return view('frontend.package.initial_payment_methods', compact('manual_payments'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data['amount'] = 99; // Fixed amount for initial payment
        $data['package_id'] = 0; // No specific package for initial payment
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'initial_payment');
        $request->session()->put('payment_data', $data);

        if ($request->payment_option == 'initial_payment_razorpay') {
            $razorpay = new RazorpayController();
            return $razorpay->pay($request);
        } elseif ($request->payment_option == 'manual_payment') {
            $package_payment = new PackagePayment();
            $package_payment->payment_code = date('ymd-His');
            $package_payment->user_id = $user->id;
            $package_payment->package_id = 0;
            $package_payment->payment_method = 'manual_payment';
            $package_payment->payment_status = 'Due';
            $package_payment->amount = 99;
            $package_payment->payment_details = '';
            $package_payment->offline_payment = 1;
            $package_payment->custom_payment_name = 'Initial Payment Package';
            $package_payment->custom_payment_transaction_id = $request->transaction_id;
            $package_payment->custom_payment_proof = $request->payment_proof;
            $package_payment->custom_payment_details = $request->payment_details;
            $package_payment->save();

            // Initial Payment Store Notification for member
            try {
                $notify_type = 'initial_payment_pending';
                $id = unique_notify_id();
                $notify_by = $user->id;
                $info_id = $package_payment->id;
                $message = $user->first_name . ' ' . $user->last_name . translate(' has submitted initial payment request. Payment Code: ') . $package_payment->payment_code;
                $route = route('package-payments.index');

                // fcm
                if (get_setting('firebase_push_notification') == 1) {
                    $fcmTokens = User::where('user_type', 'admin')
                        ->whereNotNull('fcm_token')
                        ->pluck('fcm_token')
                        ->toArray();
                    Larafirebase::withTitle(str_replace("_", " ", $notify_type))
                        ->withBody($message)
                        ->sendMessage($fcmTokens);
                }
                // end of fcm

                Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
            } catch (\Exception $e) {
                // dd($e);
            }

            Session::forget('payment_data');
            Session::forget('payment_type');

            flash(translate('Initial payment request submitted successfully. Please wait for admin approval.'))->success();
            return redirect()->route('home');
        }
    }

    public function payWithRazorpay(Request $request)
    {
        
        $user = Auth::user();
        $data['amount'] = 999; // Fixed amount for initial payment
        $data['package_id'] = 0; // No specific package for initial payment
        $data['payment_method'] = 'razorpay';

        $request->session()->put('payment_type', 'initial_payment');
        $request->session()->put('payment_data', $data);

        $razorpay = new RazorpayController();
        return $razorpay->pay($request);
    }

    public function payWithPaypal(Request $request)
    {
        $user = Auth::user();

        // Block PayPal for buyers whose billing country is India
        $memberCountry = MemberUtility::member_country($user->id);
        if ($memberCountry && strtolower($memberCountry) === 'india') {
            flash(translate('PayPal is unavailable for Indian billing addresses. Please use Razorpay.'))->error();
            return redirect()->route('initialPaymentpackage');
        }
        $data['amount'] = 999; // Fixed amount for initial payment
        $data['package_id'] = 0; // No specific package for initial payment
        $data['payment_method'] = 'paypal';

        $request->session()->put('payment_type', 'initial_payment');
        $request->session()->put('payment_data', $data);

        $paypal = new PaypalController();
        return $paypal->pay();
    }

    public function payment_done($payment_data, $payment_details)
    {
        $user = auth()->user();

        // Update user's initial payment status
        $user->isInitialPaymentPaid = 1;
        $user->save();

        // Create package payment record for tracking
        $package_payment = new PackagePayment();
        $package_payment->payment_code = date('ymd-His');
        $package_payment->user_id = $user->id;
        $package_payment->package_id = 0; // No specific package for initial payment
        $package_payment->payment_method = $payment_data['payment_method'];
        $package_payment->payment_status = 'Paid';
        $package_payment->amount = $payment_data['amount'];
        $package_payment->payment_details = $payment_details;
        $package_payment->offline_payment = 2;
        $package_payment->custom_payment_name = 'Initial Payment Package';
        $package_payment->save();

        try {
            $notify_type = 'initial_payment_completed';
            $id = unique_notify_id();
            $notify_by = $user->id;
            $info_id = $package_payment->id;
            $message = $user->first_name . ' ' . $user->last_name . translate('has completed initial payment. Payment Code: ') . $package_payment->payment_code;
            $route = route('package-payments.index');

            // fcm
            if (get_setting('firebase_push_notification') == 1) {
                $fcmTokens = User::where('user_type', 'admin')
                    ->whereNotNull('fcm_token')
                    ->pluck('fcm_token')
                    ->toArray();
                Larafirebase::withTitle(str_replace("_", " ", $notify_type))
                    ->withBody($message)
                    ->sendMessage($fcmTokens);
            }
            // end of fcm

           // Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
        } catch (\Exception $e) {
            // dd($e);
        }

        // // Payment completion email send to member
        // if ($user->email != null && get_email_template('package_purchase_email', 'status')) {
        //     EmailUtility::package_purchase_email($user, $package_payment);
        // }

        Session::forget('payment_data');
        Session::forget('payment_type');

        flash(translate('Initial payment completed successfully! You now have access to premium features.'))->success();
        return redirect()->route('package_payment.invoice', $package_payment->id);
    }

    public function payment_done_api(Request $request)
    {
        // Validate required fields
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_details' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => translate('Validation failed.'),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);

        // Check if user exists
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => translate('User not found.'),
                'error' => 'User with ID ' . $request->user_id . ' does not exist.'
            ], 404);
        }

        // Update user's initial payment status
        $user->isInitialPaymentPaid = 1;
        $user->save();

        // Create package payment record for tracking
        $package_payment = new PackagePayment();
        $package_payment->payment_code = date('ymd-His');
        $package_payment->user_id = $user->id;
        $package_payment->package_id = 0; // No specific package for initial payment
        $package_payment->payment_method = $request->payment_method;
        $package_payment->payment_status = 'Paid';
        $package_payment->amount = $request->amount;
        $package_payment->payment_details = $request->payment_details;
        $package_payment->offline_payment = 2;
        $package_payment->custom_payment_name = 'Initial Payment Package';
        $package_payment->save();

        try {
            $notify_type = 'initial_payment_completed';
            $id = unique_notify_id();
            $notify_by = $user->id;
            $info_id = $package_payment->id;
            $message = $user->first_name . ' ' . $user->last_name . translate('has completed initial payment. Payment Code: ') . $package_payment->payment_code;
            //$route = route('package-payments.index');

            // fcm
            if (get_setting('firebase_push_notification') == 1) {
                $fcmTokens = User::where('user_type', 'admin')
                    ->whereNotNull('fcm_token')
                    ->pluck('fcm_token')
                    ->toArray();
                Larafirebase::withTitle(str_replace("_", " ", $notify_type))
                    ->withBody($message)
                    ->sendMessage($fcmTokens);
            }
            // end of fcm

           // Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
        } catch (\Exception $e) {
            // dd($e);
        }

        // // Payment completion email send to member
        // if ($user->email != null && get_email_template('package_purchase_email', 'status')) {
        return response()->json([
            'success' => true,
            'message' => translate('Initial payment completed successfully!'),
            'data' => [
                'payment_code' => $package_payment->payment_code,
                'amount' => $package_payment->amount,
                'payment_id' => $package_payment->id,
                'user_id' => $user->id,
                'payment_method' => $package_payment->payment_method,
                'payment_status' => $package_payment->payment_status,
                'created_at' => $package_payment->created_at
            ]
        ], 200);
    }
}