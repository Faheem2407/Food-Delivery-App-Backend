<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PhoneOtp extends Model
{
    protected $fillable = ['phone_number', 'otp_code', 'expires_at', 'is_verified', 'user_id'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

