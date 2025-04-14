<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerOtp extends Model
{
    protected $table = 'seller_otp';
    
    protected $fillable = [
        'otp_code', 'otp_text', 'seller_id', 'is_active', 'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];
}
