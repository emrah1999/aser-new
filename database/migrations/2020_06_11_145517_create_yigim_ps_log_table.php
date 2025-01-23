<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateYigimPsLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('yigim_ps_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('client_id');
			$table->string('receipt_no');
			$table->decimal('amount', 18)->comment('AZN');
			$table->decimal('amount_usd', 18)->comment('USD');
			$table->string('platform')->comment('million, emanat etc.');
			$table->integer('time');
			$table->integer('checked')->default(0)->comment('checked by yigim');
			$table->dateTime('checked_at')->nullable();
			$table->integer('status')->default(0)->comment('0 - unsuccess, 1 - success');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('yigim_ps_log');
	}

}
