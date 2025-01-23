<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientsLog extends Model
{
    protected $table = 'clients_log';
    protected $fillable = [
        'type', //add, update etc.
        'client_id',
        'request',
	'current',
        'role_id',
        'created_by'
    ];
}
