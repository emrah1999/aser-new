<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;

class PackageStatus extends Model
{
    protected $table = 'package_status';
    protected $fillable = [
        'package_id',
        'status_id',
        'created_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('package_status'));
    }
}
