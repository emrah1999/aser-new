<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('package_id')->nullable();
			$table->integer('client_id')->nullable();
			$table->decimal('invoice', 18)->nullable();
			$table->integer('currency_id')->nullable();
			$table->string('invoice_doc', 1000)->nullable();
			$table->integer('created_by')->nullable();
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
		Schema::drop('invoice_log');
	}

}
