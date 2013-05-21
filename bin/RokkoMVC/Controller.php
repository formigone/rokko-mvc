<?php
namespace Rokko;

abstract class Controller {
	protected $request;
	protected $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function init() {}
}
