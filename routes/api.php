<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
	Route::post('/auth/send-otp', 'sendOtp');
	Route::post('/auth/verify-otp', 'verifyOtp');
	Route::post('/auth/delivery-boy-register', 'registerDeliveryBoy');

	Route::middleware('auth:sanctum')->group(function(){
		Route::post('/auth/set-name', 'setName');
    	Route::post('/user/update-location', 'updateLocation');
	});
	
});