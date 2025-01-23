<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_task', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('type', 50)->default('in_baku');
			$table->string('code', 10)->nullable();
			$table->string('task_id', 30)->nullable();
			$table->string('control_id', 30)->nullable();
			$table->integer('package_id')->nullable();
			$table->integer('client_id')->nullable();
			$table->string('number', 20)->nullable();
			$table->string('message', 1000)->nullable();
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
		Schema::drop('sms_task');
	}

}
