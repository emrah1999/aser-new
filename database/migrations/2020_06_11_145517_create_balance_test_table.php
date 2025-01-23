<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalanceTestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balance_test', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('client_id');
			$table->decimal('amount_azn', 18);
			$table->decimal('amount_usd', 18);
			$table->dateTime('date');
			$table->integer('order_id');
			$table->string('packages', 1000);
			$table->string('ip', 50)->nullable();
			$table->decimal('old_balance', 18);
			$table->decimal('new_balance', 18);
			$table->integer('negative')->default(0);
			$table->string('phone', 50);
			$table->integer('payment_id');
			$table->string('payment_key', 500);
			$table->string('cart', 100);
			$table->string('response_str', 1000);
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
		Schema::drop('balance_test');
	}

}
