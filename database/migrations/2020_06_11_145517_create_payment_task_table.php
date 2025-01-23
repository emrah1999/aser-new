<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_task', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('payment_key', 100);
			$table->integer('status')->default(0);
			$table->integer('is_paid')->default(0);
			$table->string('response_code', 2)->nullable();
			$table->string('response_code_description')->nullable();
			$table->string('response_rc', 3)->nullable();
			$table->string('response_rc_description')->nullable();
			$table->string('pan', 50)->nullable();
			$table->string('amount', 10)->nullable();
			$table->string('response_str', 1000)->nullable();
			$table->string('type', 10)->comment('millikart, paytr');
			$table->string('payment_type')->nullable()->comment('balance, courier, special_order');
			$table->integer('order_id')->nullable()->comment('courier_order_id');
			$table->string('packages', 1000)->nullable()->comment('for courier');
			$table->string('ip_address', 30)->nullable();
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
		Schema::drop('payment_task');
	}

}
