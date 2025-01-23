<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourierOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courier_orders', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('packages', 1000)->comment('id1,id2.....');
			$table->integer('client_id');
			$table->integer('courier_id')->nullable();
			$table->date('date');
			$table->integer('area_id');
			$table->integer('metro_station_id')->nullable();
			$table->text('address', 65535);
			$table->string('phone', 30);
			$table->string('remark', 1000)->nullable();
			$table->integer('last_status_id')->default(1);
			$table->dateTime('last_status_date')->nullable();
			$table->decimal('amount', 18)->comment('AZN');
			$table->decimal('paid', 18)->default(0.00)->comment('AZN');
			$table->integer('is_paid')->default(0);
			$table->decimal('delivery_amount', 18)->default(0.00);
			$table->decimal('total_amount', 18)->default(0.00)->comment('courier + delivery');
			$table->string('payment_key')->nullable();
			$table->integer('courier_payment_type_id');
			$table->integer('delivery_payment_type_id');
			$table->integer('urgent')->default(0);
			$table->dateTime('print_date')->nullable();
			$table->integer('collected_by')->nullable();
			$table->dateTime('collected_at')->nullable()->comment('kuryere verilme vaxti');
			$table->dateTime('delivered_at')->nullable();
			$table->dateTime('canceled_at')->nullable();
			$table->integer('canceled_by')->nullable();
			$table->integer('created_by');
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
		Schema::drop('courier_orders');
	}

}
