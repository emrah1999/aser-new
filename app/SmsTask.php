<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsTask extends Model
{
    protected $table = 'sms_task';
    protected $fillable = [
        'type',
        'code',
        'task_id',
        'control_id',
        'package_id',
        'client_id',
        'number',
        'message',
        'created_by'
    ];
}
