<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLbStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lb_status', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('status_en', 50);
			$table->string('status_az', 50);
			$table->string('status_ru', 50);
			$table->string('color', 50);
			$table->integer('for_collector')->default(0);
			$table->integer('for_special_order')->default(0);
			$table->integer('for_courier')->default(0);
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
		Schema::drop('lb_status');
	}

}
