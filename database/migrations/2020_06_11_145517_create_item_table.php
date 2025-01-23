<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category_id')->nullable();
			$table->string('code', 50)->nullable();
			$table->decimal('price', 18)->nullable()->default(0.00);
			$table->decimal('price_usd', 18)->nullable()->default(0.00);
			$table->integer('currency_id')->nullable();
			$table->string('invoice_doc')->nullable();
			$table->integer('invoice_confirmed')->default(0);
			$table->integer('quantity')->default(1);
			$table->string('title', 1000)->nullable();
			$table->integer('package_id');
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('order_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item');
	}

}
