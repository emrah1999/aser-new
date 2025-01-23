<?php

namespace App;

use App\Scopes\DeletedScope;
use App\Scopes\SellersOnlyCollectorScope;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'seller';
//    protected $fillable = [
//        'name',
//        'by_client',
//        'created_by'
//    ];

//    public function seller_category()
//    {
//        return $this -> belongsTo('App\SellerCategory', 'id');
//    }
//
//    public function seller_location()
//    {
//        return $this -> belongsTo('App\SellerLocation', 'id');
//    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('seller'));

        static::addGlobalScope(new SellersOnlyCollectorScope());
    }

}

