<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ContractDetail extends Model
{
    protected $table = 'contract_detail';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('contract_detail'));
    }

    public function country() {
        return $this -> belongsTo('App\Country');
    }

    public function getTitleAttribute($value) {
        return $this->{'title_'.App::getLocale()};
    }
}
