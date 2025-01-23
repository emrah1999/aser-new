<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('currency'));
    }
}
