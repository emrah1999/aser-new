<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('position', function(Blueprint $table)
		{
			$table->foreign('location_id', 'FK_6g0ek52nh6ky8tf8revw39w5h')->references('id')->on('locations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('position', function(Blueprint $table)
		{
			$table->dropForeign('FK_6g0ek52nh6ky8tf8revw39w5h');
		});
	}

}
