<?php

define("BIN_PATH", realpath(__DIR__)."/../bin/RokkoMVC");
define("APP_PATH", realpath(__DIR__)."/../app");

require_once(realpath(__DIR__)."/PHPUnit/Autoload.php");

require_once(BIN_PATH."/Autoloader.php");

$appConfig = json_decode(file_get_contents(APP_PATH."/config/config.json"), true);
$rokkoConfig = json_decode(file_get_contents(BIN_PATH."/config/config.json"), true);
$autoloader = new \Rokko\Autoloader($appConfig, $rokkoConfig);
