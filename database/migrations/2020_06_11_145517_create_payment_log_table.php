<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->decimal('payment', 18);
			$table->integer('currency_id');
			$table->integer('client_id');
			$table->integer('package_id');
			$table->integer('type')->default(1)->comment('1 -cash, 2 - pos or cart, 3 - balance, 4 - by_admin');
			$table->integer('is_courier_order')->default(0)->comment('1 - yes, 0 - no');
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->date('deleted_at')->nullable();
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
		Schema::drop('payment_log');
	}

}
