<?php

/*
 * The home page. Shows a login only.
 */
Route::get('/', array('as' => 'login', 
function () {
	return View::make('login', array(
		'message' => Session::get('message', null),
	));
}));

/*
 * Login form post handler.
 * Authenticates the user, or warns about credentials being wrong.
 */
Route::post('/authenticate', array('as' => 'authenticate',
function () {
	$input = Input::only('username', 'password');
	
	try {
		User::authenticate($input['username'], $input['password']);
	}
	catch (UnknownUser $e) {
		return Redirect::to(URL::route('login'))->with('message', 'Credentials do not match. Please try again.');
	}
	
	return Redirect::to(URL::route('timers'));
}));

/*
 * Renders the registration view.
 */
Route::get('/register', array('as' => 'register', 
function () {
	return View::make('register', array('user' => null));
}));

/*
 * Registration post handler.
 * Validates and creates the user.
 */
Route::post('/register',
function () {
	$input = Input::only('username', 'password', 'password_confirmation');
	$validator = User::getValidator($input);
	
	$user = new User;
	$user->username = $input['username'];
	
	if ($validator->fails())
	{
		return View::make('register', array(
			'errors' => $validator->messages(),
			'user' => $user,
		));
	}
	
	$user->password = $input['password'];
	$user->save();
	
	return Redirect::to(URL::route('login'))->with('message', 'Registered! Please log in with your new account.');
});

/*
 * Renders the timers dashboard view.
 */
Route::get('/timers', array('as' => 'timers', 
function () {
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
}));

/*
 * Logs the user out, and redirects to the login page.
 */
Route::get('/logout', array('as' => 'logout',
function () {
	$username = Auth::user()->username;
	Auth::logout();
	return Redirect::to(URL::route('login'))->with('message', "See you later {$username}!");
}));

/*
 * Renders the timer creation view.
 */
Route::get('/create', array('as' => 'create-timer',
function () {
	return View::make('create-timer', array(
		'timer' => null,
	));
}));

/*
 * Timer creation post handler.
 * Validates and creates the timer.
 */
Route::post('/create',
function () {
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
});

/*
 * Timer start handler.
 */
Route::post('/start', array('as' => 'start-timer', 
function () {
	$timer = Timer::getId(Input::get('id'));
	return Response::json($timer->start());
}));

/*
 * Timer stop handler.
 */
Route::post('/stop', array('as' => 'stop-timer', 
function () {
	$timer = Timer::getId(Input::get('id'));
	return Response::json(array(
		'result'  => $timer->stop(),
		'elapsed' => $timer->elapsed,
	));
}));
