<?php
require_once(dirname(__FILE__) ."/../bootstrap.php");

class RokkoMVC_RequestTest extends PHPUnit_Framework_TestCase {
	public function testSetup_shouldPassTrivial() {
		$this->assertTrue(true);
	}
}
