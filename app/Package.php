<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'package';
    protected $fillable = [
        'number',
        'hash',
        'internal_id',
        'country_id',
        'seller_id',
        'carrier_status_id',
        'carrier_status_number',
        'other_seller',
        'remark',
        'client_id',
        'created_by',
        'send_legality',
        'gross_weight',
        'total_charge_value',
        'amount_usd',
        'amount_azn',
        'currency_id',
        'departure_id',
        'is_warehouse',
        'collected_by',
        'collected_at',
        'container_id',
        'container_date',
        'last_container_id',
        'last_status_id',
        'paid',
        'paid_status',
        'is_ok_custom',
        'partner_id',
        'is_partner_pickup',
        'approve_partner',
        'partner_amount',
        'paid_sum',
        'paid_azn'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('package'));
    }

    public function seller()
    {
        return $this->hasOne(Seller::class, 'seller_id', 'id');
    }
}
