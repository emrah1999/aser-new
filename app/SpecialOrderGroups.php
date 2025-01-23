<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class SpecialOrderGroups extends Model
{
    protected $table = 'special_order_groups';
    protected $fillable = [
        'urls',
        'client_id',
        'country_id',
        'single_price',
        'price',
        'currency_id',
        'is_paid',
        'paid',
        'paid_at',
        'group_code',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('special_order_groups'));
    }
}
