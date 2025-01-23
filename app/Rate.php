<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'exchange_rate';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('exchange_rate'));
    }
}
