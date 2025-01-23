<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class StoreCategory extends Model
{
    protected $table = 'store_category';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('store_category'));
    }

    public function getNameAttribute($value) {
        return $this->{'name_'.App::getLocale()};
    }
}
