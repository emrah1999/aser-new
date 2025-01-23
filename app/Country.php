<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Country extends Model
{
    protected $table = 'countries';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('countries'));
    }

    public function getNameAttribute($value) {
        return $this->{'name_'.App::getLocale()};
    }
}
