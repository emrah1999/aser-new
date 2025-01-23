<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalanceLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balance_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('payment_code', 20);
			$table->decimal('amount', 18);
			$table->decimal('amount_azn', 18);
			$table->integer('client_id');
			$table->string('status', 3)->comment('in, out');
			$table->string('type', 10)->comment('cash, cart, balance, back,manual');
			$table->string('platform')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('balance_log');
	}

}
