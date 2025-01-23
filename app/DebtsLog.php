<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebtsLog extends Model
{
    protected $table = 'debts_log';

    protected $fillable = [
        'type', // in - borc teyin olundu, out - borc odenildi
        'client_id',
        'order_id',
        'cargo',
        'common',
        'old_cargo',
        'old_common',
        'new_cargo',
        'new_common',
        'created_by'
    ];
}
