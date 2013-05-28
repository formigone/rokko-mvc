<?php
namespace Rokko;

class App {
	protected $version = "1.0.0";
	protected $appConfig;
	protected $rokkoConfig;
	protected $request;
	protected $response;
	protected $isRunning;

	public function __construct(Request $request, Response $response, Array $appConfig, Array $rokkoConfig) {
		$this->request = $request;
		$this->response = $response;
		$this->appConfig = $appConfig;
		$this->rokkoConfig = $rokkoConfig;

		$this->isRunning = false;
	}

	public function getVersion() {
		return $this->version;
	}

	public function run() {
		if ($this->isRunning) {
			return false;
		}

		// Prevent this method from being invoked more than once per execution
		$this->isRunning = true;

		// Use app config to determine controller namespace
		$namespace = "";
		if (isset($this->appConfig["controller_namespace"]) && $this->appConfig["controller_namespace"] != "") {
			$namespace = "\\{$this->appConfig["controller_namespace"]}\\";
		}

		$controllerClass = $namespace.$this->getController($this->request->getController());
		$controller = new $controllerClass($this->request, $this->response, $this);
		$action = $this->getAction($this->request->getAction());

		$controller->init();
		$controller->$action();
		$this->response->render();
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
		return $this->convertUriComponent($uri).$this->rokkoConfig["controller_class_postfix"];
	}

	protected function getAction($uri) {
		return $this->convertUriComponent($uri).$this->rokkoConfig["controller_action_postfix"];
	}

	public function getAppConfig() {
		return $this->appConfig;
	}

	public function getDefaultDatabase() {
		return $this->appConfig["default_database"];
	}
}
