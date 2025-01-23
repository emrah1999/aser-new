<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name_en', 50);
			$table->string('name_az', 50);
			$table->string('name_ru', 50);
			$table->string('code', 5)->nullable();
			$table->string('flag')->nullable();
			$table->string('image')->nullable();
			$table->integer('currency_id')->nullable();
			$table->integer('local_currency')->default(1);
			$table->integer('url_permission')->default(0)->comment('saytdan link ile sifaris vermek');
			$table->integer('sort')->default(0);
			$table->string('currency_type', 4)->nullable();
			$table->string('goods_fr', 4)->nullable();
			$table->string('goods_to', 4)->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('col_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}
