<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'otp';
    
    protected $fillable = [
        'otp', 'otp_session', 'client_id', 'phone', 'is_verify', 'created_by', 'updated_by'
    ];
}
