<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffText extends Model
{
    protected $fillable = [
        'name_1_az',
        'name_1_en',
        'name_1_ru',
        'content_1_az',
        'content_1_en',
        'content_1_ru',


        'name_2_az',
        'name_2_en',
        'name_2_ru',
        'content_2_az',
        'content_2_en',
        'content_2_ru',

        'name_3_az',
        'name_3_en',
        'name_3_ru',
        'content_3_az',
        'content_3_en',
        'content_3_ru',
    ];
}
