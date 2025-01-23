<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $table = 'container';
    protected $fillable = [
        'id',
        'flight_id',
//        'awb_id',
        'departure_id',
        'destination_id',
        'close_date',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'id');
    }
}
