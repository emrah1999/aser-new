<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_detail', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contract_id');
			$table->integer('type_id')->default(1);
			$table->string('service_name', 50);
			$table->integer('seller_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->float('from_weight', 10, 0);
			$table->float('to_weight', 10, 0);
			$table->integer('weight_control')->default(2)->comment('1 - max(volume, gross); 2 - gross');
			$table->float('rate', 10, 0)->default(0);
			$table->float('charge', 10, 0)->default(0);
			$table->integer('currency_id');
			$table->integer('destination_id');
			$table->integer('departure_id');
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('calculate_type')->nullable()->default(0);
			$table->float('console_rate', 10, 0)->nullable();
			$table->integer('priority')->nullable();
			$table->float('quantity_rate', 10, 0)->nullable();
			$table->string('type')->nullable();
			$table->integer('default_option')->default(0);
			$table->integer('is_active')->default(1);
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('country_id');
			$table->string('title_az');
			$table->string('title_en');
			$table->string('title_ru');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_detail');
	}

}
