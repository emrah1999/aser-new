<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class SellerLocation extends Model
{
    protected $table = 'seller_location';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('seller_location'));
    }
}
