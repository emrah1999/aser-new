<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Instruction extends Model
{
    protected $table = 'instructions';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('instructions'));
    }

    public function getTitleAttribute($value) {
        return $this->{'title_'.App::getLocale()};
    }

    public function getContentAttribute($value) {
        return $this->{'content_'.App::getLocale()};
    }
}
