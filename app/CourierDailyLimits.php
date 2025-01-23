<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CourierDailyLimits extends Model
{
    protected $table = 'courier_daily_limits';

    protected static function boot()
    {
        parent ::boot();
        static ::addGlobalScope(new DeletedScope('courier_daily_limits'));
    }
}
