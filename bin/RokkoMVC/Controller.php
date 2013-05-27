<?php
namespace Rokko;

abstract class Controller {
	private $request;
	private $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function getRequest() {
		return $this->request;
	}

	public function getResponse() {
		return $this->response;
	}

	public function init() {
		// Set default view
		$defView = $this->request->getController()."/".$this->request->getAction();
		$this->response->setView($defView);
	}
}
