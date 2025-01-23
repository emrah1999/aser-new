<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailListContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_list_content', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 30);
			$table->string('title_az', 500);
			$table->string('subject_az', 500);
			$table->text('content_az', 65535);
			$table->string('list_inside_az', 500);
			$table->string('content_bottom_az', 500);
			$table->string('button_name_az');
			$table->string('sms_az', 500);
			$table->string('title_en', 500);
			$table->string('subject_en', 500);
			$table->text('content_en', 65535);
			$table->string('list_inside_en', 500);
			$table->string('content_bottom_en', 500);
			$table->string('button_name_en');
			$table->string('sms_en', 500);
			$table->string('title_ru', 500);
			$table->string('subject_ru', 500);
			$table->text('content_ru', 65535);
			$table->string('list_inside_ru', 500);
			$table->string('content_bottom_ru', 500);
			$table->string('button_name_ru');
			$table->string('sms_ru', 500);
			$table->string('button_link');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_list_content');
	}

}
