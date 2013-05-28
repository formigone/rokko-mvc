<?php
namespace Rokko;

class Request {
   protected $controller;
   protected $action;
   protected $params;
   protected $userAgent;
   protected $server;
   protected $appConfig;
   protected $rokkoConfig;

   public function __construct(Array $server, Array $appConfig, Array $rokkoConfig) {
   	$this->server = $server;
   	$this->appConfig = $appConfig;
   	$this->rokkoConfig = $rokkoConfig;

   	$this->controller = null;
      $this->action = null;
      $this->params = array();
      $this->userAgent = $server["HTTP_USER_AGENT"];

      $this->init();
   }

   protected function init() {
   	$this->getRequestData();

   	$uri = trim(trim($this->server["REQUEST_URI"]), "/");
      $uri = explode("/", $uri);
      $uriLen = count($uri);
      $offset = 1;

      if ($uriLen > 1) {
      	if ($this->appConfig["app_root"] == $uri[1]) {
      		$offset = 2;
      	}

      	$this->controller = $uri[$offset];
      } else {
      	if ($this->appConfig["app_root"] == $uri[0]) {
      		$this->controller = $this->rokkoConfig["default_controller_action"];
      	} else {
	      	$this->controller = $uri[0];
      	}
      }

      // TODO: Use bin config file
      // Detect requested action, or use default
      if ($uriLen > $offset + 1) {
      	$this->action = $uri[$offset + 1];
      } else {
      	$this->action = "index";
      }

      if ($uriLen > $offset + 2) {
         for ($i = $offset + 2; $i < $uriLen; $i+= 2) {
            $param = $uri[$i];
            $val = isset($uri[$i + 1]) ? $uri[$i + 1] : null;

            $this->params[$param] = $val;
         }
      }
   }

   private function getRequestData() {
   	foreach ($_REQUEST as $key => $val) {
   		$this->params[$key] = $val;
   	}
   }

   public function isPost() {
   	return count($_POST) > 0;
   }

   public function isGet() {
   	return !$this->isPost();
   }

   public function isMobile() {
      return false;
   }

   public function getParams() {
      return $this->params;
   }

   public function getParam($param) {
      if (!array_key_exists($param, $this->params)) {
         return null;
      }

      return $this->params[$param];
   }

   public function getController() {
   	return $this->controller;
   }

   public function getAction() {
      return $this->action;
   }
}
