<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;    

class OTPController extends Controller
{
    private const OTP_TEMPLATE_NAME = 'otp for registrationv1';
    
    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required_without:email|nullable|string',
            'country_code' => 'required_without:email|nullable|string',
            'email' => 'required_without:phone|nullable|email',
            'delivery_method' => 'nullable|string|in:phone,email',
        ]);

        $deliveryMethod = $request->delivery_method;
        if (!$deliveryMethod) {
            // Fallback to old behavior if not specified
            $deliveryMethod = ($request->country_code === '91' && $request->phone) ? 'phone' : 'email';
        }

        if ($deliveryMethod === 'phone') {
            $phone = $request->phone;
            $countryCode = $request->country_code;
            $fullPhone = '+' . $countryCode . $phone;

            // If India, check phone uniqueness
            if ($countryCode === '91') {
                $isPhoneExist = User::where(function ($query) use ($phone, $fullPhone) {
                    $query->where('phone', $fullPhone)
                          ->orWhereRaw("REPLACE(phone, '+', '') LIKE ?", ["%{$phone}"]);
                })->first();

                if ($isPhoneExist) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Phone number already exists'
                    ]);
                }
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            
            // Store OTP in session as string
            Session::put('registration_otp', (string)$otp);
            Session::put('otp_created_at', now());
            Session::put('registration_phone', $fullPhone);
            Session::forget('registration_email');

            // Store in Cache for stateless verification (10 minutes)
            $phoneKey1 = $countryCode . '_' . $phone;
            $phoneKey2 = $fullPhone;
            $phoneKey3 = $countryCode . $phone;
            \Cache::put('registration_otp_phone_' . $phoneKey1, (string)$otp, 600);
            \Cache::put('registration_otp_phone_time_' . $phoneKey1, now()->toISOString(), 600);
            \Cache::put('registration_otp_phone_' . $phoneKey2, (string)$otp, 600);
            \Cache::put('registration_otp_phone_time_' . $phoneKey2, now()->toISOString(), 600);
            \Cache::put('registration_otp_phone_' . $phoneKey3, (string)$otp, 600);
            \Cache::put('registration_otp_phone_time_' . $phoneKey3, now()->toISOString(), 600);

            // Debug logging for OTP generation
            \Log::info('OTP Generated for Phone', [
                'otp' => $otp,
                'otp_string' => (string)$otp,
                'phone' => $fullPhone
            ]);

            // Send OTP via 2factor API
            $apiKey = '6a8e6cd2-b3bc-11ef-8b17-0200cd936042';
            $url = "https://2factor.in/API/V1/{$apiKey}/SMS/{$fullPhone}/{$otp}/" . self::OTP_TEMPLATE_NAME;

            try {
                $response = Http::get($url);
                $result = $response->json();

                if ($response->successful() && isset($result['Status']) && $result['Status'] === 'Success') {
                    return response()->json([
                        'success' => true,
                        'message' => 'OTP sent successfully',
                        'otp' => $otp
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send OTP'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error sending OTP: ' . $e->getMessage()
                ]);
            }
        } else {
            // Check email uniqueness
            $isEmailExist = User::where('email', $request->email)->first();
            if ($isEmailExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address already exists'
                ]);
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            
            // Store OTP in session as string
            Session::put('registration_otp', (string)$otp);
            Session::put('otp_created_at', now());
            Session::put('registration_email', $request->email);
            Session::forget('registration_phone');

            // Store in Cache for stateless verification (10 minutes)
            \Cache::put('registration_otp_email_' . $request->email, (string)$otp, 600);
            \Cache::put('registration_otp_email_time_' . $request->email, now()->toISOString(), 600);

            // Debug logging for OTP generation
            \Log::info('OTP Generated for Email', [
                'otp' => $otp,
                'otp_string' => (string)$otp,
                'email' => $request->email
            ]);

            // Send OTP via Email using EmailManager
            $array = [];
            $array['view'] = 'emails.newsletter';
            $array['subject'] = 'Verification Code - ' . get_setting('website_name');
            $array['from'] = env('MAIL_FROM_ADDRESS') ?: 'lifematchings@gmail.com';
            $array['content'] = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
                    <h2 style="color: #d81b60; text-align: center;">' . get_setting('website_name') . '</h2>
                    <p>Hello,</p>
                    <p>Your OTP verification code for registering an account is:</p>
                    <div style="background-color: #f8f9fa; border: 1px dashed #d81b60; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #333; margin: 20px 0;">
                        ' . $otp . '
                    </div>
                    <p>This code is valid for 10 minutes. Please do not share this code with anyone.</p>
                    <p>Thank you,</p>
                    <p>The ' . get_setting('website_name') . ' Team</p>
                </div>
            ';

            try {
                \Mail::to($request->email)->send(new \App\Mail\EmailManager($array));
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'otp' => $otp
                ]);
            } catch (\Exception $e) {
                \Log::error('OTP Email Send Failed', ['error' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error sending OTP to email: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'phone' => 'nullable|string',
            'country_code' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $inputOTP = $request->otp;
        $isStateless = false;
        $phoneKey1 = null;
        $phoneKey2 = null;
        $phoneKey3 = null;
        $email = null;

        if ($request->has('phone') && $request->has('country_code')) {
            $isStateless = true;
            $phone = $request->phone;
            $countryCode = $request->country_code;
            $phoneKey1 = $countryCode . '_' . $phone;
            $phoneKey2 = '+' . $countryCode . $phone;
            $phoneKey3 = $countryCode . $phone;

            $storedOTP = \Cache::get('registration_otp_phone_' . $phoneKey1);
            $otpCreatedAtStr = \Cache::get('registration_otp_phone_time_' . $phoneKey1);

            if (!$storedOTP) {
                $storedOTP = \Cache::get('registration_otp_phone_' . $phoneKey2);
                $otpCreatedAtStr = \Cache::get('registration_otp_phone_time_' . $phoneKey2);
            }
            if (!$storedOTP) {
                $storedOTP = \Cache::get('registration_otp_phone_' . $phoneKey3);
                $otpCreatedAtStr = \Cache::get('registration_otp_phone_time_' . $phoneKey3);
            }

            $otpCreatedAt = $otpCreatedAtStr ? \Carbon\Carbon::parse($otpCreatedAtStr) : null;
        } elseif ($request->has('email')) {
            $isStateless = true;
            $email = $request->email;
            $storedOTP = \Cache::get('registration_otp_email_' . $email);
            $otpCreatedAtStr = \Cache::get('registration_otp_email_time_' . $email);
            $otpCreatedAt = $otpCreatedAtStr ? \Carbon\Carbon::parse($otpCreatedAtStr) : null;
        } else {
            // Web/Session fallback
            $storedOTP = Session::get('registration_otp');
            $otpCreatedAt = Session::get('otp_created_at');
        }

        // Debug logging
        \Log::info('OTP Verification Debug', [
            'input_otp' => $inputOTP,
            'stored_otp' => $storedOTP,
            'is_stateless' => $isStateless,
            'otp_created_at' => $otpCreatedAt ? $otpCreatedAt->toDateTimeString() : null,
            'string_comparison' => (string)$inputOTP === (string)$storedOTP
        ]);

        // Check if OTP exists
        if (!$storedOTP || !$otpCreatedAt) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ]);
        }

        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($otpCreatedAt) > 10) {
            if ($isStateless) {
                if ($phoneKey1) {
                    \Cache::forget('registration_otp_phone_' . $phoneKey1);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey1);
                    \Cache::forget('registration_otp_phone_' . $phoneKey2);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey2);
                    \Cache::forget('registration_otp_phone_' . $phoneKey3);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey3);
                } elseif ($email) {
                    \Cache::forget('registration_otp_email_' . $email);
                    \Cache::forget('registration_otp_email_time_' . $email);
                }
            } else {
                Session::forget(['registration_otp', 'registration_phone', 'registration_email', 'otp_created_at']);
            }
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ]);
        }

        // Verify OTP - convert both to strings for comparison
        if ((string)$inputOTP === (string)$storedOTP) {
            if ($isStateless) {
                if ($phoneKey1) {
                    \Cache::forget('registration_otp_phone_' . $phoneKey1);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey1);
                    \Cache::forget('registration_otp_phone_' . $phoneKey2);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey2);
                    \Cache::forget('registration_otp_phone_' . $phoneKey3);
                    \Cache::forget('registration_otp_phone_time_' . $phoneKey3);
                } elseif ($email) {
                    \Cache::forget('registration_otp_email_' . $email);
                    \Cache::forget('registration_otp_email_time_' . $email);
                }
            } else {
                Session::put('otp_verified', true);
            }
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ]);
        }
    }
} 