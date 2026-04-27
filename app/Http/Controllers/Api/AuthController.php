<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhoneOtp;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $validator->errors()->first(), 422);
        }

        $user = User::where('phone_number',$request->phone_number)->first();

        if($user){
            if ($user->role === 'delivery_boy') {
                if ($user->approval_status === 'pending') {
                    return $this->error([], 'Your account is under review by admin.', 403);
                }

                if ($user->approval_status === 'rejected') {
                    return $this->error([], 'Your registration has been rejected.', 403);
                }
            }
        }


        $otp = rand(100000, 999999);

        $phoneOtp = PhoneOtp::create([
            'phone_number' => $request->phone_number,
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // $formattedPhone = $this->formatPhoneNumber($request->phone_number);
        // $this->twilioService->sendSms($formattedPhone, "Your OTP code is: $otp");
        
        return $this->success($phoneOtp,'OTP sent successfully',200);
    }

    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 2) === '01') {
            return '+880' . substr($phone, 1);
        }
        return $phone;
    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|min:10',
            'otp_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $validator->errors()->first(), 422);
        }

        $otpEntry = PhoneOtp::where('phone_number', $request->phone_number)
                            ->where('otp_code', $request->otp_code)
                            ->where('is_verified', false)
                            ->where('expires_at', '>', Carbon::now())
                            ->first();

        if (!$otpEntry) {
            return $this->error([], 'Invalid or expired OTP', 400);
        }

        $otpEntry->update(['is_verified' => true]);

        $user = User::where('phone_number', $request->phone_number)->first();

        // Check Approval Status if role is delivery_boy
        if ($user->role === 'delivery_boy') {
            if ($user->approval_status === 'pending') {
                return $this->error([], 'Your account is under review by admin.', 403);
            }

            if ($user->approval_status === 'rejected') {
                return $this->error([], 'Your registration has been rejected.', 403);
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $otpEntry->update(['user_id' => $user->id]);

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($data, 'OTP verified successfully', 200);
    }


    public function setName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $validator->errors()->first(), 422);
        }

        $user = Auth::user();

        if ($user->name) {
            return $this->error([], 'Name already set', 400);
        }

        $user->update(['name' => $request->name]);

        return $this->success($user, 'Name updated successfully',200);
    }


    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $validator->errors()->first(), 422);
        }

        $user = Auth::user();

        $user->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return $this->success($user, 'Location updated successfully', 200);
    }


    public function registerDeliveryBoy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|min:10|unique:users,phone_number',
            'avatar' => 'required|image|mimes:jpeg,png,jpg',
            'document' => 'required|mimes:pdf', 
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $validator->errors()->first(), 422);
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = uploadImage($request->file('avatar'), 'avatars');
        }
        if ($request->hasFile('document')) {
            $documentPath = uploadImage($request->file('document'), 'documents');
        }

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'avatar' => $avatarPath,
            'document' => $documentPath,
            'role' => 'delivery_boy',
            'approval_status' => 'pending',
        ]);

        return $this->success($user, 'Registration submitted successfully. Awaiting admin approval.', 201);
    }


}
