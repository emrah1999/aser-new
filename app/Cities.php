<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Cities extends Model
{
    protected $table = 'cities';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('cities'));
    }
}
