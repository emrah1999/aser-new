<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourierAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courier_areas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('zone_id');
			$table->string('name_en');
			$table->string('name_az');
			$table->string('name_ru');
			$table->decimal('tariff', 18);
			$table->integer('active')->default(1);
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
		Schema::drop('courier_areas');
	}

}
