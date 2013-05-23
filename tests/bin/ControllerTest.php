<?php
require_once("./PHPUnit/Autoload.php");

class RokkoMVC_ControllerTest extends PHPUnit_Framework_TestCase {
	public function testSetup_shouldPassTrivial() {
		$this->assertTrue(true);
	}
}