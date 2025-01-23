<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Tutorial extends Model
{
    protected $table = 'tutorials';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('tutorials'));
    }

    public function getContentAttribute($value) {
        return $this->{'content_'.App::getLocale()};
    }
}
