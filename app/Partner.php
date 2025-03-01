<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name_az',
        'name_en',
        'name_ru',
        'icon'
    ];
}
