<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class İnternationalDelivery extends Model
{
    protected $table = 'i̇nternational_deliveries';

    protected $fillable = [
        'name_az',
        'name_en',
        'name_ru',
        'content_az',
        'content_en',
        'content_ru',
        'icon'
    ];
}
