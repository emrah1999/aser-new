<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDangerousGoodsSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dangerous_goods_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('text_az', 65535);
			$table->text('text_en', 65535);
			$table->text('text_ru', 65535);
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
		Schema::drop('dangerous_goods_settings');
	}

}
