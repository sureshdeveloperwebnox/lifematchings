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
            'phone' => 'required|string',
            'country_code' => 'required|string',
            'email' => 'required_unless:country_code,91|nullable|email',
        ]);

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
        } else {
            // Check email uniqueness
            $isEmailExist = User::where('email', $request->email)->first();
            if ($isEmailExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address already exists'
                ]);
            }
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        
        // Store OTP in session as string
        Session::put('registration_otp', (string)$otp);
        Session::put('otp_created_at', now());

        // Debug logging for OTP generation
        \Log::info('OTP Generated', [
            'otp' => $otp,
            'otp_string' => (string)$otp,
            'phone' => $fullPhone,
            'email' => $request->email
        ]);

        if ($countryCode === '91') {
            Session::put('registration_phone', $fullPhone);
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
            Session::put('registration_email', $request->email);
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
        ]);

        $inputOTP = $request->otp;
        $storedOTP = Session::get('registration_otp');
        $otpCreatedAt = Session::get('otp_created_at');

        // Debug logging
        \Log::info('OTP Verification Debug', [
            'input_otp' => $inputOTP,
            'input_otp_type' => gettype($inputOTP),
            'stored_otp' => $storedOTP,
            'stored_otp_type' => gettype($storedOTP),
            'string_comparison' => (string)$inputOTP === (string)$storedOTP
        ]);

        // Check if OTP exists and is not expired (10 minutes)
        if (!$storedOTP || !$otpCreatedAt) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found or expired'
            ]);
        }

        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($otpCreatedAt) > 10) {
            Session::forget(['registration_otp', 'registration_phone', 'registration_email', 'otp_created_at']);
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired'
            ]);
        }

        // Verify OTP - convert both to strings for comparison
        if ((string)$inputOTP === (string)$storedOTP) {
            Session::put('otp_verified', true);
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }
    }
} 