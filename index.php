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

$uri = $_SERVER;
$req = new Request($uri);
