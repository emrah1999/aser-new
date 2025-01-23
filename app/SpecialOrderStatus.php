<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class SpecialOrderStatus extends Model
{
    protected $table = 'special_order_status';
    protected $fillable = [
        'order_id',
        'status_id',
        'created_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('special_order_status'));
    }
}
