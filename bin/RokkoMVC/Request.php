<?php
namespace Rokko;

class Request {
   protected $params;
   protected $controller;
   protected $action;
   protected $userAgent;
   protected $server;
   protected $config;

   public function __construct(Array $server, Array $config) {
   	$this->server = $server;
   	$this->config = $config;

   	$this->controller = null;
      $this->action = null;
      $this->params = array();
      $this->userAgent = $server["HTTP_USER_AGENT"];

      $this->init();
   }

   protected function init() {
      $uri = trim(trim($this->server["REQUEST_URI"]), "/");
      $uri = explode("/", $uri);
      $uriLen = count($uri);
      $offset = 1;

      if ($uriLen > 1) {
      	if ($this->config["app_root"] == $uri[1]) {
      		$offset = 2;
      	}

      	$this->controller = $uri[$offset];
      } else {
      	if ($this->config["app_root"] == $uri[0]) {
      		// TODO: Get app default controller
      		$this->controller = "index";
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

   public function getController() {
   	return $this->controller;
   }

   public function getAction() {
      return $this->action;
   }
}
