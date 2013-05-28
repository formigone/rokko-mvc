<?php
namespace Rokko;

abstract class Controller {
	private $request;
	private $response;
	private $context;

	public function __construct(Request $request, Response $response, App $context) {
		$this->request = $request;
		$this->response = $response;
		$this->context = $context;
	}

	public function getRequest() {
		return $this->request;
	}

	public function getResponse() {
		return $this->response;
	}

	public function getContext() {
		return $this->context;
	}

	public function setData($key, $val) {
		$this->response->addViewData($key, $val);
	}

	public function init() {
		// Set default view
		$defView = $this->request->getController()."/".$this->request->getAction();
		$this->response->setView($defView);
	}
}
