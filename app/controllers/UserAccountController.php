<?php

class UserAccountController extends Controller {
	/**
	 * Shows the login form
	 */
	public function showLogin()
	{
		return View::make('login', array(
			'message' => Session::get('message', null),
		));
	}
	
	/**
	 * Processes login.
	 */
	public function handleAuthentication () {
		$credentials = array(
			'username' => Input::get('username'), 
			'password' => Input::get('password'),
		);
		
		if (Auth::attempt($credentials, true, true)) {
			return Redirect::to(URL::route('timers'));
		}
		
		return Redirect::to(URL::route('login'))->with('message', 'Credentials do not match. Please try again.');		
	}
	
	/**
	 * Logs the user out, and redirects to the login page.
	 */
	public function handleLogout () {
		$username = Auth::user()->username;
		Auth::logout();
		return Redirect::to(URL::route('login'))->with('message', "See you later {$username}!");
	}
	
	/**
	 * Shows the registration form.
	 */
	public function showRegistration () {
		return View::make('register', array(
			'user' => null,
		));
	}
	
	/**
	 * Processes registration.
	 */
	public function handleRegistration () {
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
		
		$user->password = Hash::make($input['password']);
		$user->save();
		
		return Redirect::to(URL::route('login'))->with('message', 'Registered! Please log in with your new account.');
	}
}
