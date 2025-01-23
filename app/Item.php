<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'package_id',
        'category_id',
        'price',
        'price_usd',
        'currency_id',
        //'quantity',
        'title',
        'invoice_doc',
        'invoice_uploaded_date',
        'invoice_confirmed',
        'invoice_status',
        'created_by',
        'subCat'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('item'));
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
