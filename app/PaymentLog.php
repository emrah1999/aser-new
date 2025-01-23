<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $table = 'payment_log';
    protected $fillable = [
        'package_id',
        'client_id',
        'payment',
        'currency_id',
        'type', // 1 -cash, 2 - pos, 3 - balance, 4 - payment
        'created_by',
        'deleted_by',
        'deleted_at',
        'is_courier_order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('payment_log'));
    }
}
