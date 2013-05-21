<?php

define("BIN_PATH", realpath(__DIR__)."/bin/RokkoMVC");
define("APP_PATH", realpath(__DIR__)."/app");

require_once(BIN_PATH."/Autoloader.php");

// TODO: Send in configs to RokkoApp
// TODO: RokkoApp controls controller life cycle
// TODO: Design controller class
// TODO: Design database class
$app = new \Rokko\App();
$req = new \Rokko\Request($_SERVER);
$ctr = new IndexController();
echo $ctr->test();
