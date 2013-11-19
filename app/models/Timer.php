<?php

class Timer extends Eloquent {
	protected $table = 'timers';
	protected $isNull = False;
	
	const STATE_STOPPED = 'stopped';
	const STATE_RUNNING = 'running';
	
	/**
	 * Returns Timer instance per id, with user context.
	 * If the timer is not found or belongs to another user, returns a NullTimer instead.
	 * 
	 * @param Integer $id
	 * @return Timer
	 */
	public static function getId($id) {
		$timer = self::where(function($query) use ($id) {
			$query
			->where('user_id', '=', Auth::user()->id)
			->where('id', '=', $id);
		})->first();
		
		if (!empty($timer))
		{
			return $timer;
		}
		
		return new NullTimer;
	}
	
	/**
	 * Returns the validator for the data received.
	 * 
	 * @param Array $input
	 * @return Validator
	 */
	public static function getValidator ($input) {
		$rules = array('name' =>'required|between:3,255');
		return Validator::make($input, $rules);
	}
	
	/**
	 * Returns the total elapsed time since timer start.
	 * 
	 * @return Integer
	 */
	public function getTotalElapsed()
	{
		if (!$this->running)
		{
			return $this->elapsed;
		}
		
		return $this->elapsed + $this->getElapsedSinceLastStart();
	}
	
	/**
	 * Returns the current state name.
	 * 
	 * @return String
	 */
	public function getStateName()
	{
		if ($this->running)
		{
			return self::STATE_RUNNING;	
		}
		
		return self::STATE_STOPPED;
	}
	
	/**
	 * Sets the timer as running.
	 *
	 * @return Boolean
	 */
	public function start()
	{
		$this->running = true;
		$this->save();
		return true;
	}
	
	/**
	 * Sets the timer as stopped and updates the elapsed time.
	 *
	 * @return Boolean
	 */
	public function stop()
	{
		$this->running = false;
		$this->elapsed += $this->getElapsedSinceLastStart();
		$this->save();
		return true;
	}
	
	/**
	 * Returns the time elapsed since last model update
	 * 
	 * @return Integer
	 */
	private function getElapsedSinceLastStart ()
	{
		return (time() - strtotime($this->updated_at));
	}	
}

/**
 * Null timer subclass.
 * This way, the validation of timer execution given its id is done in User::getId
 */
class NullTimer extends Timer {
	protected $isNull = True;
	
	public function start() {
		return false;
	}
	public function stop() {
		return false;
	}
}
