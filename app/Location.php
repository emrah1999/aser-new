<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('locations'));
    }
}
