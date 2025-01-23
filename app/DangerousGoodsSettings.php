<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DangerousGoodsSettings extends Model
{
    protected $table = 'dangerous_goods_settings';

    public function getTextAttribute($value) {
        return $this->{'text_'.App::getLocale()};
    }
}
