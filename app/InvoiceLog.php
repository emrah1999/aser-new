<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLog extends Model
{
    protected $table = 'invoice_log';
    protected $fillable = [
        'package_id',
        'client_id',
        'invoice',
        'currency_id',
        'invoice_doc',
        'created_by',
        'status_id'
    ];
}
