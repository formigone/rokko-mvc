<?php
require_once("./PHPUnit/Autoload.php");
require_once("./bootstrap.php");

class RokkoMVC_ResponseTest extends PHPUnit_Framework_TestCase {
	public function testSetup_shouldPassTrivial() {
		$this->assertTrue(true);
	}
}