<?php
namespace Rokko;

class App {
	protected $version = "1.0.0";
	protected $config;
	protected $request;
	protected $respose;

	public function __construct(Request $request, Response $response, Array $config) {
		$this->request = $request;
		$this->respose = $response;
		$this->config = $config;
	}

	public function getVersion() {
		return $this->version;
	}

	public function run() {
		// Use config to determine controller namespace
		$controllerClass = $this->getController($this->request->getController());
		$controller = new $controllerClass($this->request, $this->respose);
		$action = $this->getAction($this->request->getAction());

		$controller->init();
		$controller->$action();
	}

	protected function convertUriComponent($uri) {
		$parts = explode("-", $uri);
		$controller = "";

		foreach ($parts as $part) {
			$controller .= ucfirst($part);
		}

		return $controller;
	}

	protected function getController($uri) {
		return $this->convertUriComponent($uri)."Controller";
	}

	protected function getAction($uri) {
		return $this->convertUriComponent($uri)."Exec";
	}
}
