<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CourierOrderStatus extends Model
{
    protected $table = 'courier_order_status';
    protected $fillable = [
        'order_id',
        'status_id',
        'created_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('courier_order_status'));
    }
}
