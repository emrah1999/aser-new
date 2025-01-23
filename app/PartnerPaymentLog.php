<?php

namespace App;
use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class PartnerPaymentLog extends Model
{
    protected $table = 'partner_payment_log';
    protected $fillable = [
        'amount',
        'amount_azn',
        'client_id',
        'created_by',
        'deleted_at',
        'deleted_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('partner_payment_log'));
    }
}
