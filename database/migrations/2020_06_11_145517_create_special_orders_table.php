<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('special_orders', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('url', 1000);
			$table->integer('quantity');
			$table->decimal('single_price', 18)->default(0.00);
			$table->decimal('price', 18);
			$table->decimal('common_debt', 18)->nullable()->default(0.00);
			$table->decimal('cargo_debt', 18)->nullable()->default(0.00);
			$table->string('color', 100)->nullable();
			$table->string('size', 100)->nullable();
			$table->string('description', 1000)->nullable();
			$table->integer('last_status_id')->nullable();
			$table->dateTime('last_status_date')->nullable();
			$table->string('group_code')->nullable();
			$table->dateTime('accepted_at')->nullable();
			$table->integer('package_id')->nullable()->comment('sifarislere dusdukden sonra');
			$table->dateTime('declarated_at')->nullable()->comment('sifarislere dusdukden sonra');
			$table->integer('canceled_by')->nullable();
			$table->dateTime('canceled_at')->nullable();
			$table->string('order_number', 500)->nullable();
			$table->integer('placed_by')->nullable();
			$table->dateTime('placed_at')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('col_user_id')->nullable();
			$table->integer('col_id')->nullable();
			$table->integer('col_status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('special_orders');
	}

}
