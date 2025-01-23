<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('contract'));
    }
}
