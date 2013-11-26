<?php

class PublicRoutesTest extends TestCase {
	public function testGetViews ()
	{
		$this->call('GET', route('login'));
		$this->assertResponseOk();
		
		$this->call('GET', route('register'));
		$this->assertResponseOk();
	}
	
	public function testFailedLogin () {
		$authentication = array(
			'username' => 'aaa',
			'password' => 'Xaaaaaaaa',
		);
		
		$this->call('POST', route('authenticate'), $authentication);
		$this->assertRedirectedToRoute('login');
	}
	
	public function testSuccessfulLogin () {
		$authentication = array(
			'username' => 'aaa',
			'password' => 'aaaaaaaa',
		);
		
		$this->call('POST', route('authenticate'), $authentication);
		$this->assertRedirectedToRoute('timers');
	}
}
