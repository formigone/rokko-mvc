<?php
class AppController extends \Rokko\Controller {
	public function indexExec() {
		$this->setData("name", "Rodrigo");

		$items = array(
				"Build Database abstraction",
				"Use Database module",
				"Buy domain for framework",
				"Document framework",
				"Outline book",
				"Contact Packt"
		);

		$this->setData("todo", $items);

		$resp = $this->getResponse();
		$resp->setLayout("main");
	}
}