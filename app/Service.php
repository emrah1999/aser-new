<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name_az',
        'name_en',
        'name_ru',
        'content_az',
        'content_en',
        'content_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'icon',
        'ceo_title_az',
        'ceo_title_en',
        'ceo_title_ru',
        'seo_description_az',
        'seo_description_en',
        'seo_description_ru',
        'internal_images'
    ];
}
