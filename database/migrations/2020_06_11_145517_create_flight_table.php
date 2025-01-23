<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlightTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flight', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('carrier', 3);
			$table->string('flight_number', 20);
			$table->string('awb', 15)->nullable();
			$table->string('departure', 50);
			$table->string('destination', 50);
			$table->dateTime('fact_take_off')->nullable();
			$table->dateTime('fact_arrival')->nullable();
			$table->dateTime('plan_take_off')->nullable();
			$table->dateTime('plan_arrival')->nullable();
			$table->integer('location_id');
			$table->integer('public')->default(0)->comment(' 0 - only own; 1 - public (all users)');
			$table->integer('closed_by')->nullable();
			$table->dateTime('closed_at')->nullable();
			$table->dateTime('status_in_baku_date')->nullable();
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
		Schema::drop('flight');
	}

}
