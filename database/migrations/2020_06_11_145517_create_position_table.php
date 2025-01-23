<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('position', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('active_tracking_log')->nullable()->default(0);
			$table->string('name', 50);
			$table->integer('location_id')->index('FK_6g0ek52nh6ky8tf8revw39w5h');
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
		Schema::drop('position');
	}

}
