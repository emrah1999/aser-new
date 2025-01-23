<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProhibitedItem extends Model
{
    protected $table = 'prohibited_items';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('prohibited_items'));
    }

    public function getItemAttribute($value) {
        return $this->{'item_'.App::getLocale()};
    }
}
