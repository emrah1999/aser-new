<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class CountryDetails extends Model
{
    protected $table = 'country_details';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('country_details'));
    }
}
