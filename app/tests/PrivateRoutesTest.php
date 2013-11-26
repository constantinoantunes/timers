<?php

class PrivateRoutesTest extends TestCase {
	public function setUp () {
		parent::setUp();
		
	}
	public function testBase () {
		$this->call('GET', '/');
	}
}
