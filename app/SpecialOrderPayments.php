<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOrderPayments extends Model
{
    protected $table = 'special_order_payments';
    protected $fillable = [
        'order_id',
        'payment_key',
        'created_by',
    ];
}
