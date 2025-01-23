<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('city', 50);
			$table->integer('country_id')->nullable();
			$table->string('name', 50);
			$table->string('address')->nullable();
			$table->integer('is_volume')->default(0);
			$table->string('currency_type', 4)->nullable();
			$table->string('goods_fr', 4)->nullable();
			$table->string('goods_to', 4)->nullable();
			$table->string('airport', 4);
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
		Schema::drop('locations');
	}

}
