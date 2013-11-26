<?php

use Illuminate\Database\Migrations\Migration;

class HashUserPasswords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		foreach(User::all() as $user) {
			$user->password = Hash::make($user->password);
			$user->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// This is a one-way operation.
	}

}