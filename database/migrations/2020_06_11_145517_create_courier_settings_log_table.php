<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourierSettingsLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courier_settings_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('daily_limit');
			$table->time('closing_time');
			$table->decimal('amount_for_urgent', 18);
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
		Schema::drop('courier_settings_log');
	}

}
