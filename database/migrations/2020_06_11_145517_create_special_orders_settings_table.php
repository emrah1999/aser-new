<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOrdersSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('special_orders_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('active')->default(1);
			$table->integer('percent');
			$table->integer('has_campaign')->default(0);
			$table->text('campaign_az', 65535);
			$table->text('campaign_en', 65535);
			$table->text('campaign_ru', 65535);
			$table->text('message_az', 65535);
			$table->text('message_en', 65535);
			$table->text('message_ru', 65535);
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
		Schema::drop('special_orders_settings');
	}

}
