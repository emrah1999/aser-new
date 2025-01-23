<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSellerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seller', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('img')->nullable();
			$table->string('name')->nullable();
			$table->string('title');
			$table->string('url')->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('in_home')->default(0);
			$table->integer('has_site')->default(1);
			$table->integer('by_client')->default(0);
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
		Schema::drop('seller');
	}

}
