<?php

// Create request object
// Create response object

namespace RokkoMVC;

class Request {
   protected $params;
   protected $action;
   protected $userAgent;

   public function __construct(Array $server) {
      $this->action = null;
      $this->params = array();
      $this->userAgent = $server["HTTP_USER_AGENT"];

      $this->init($server);
   }

   protected function init(Array $server) {
      $uri = trim(trim($server["REQUEST_URI"]), "/");
      $uri = explode("/", $uri);
      $uriLen = count($uri);

      $this->action = null;
      $this->params = array();

      if ($uriLen > 1) {
         $this->action = $uri[1];
      }

      if ($uriLen > 3) {
         for ($i = 2; $i < $uriLen; $i+= 2) {
            $param = $uri[$i];
            $val = isset($uri[$i + 1]) ? $uri[$i + 1] : null;

            $this->params[$param] = $val;
         }
      }
   }

   public function isMobile() {
      return false;
   }

   public function getParams() {
      return $this->params;
   }

   public function getParam($param) {
      if (!in_array($param, $this->params)) {
         return null;
      }

      return $this->params[$param];
   }

   public function getAction() {
      return $this->action;
   }
}

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

$config = json_decode(file_get_contents("config.json"));

$data = new \stdClass();
$data->hello = "Hello, world!";

$res = new Response($config);

$res->setView("view");
$res->setViewData($data);
$res->setLayout("template");
$res->render();
