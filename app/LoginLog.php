<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $fillable = [
        'user_id',
        'role_id',
        'ip',
        'type'
    ];
}
