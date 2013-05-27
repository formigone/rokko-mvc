<?php
class IndexController extends \Rokko\Controller {
	public function indexExec() {
		$resp = $this->getResponse();
		$resp->setLayout("main");
	}
}
