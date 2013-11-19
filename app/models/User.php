<?php

use Illuminate\Auth\UserInterface;

class UnknownUser extends Exception {
	public function UnknownUser ($username) {
		parent::__construct("Unknown user '$username'");
	}
}

class User extends Eloquent implements UserInterface {
	protected $table = 'users';
	
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier() {
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {
		return $this->password;
	}
	
	/**
	 * Returns the validator for the data received.
	 * 
	 * @param Array $input
	 * @return Validator
	 */
	public static function getValidator ($input) {
		$rules = array(
			'username' => 'required|between:3,255|unique:users',
			'password' => 'required|between:8,255|confirmed',
		);
		
		return Validator::make($input, $rules);
	}

	
	/**
	 * Authenticates the specified username and password.
	 *
	 * @throwns UnknownUser
	 */
	public static function authenticate($username, $password) {
		$user = User::where(function ($query) use ($username, $password) {
			$query
				->where('username', '=', $username)
				->where('password', '=', $password);
		})->first();
		
		if ($user === Null)
		{
			throw new UnknownUser($username);
		}
		
		Auth::login($user);
		
		return $user;
	}	
}

