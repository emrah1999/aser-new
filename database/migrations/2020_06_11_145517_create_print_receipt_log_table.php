<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrintReceiptLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('print_receipt_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('text', 65535);
			$table->integer('status')->comment('1 - success; 0 - error');
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
		Schema::drop('print_receipt_log');
	}

}
