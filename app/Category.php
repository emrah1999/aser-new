<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    protected $table = 'category';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('category'));
    }

    public function getNameAttribute($value) {
        return $this->{'name_'.App::getLocale()};
    }
}
