<?php
namespace Rokko;

class Response {
	private $view;
	private $layout;
	private $data;
	private $defaultViewValues;
	private $config;

	public function __construct($config) {
		$this->config = $config;
		$this->defaultViewValues = $config["app_root"];
		$this->data = array();
	}

	public function getView($view, $data) {
		$view = APP_PATH."/{$this->config["view_path"]}/{$view}.{$this->config["view_extension"]}";
		return $this->loadView($view, $data);
	}

	private function loadView($view, $data) {
		if (!file_exists($view)) {
			throw new \Exception("View {$view} not found");
		}

		// Convert data into object so items can be accessed with -> operator
		if (is_array($data)) {
			$obj = new \stdClass();

			if (array_key_exists("config", $data)) {
				$obj->config = new \stdClass();

				foreach ($data["config"] as $key => $val) {
					$obj->config->$key = $val;
				}

				unset($data["config"]);
			}

			foreach ($data as $key => $val) {
				$obj->$key = $val;
			}

			$data = $obj;
		}

		$_helper = new \stdClass();
		$_helper->view = new ViewHelper($this->config);

		ob_start();
		require_once($view);
		return ob_get_clean();
	}

	public function render() {
		$view = $this->getView($this->view, $this->data);
		$layout = APP_PATH."/{$this->config["layout_path"]}/{$this->layout}.{$this->config["layout_extension"]}";
		echo $this->loadView($layout, array("viewContents" => $view, "config" => $this->config));
	}

	public function setView($view) {
		$this->view = $view;
	}

	public function setLayout($layout) {
		$this->layout = $layout;
	}

	public function addViewData($key, $val) {
		$this->data[$key] = $val;
	}

	public function redirect($url = ".") {
		header("Location: {$url}");
	}
}
