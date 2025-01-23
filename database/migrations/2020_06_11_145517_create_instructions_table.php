<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstructionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('instructions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->text('title_az', 65535);
			$table->text('content_az', 65535);
			$table->text('title_en', 65535);
			$table->text('content_en', 65535);
			$table->text('title_ru', 65535);
			$table->text('content_ru', 65535);
			$table->text('img', 65535);
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
		Schema::drop('instructions');
	}

}
