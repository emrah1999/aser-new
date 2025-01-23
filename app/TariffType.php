<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TariffType extends Model
{
    protected $table = 'tariff_types';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('tariff_types'));
    }

    public function getNameAttribute($value) {
        return $this->{'name_'.App::getLocale()};
    }
}
