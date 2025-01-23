<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTutorialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tutorials', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->text('img', 65535);
			$table->text('video', 65535);
			$table->string('content_az', 512)->nullable();
			$table->string('content_en', 512);
			$table->string('content_ru', 512);
			$table->integer('created_by');
			$table->integer('deleted_by')->nullable();
			$table->softDeletes();
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
		Schema::drop('tutorials');
	}

}
