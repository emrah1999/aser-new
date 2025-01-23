<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProhibitedItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prohibited_items', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('country_id');
			$table->text('item_az', 65535);
			$table->text('item_en', 65535);
			$table->text('item_ru', 65535);
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
		Schema::drop('prohibited_items');
	}

}
