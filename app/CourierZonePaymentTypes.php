<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CourierZonePaymentTypes extends Model
{
    protected $table = 'courier_zone_payment_type';

    protected static function boot()
    {
        parent ::boot();
        static ::addGlobalScope(new DeletedScope('courier_zone_payment_type'));
    }
}
