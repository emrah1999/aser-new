<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDebtsLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debts_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('type', 3)->comment('in - borc teyin olundu, out - borc odenildi');
			$table->integer('client_id');
			$table->integer('order_id');
			$table->decimal('cargo', 18)->default(0.00);
			$table->decimal('common', 18)->default(0.00);
			$table->decimal('old_common', 18)->default(0.00);
			$table->decimal('old_cargo', 18)->default(0.00);
			$table->decimal('new_common', 18)->default(0.00);
			$table->decimal('new_cargo', 18)->default(0.00);
			$table->integer('operator_id')->nullable();
			$table->integer('created_by')->nullable();
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
		Schema::drop('debts_log');
	}

}
