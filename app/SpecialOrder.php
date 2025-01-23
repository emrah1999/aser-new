<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class SpecialOrder extends Model
{
    protected $table = 'special_orders';
    protected $fillable = [
        'url',
        'quantity',
        'single_price',
        'price',
        'color',
        'size',
        'description',
        'group_code',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('special_orders'));
    }
}
