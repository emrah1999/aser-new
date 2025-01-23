<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerOtp extends Model
{
    protected $table = 'seller_otp';
    
    protected $fillable = [
        'otp_code', 'otp_text', 'seller_id', 'is_active', 'created_by'
    ];
}
