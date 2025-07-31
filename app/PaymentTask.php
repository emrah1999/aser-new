<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class PaymentTask extends Model
{
    protected $table = 'payment_task';
    protected $fillable = [
        'payment_key',
        'status',
        'type',
        'payment_type',
        'order_id', // for courier
        'packages', // for courier, id string (1,5,9)
        'ip_address',
        'created_by',
        'deleted_by',
        'deleted_at',
        'amount',
        'is_api',
        'p_sign',
        'trtype2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('payment_task'));
    }
}
