<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name_az',
        'content_az',
        'name_ru',
        'content_ru',
        'name_en', 
        'content_en',
        'title_en',
        'title_az',
        'title_ru',
        'description_en',
        'description_az',
        'description_ru',
        'slug_en',
        'slug_az',
        'slug_ru',
        'is_active',
        'is_menu',
        'deleted_at',
        'deleted_by'
    ];
}
