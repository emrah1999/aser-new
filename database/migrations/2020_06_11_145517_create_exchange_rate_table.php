<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExchangeRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exchange_rate', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('from_date');
			$table->date('to_date');
			$table->float('rate', 10, 0);
			$table->integer('from_currency_id');
			$table->integer('to_currency_id');
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
		Schema::drop('exchange_rate');
	}

}
