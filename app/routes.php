<?php

/*
 * Login and logout handling
 */
Route::get('/', array('as' => 'login', 'uses' => 'UserAccountController@showLogin'));
Route::post('/authenticate', array('as' => 'authenticate', 'uses' => 'UserAccountController@handleAuthentication'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'UserAccountController@handleLogout'));

/*
 * Registration view and handling
 */
Route::get('/register', array('as' => 'register', 'uses' => 'UserAccountController@showRegistration'));
Route::post('/register', 'UserAccountController@handleRegistration');

/*
 * Timer dashboard and management
 */
Route::get('/timers', array('as' => 'timers', 'uses' => 'TimersController@showDashboard'));
Route::get('/create', array('as' => 'create-timer', 'uses' => 'TimersController@showCreate'));
Route::post('/create', 'TimersController@handleCreate');
Route::post('/start', array('as' => 'start-timer', 'uses' => 'TimersController@handleStart'));
Route::post('/stop', array('as' => 'stop-timer', 'uses' => 'TimersController@handleStop'));
