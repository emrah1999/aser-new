<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CourierRegionTariff extends Model
{
    protected $table = 'courier_region_tariffs';

    protected static function boot()
    {
        parent ::boot();
        static ::addGlobalScope(new DeletedScope('courier_region_tariffs'));
    }
}
