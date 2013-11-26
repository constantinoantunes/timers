<?php

use Illuminate\Auth\UserInterface;

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
	 * Get a timer belonging to this user, given its id.
	 * If the timer can not be found, a NullTimer is given instead.
	 * 
	 * @throws UnknownTimerException
	 * @param Integer $id
	 * @return Timer
	 */
	public function getTimer($id) {
		$timer = Timer::where(function($query) use ($id) {
			$query
			->where('user_id', '=', $this->id)
			->where('id', '=', $id);
		})->first();
		
		if (!empty($timer))
		{
			return $timer;
		}
		
		throw new UnknownTimerException($id, $this->id);
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
}
