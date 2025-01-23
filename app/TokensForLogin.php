<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokensForLogin extends Model
{
	protected $table = 'tokens_for_login';
	protected $fillable = [
			'token',
			'client_id',
			'created_time',
			'created_by'
	];
}
