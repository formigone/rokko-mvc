<?php
namespace Rokko;

class Response {
	private $view;
	private $layout;
	private $data;
	private $config;

	public function __construct($config) {
		$this->config = $config;
	}

	public function getView($view, $data) {
		$view = "{$this->config->view_path}/{$view}.{$this->config->view_extension}";
		return $this->loadView($view, $data);
	}

	private function loadView($view, $data) {
		if (!file_exists($view)) {
			throw new \Exception("View not found");
		}

		// Convert data into object so items can be accessed with -> operator
		if (is_array($data)) {
			$obj = new \stdClass();
			foreach ($data as $key => $val) {
				$obj->$key = $val;
			}

			$data = $obj;
		}

		$_this = $data;
		ob_start();
		require_once($view);
		return ob_get_clean();
	}

	public function render() {
		$view = $this->getView($this->view, $this->data);
		$layout = "{$this->config->layout_path}/{$this->layout}.{$this->config->layout_extension}";
		echo $this->loadView($layout, array("viewContents" => $view));
	}

	public function setView($view) {
		$this->view = $view;
	}

	public function setLayout($layout) {
		$this->layout = $layout;
	}

	public function setViewData($data) {
		$this->data = $data;
	}
}
