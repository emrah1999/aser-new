<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('parent_id')->nullable()->comment('client');
			$table->integer('referral_unconfirm')->nullable();
			$table->string('name');
			$table->string('surname');
			$table->string('username')->nullable();
			$table->string('password');
			$table->string('first_pass')->nullable();
			$table->string('email')->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('image')->nullable()->comment('client');
			$table->string('city')->nullable()->comment('client (not null)');
			$table->string('address1')->nullable()->comment('client (not null)');
			$table->string('address2', 100)->nullable()->comment('client ');
			$table->string('address3', 100)->nullable()->comment('client ');
			$table->string('zip1', 30)->nullable()->comment('client (not null)');
			$table->string('zip2', 30)->nullable()->comment('client ');
			$table->string('zip3', 30)->nullable()->comment('client ');
			$table->string('phone1', 30);
			$table->string('phone2', 30)->nullable()->comment('client ');
			$table->string('phone3', 30)->nullable()->comment('client ');
			$table->string('passport_series', 10)->nullable()->comment('client (not null)');
			$table->string('passport_number', 20)->nullable()->comment('client  (not null)');
			$table->string('passport_fin', 15)->nullable();
			$table->date('birthday')->nullable()->comment('client (not null)');
			$table->integer('gender')->nullable()->comment('client (1-male, 2-female)');
			$table->string('language', 50)->nullable()->comment('client (not null)');
			$table->string('suite', 10)->default('C')->comment('client (not null)');
			$table->decimal('balance', 18)->nullable()->default(0.00);
			$table->decimal('cargo_debt', 18)->nullable()->default(0.00);
			$table->decimal('common_debt', 18)->nullable()->default(0.00);
			$table->integer('console_limit')->nullable()->default(0)->comment('client');
			$table->string('console_option', 15)->nullable()->comment('client');
			$table->integer('contract_id')->nullable()->comment('client');
			$table->integer('packing_service_id')->nullable()->comment('client (not null)');
			$table->integer('destination_id')->nullable()->comment('operator (not null)');
			$table->string('remember_token', 100)->nullable();
			$table->integer('role_id');
			$table->integer('client_sent_sms')->nullable()->default(1)->comment(' 0 -  sms gonderme, 1 - sms gonder');
			$table->string('token')->nullable();
			$table->integer('last_active_time')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('col_id')->nullable();
			$table->integer('col_parent_id')->nullable();
			$table->decimal('removed_balance', 18)->nullable();
			$table->decimal('old_balance', 18)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
