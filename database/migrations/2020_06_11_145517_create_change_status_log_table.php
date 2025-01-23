<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChangeStatusLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('change_status_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('package_id');
			$table->integer('old_status_id');
			$table->integer('new_status_id');
			$table->string('remark')->nullable();
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
		Schema::drop('change_status_log');
	}

}
