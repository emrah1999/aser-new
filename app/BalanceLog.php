<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class BalanceLog extends Model
{
    protected $table = 'balance_log';
    protected $fillable = [
        'payment_code',
        'amount',
        'amount_azn',
        'client_id',
        'status',
        'type', // cash, cart, balance, back
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('balance_log'));
    }
}
