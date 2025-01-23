<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('queue', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('date');
			$table->string('type', 30)->comment('c - cashier (101-399); d - delivery (401-699); i - information (701-999))');
			$table->integer('no');
			$table->integer('user_id')->nullable();
			$table->integer('location_id');
			$table->integer('used')->default(0);
			$table->integer('station')->nullable();
			$table->integer('operator_id')->nullable();
			$table->integer('operator_role')->nullable();
			$table->dateTime('used_at')->nullable();
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
		Schema::drop('queue');
	}

}
