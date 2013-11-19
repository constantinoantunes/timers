<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('users'))
		{
			Schema::create('users', function ($table) {
				$table->increments('id');
				$table->string('username')->unique();
				$table->string('password');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('users'))
		{
			Schema::drop('users');
		}
	}

}