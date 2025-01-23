<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashierLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cashier_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->decimal('payment_azn', 18);
			$table->decimal('payment_usd', 18);
			$table->decimal('added_to_balance', 18)->default(0.00)->comment('AZN');
			$table->decimal('old_balance', 18)->default(0.00)->comment('USD');
			$table->decimal('new_balance', 18)->default(0.00)->comment('USD');
			$table->integer('client_id');
			$table->string('receipt', 50);
			$table->string('type', 50)->default('MIX');
			$table->integer('created_by');
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
		Schema::drop('cashier_log');
	}

}
