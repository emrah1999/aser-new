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
        'icon',
        'sub_title_az',
        'sub_title_en',
        'sub_title_ru' ,
        'sub_description_az',
        'sub_description_en',
        'sub_description_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'rank',
        'internal_images',
        'cover_description_az',
        'cover_description_en',
        'cover_description_ru',
    ];
}
