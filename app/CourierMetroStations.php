<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CourierMetroStations extends Model
{
    protected $table = 'courier_metro_stations';
    protected $fillable = [
        'name_en',
        'name_az',
        'name_ru',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent ::boot();
        static ::addGlobalScope(new DeletedScope('courier_metro_stations'));
    }
}
