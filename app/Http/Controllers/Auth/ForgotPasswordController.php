<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

   // private const OTP_TEMPLATE_NAME = 'otp for password resetv1';
    private const OTP_TEMPLATE_NAME = 'otp for registrationv1';
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    public function sendResetLinkEmail(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000,999999);
                $user->save();

                EmailUtility::password_reset_email($user, $user->verification_code);
                return view('auth.passwords.reset');
            }
            else {
                flash(translate('No account exists with this email'))->error();
                return back();
            }
        }
        else{
          
            $inputPhone = $request->email;
            // Remove any leading '+91' from the input if exists
            $normalizedInput = preg_replace('/^\+91/', '', $inputPhone);

            // Try to find the user by phone with or without country code
            $user = User::where(function ($query) use ($normalizedInput, $inputPhone) {
                $query->where('phone', $inputPhone) // exact match
                    ->orWhere('phone', '+91' . $normalizedInput); // match with +91 prefix
            })->first();
            
            if ($user != null) {
                $user->verification_code = rand(100000,999999);
                $user->save();

                // Store OTP in session for verification
                Session::put('password_reset_otp', (string)$user->verification_code);
                Session::put('password_reset_phone', $user->phone);
                Session::put('password_reset_user_id', $user->id);
                Session::put('password_reset_otp_created_at', now());

                // Send OTP via 2factor API
                $apiKey = '6a8e6cd2-b3bc-11ef-8b17-0200cd936042';
                $url = "https://2factor.in/API/V1/{$apiKey}/SMS/{$user->phone}/{$user->verification_code}/" . self::OTP_TEMPLATE_NAME;

                try {
                    $response = Http::get($url);
                    $result = $response->json();

                    if ($response->successful() && isset($result['Status']) && $result['Status'] === 'Success') {
                        flash(translate('OTP sent successfully to your phone number'))->success();
                        return view('auth.passwords.reset_with_phone');
                    } else {
                        // Fallback to original SMS method if 2factor fails
                        SmsUtility::password_reset($user, $user->verification_code);
                        flash(translate('OTP sent successfully to your phone number'))->success();
                        return view('auth.passwords.reset_with_phone');
                    }
                } catch (\Exception $e) {
                    // Fallback to original SMS method if 2factor fails
                    SmsUtility::password_reset($user, $user->verification_code);
                    flash(translate('OTP sent successfully to your phone number'))->success();
                    return view('auth.passwords.reset_with_phone');
                }
            }
            else {
                flash(translate('No account exists with this phone number'))->error();
                return back();
            }
        }
    }


    /**
     * Reset password with phone verification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordWithPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $inputOTP = $request->otp;
        $storedOTP = Session::get('password_reset_otp');
        $otpCreatedAt = Session::get('password_reset_otp_created_at');
        $userId = Session::get('password_reset_user_id');

        // Check if OTP exists and is not expired (10 minutes)
        if (!$storedOTP || !$otpCreatedAt || !$userId) {
            flash(translate('OTP not found or expired'))->error();
            return back();
        }

        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($otpCreatedAt) > 10) {
            Session::forget(['password_reset_otp', 'password_reset_phone', 'password_reset_user_id', 'password_reset_otp_created_at']);
            flash(translate('OTP has expired'))->error();
            return back();
        }

        // Verify OTP - convert both to strings for comparison
        if ((string)$inputOTP !== (string)$storedOTP) {
            flash(translate('Invalid OTP'))->error();
            return back();
        }

        $user = User::find($userId);

        if ($user && $user->phone === $request->phone) {
            $user->password = \Hash::make($request->password);
            $user->save();

            // Clear session data
            Session::forget(['password_reset_otp', 'password_reset_phone', 'password_reset_user_id', 'password_reset_otp_created_at']);

            // Login user
            auth()->login($user, true);

            flash(translate('Password updated successfully'))->success();

            if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        } else {
            flash(translate('Invalid phone number'))->error();
            return back();
        }
    }
}
