<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('package', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('number');
			$table->string('internal_id', 10)->nullable();
			$table->bigInteger('client_id')->nullable();
			$table->string('client_name_surname')->nullable();
			$table->string('console_name', 20)->nullable();
			$table->integer('console')->nullable()->default(0);
			$table->integer('width')->nullable()->default(0);
			$table->integer('height')->nullable()->default(0);
			$table->integer('length')->nullable()->default(0);
			$table->decimal('volume_weight', 18, 3)->default(0.000);
			$table->decimal('gross_weight', 18, 3)->nullable()->default(0.000);
			$table->integer('chargeable_weight')->default(1)->comment('1-gross, 2-volume');
			$table->decimal('total_charge_value', 18)->nullable()->default(0.00)->comment('items price total');
			$table->decimal('amount_usd', 18)->nullable()->default(0.00);
			$table->decimal('paid', 18)->default(0.00);
			$table->integer('paid_status')->default(0);
			$table->integer('payment_type_id')->nullable();
			$table->decimal('common_debt', 18)->default(0.00);
			$table->decimal('cargo_debt', 18)->default(0.00);
			$table->string('payment_receipt', 100)->nullable();
			$table->dateTime('payment_receipt_date')->nullable();
			$table->string('unit')->nullable()->default('kg');
			$table->integer('currency_id')->nullable();
			$table->integer('email_id')->nullable();
			$table->integer('seller_id')->nullable()->default(0);
			$table->string('other_seller')->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('departure_id')->nullable();
			$table->integer('destination_id')->nullable()->default(1)->comment('default Baku');
			$table->integer('used_contract_detail_id')->nullable();
			$table->integer('last_status_id')->default(1);
			$table->dateTime('last_status_date')->nullable();
			$table->integer('container_id')->nullable();
			$table->integer('last_container_id')->nullable();
			$table->integer('position_id')->nullable();
			$table->string('description', 5000)->nullable();
			$table->string('remark', 5000)->nullable();
			$table->integer('tariff_type_id')->nullable()->default(1);
			$table->integer('is_warehouse')->default(0)->comment('0 - anbarda qebul edilmeyib; 1 - xarici anbarda; 2- xarici anbardan cixib, 3 - bakida');
			$table->dateTime('on_the_way_date')->nullable();
			$table->integer('in_baku')->default(0)->comment('0 - not in baku; 1 - in baku');
			$table->dateTime('in_baku_date')->nullable();
			$table->dateTime('customs_date')->nullable();
			$table->integer('customs_notification')->default(0);
			$table->integer('received_by')->nullable();
			$table->dateTime('received_at')->nullable();
			$table->integer('collected_by')->nullable();
			$table->dateTime('collected_at')->nullable();
			$table->integer('delivered_by')->nullable();
			$table->dateTime('delivered_at')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('batch_id')->nullable();
			$table->integer('sms_sent')->nullable()->default(2)->comment('default 2; 0 - faild; 1 - success');
			$table->dateTime('sms_sent_date')->nullable();
			$table->integer('sms_no_invoice')->default(2)->comment('	default 2; 0 - faild; 1 - success');
			$table->integer('anonymous_merge_operator_id')->nullable();
			$table->integer('courier_order_id')->nullable();
			$table->integer('has_courier')->default(0);
			$table->integer('has_courier_by')->nullable();
			$table->dateTime('has_courier_at')->nullable();
			$table->string('has_courier_type', 1000)->nullable();
			$table->integer('courier_by')->nullable();
			$table->dateTime('courier_at')->nullable();
			$table->dateTime('issued_to_courier_date')->nullable();
			$table->timestamps();
			$table->integer('updated_by')->nullable();
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
		Schema::drop('package');
	}

}
