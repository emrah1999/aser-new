<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContainerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('container', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('flight_id')->nullable();
			$table->integer('awb_id')->nullable();
			$table->integer('departure_id')->nullable();
			$table->integer('destination_id')->nullable();
			$table->integer('public')->default(0);
			$table->dateTime('close_date')->nullable();
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
		Schema::drop('container');
	}

}
