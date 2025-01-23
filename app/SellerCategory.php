<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class SellerCategory extends Model
{
    protected $table = 'seller_category';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('seller_category'));
    }
}
