<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOrderGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('special_order_groups', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('group_code');
			$table->text('urls', 65535)->nullable();
			$table->integer('client_id')->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('is_paid')->default(0);
			$table->decimal('paid', 18)->default(0.00);
			$table->dateTime('paid_at')->nullable();
			$table->string('pay_id', 30)->nullable();
			$table->integer('waiting_for_payment')->default(0);
			$table->integer('last_status_id')->nullable();
			$table->dateTime('last_status_date')->nullable();
			$table->integer('operator_id')->nullable();
			$table->integer('disable')->default(0);
			$table->decimal('single_price', 18)->default(0.00);
			$table->decimal('price', 18)->nullable();
			$table->integer('currency_id')->nullable();
			$table->decimal('common_debt', 18)->default(0.00);
			$table->decimal('cargo_debt', 18)->default(0.00);
			$table->integer('debt_sms')->default(2)->comment('default 2; 0 - faild; 1 - success');
			$table->integer('placed_by')->nullable();
			$table->dateTime('placed_at')->nullable();
			$table->integer('canceled_by')->nullable();
			$table->dateTime('canceled_at')->nullable();
			$table->integer('old_order')->default(0);
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
		Schema::drop('special_order_groups');
	}

}
