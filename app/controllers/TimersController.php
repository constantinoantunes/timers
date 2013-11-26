<?php

class TimersController extends Controller {
	/**
	 * Renders the timers dashboard view.
	 */
	public function showDashboard () {
		$timers = Timer::where('user_id', '=', Auth::user()->id)->get();
		$totalTime = array_reduce($timers->all(), function ($total, $timer) {
			$total += $timer->elapsed;
			return $total;
		});
		return View::make('timers', array(
			'user' => Auth::user(),
			'timers' => $timers,
			'totalTime' => $totalTime,
		));
	}
	
	/**
	 * Renders the timer creation view.
	 */
	public function showCreate () {
		return View::make('create-timer', array(
			'timer' => null,
		));
	}
	
	/**
	 * Timer creation post handler.
	 * Validates and creates the timer.
	 */
	function handleCreate () {
		$input = Input::only('name');
		$validator = Timer::getValidator($input);
		
		$timer = new Timer;
		$timer->name = $input['name'];
		$timer->user_id = Auth::user()->id;
			
		if ($validator->fails())
		{
			return View::make('create-timer', array(
				'timer' => $timer,
			));
		}
		
		$timer->save();
		
		return Redirect::to(URL::route('timers'));
	}
	
	/**
	 * Timer start handler.
	 */
	function handleStart () {
		try{
			$timer = Auth::user()->getTimer(Input::get('id'));
		}
		catch (UnknownTimerException $e) {
			return Response::json(false);
		}
		return Response::json($timer->start());
	}
	
	/**
	 * Timer stop handler.
	 */
	function handleStop () {
		try {
			$timer = Auth::user()->getTimer(Input::get('id'));
		}
		catch (UnknownTimerException $e) {
			return Response::json(false);
		}
		return Response::json(array(
			'result'  => $timer->stop(),
			'elapsed' => $timer->elapsed,
		));
	}
}
