<?php

use Illuminate\Database\Migrations\Migration;

class AddTimersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('timers'))
		{
			Schema::create('timers', function ($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				$table->string('name');
				$table->boolean('running');
				$table->bigInteger('elapsed');
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
		if (Schema::hasTable('timers'))
		{
			Schema::drop('timers');
		}
	}

}