<?php

define("BIN_PATH", realpath(__DIR__)."/bin/RokkoMVC");
define("APP_PATH", realpath(__DIR__)."/app");

require_once(BIN_PATH."/Autoloader.php");

// TODO: RokkoApp controls controller life cycle
// TODO: Design controller class
// TODO: Design database class
$appConfig = json_decode(file_get_contents(APP_PATH."/config/config.json"), true);
$rokkoConfig = json_decode(file_get_contents(BIN_PATH."/config/config.json"), true);

$autoloader = new \Rokko\Autoloader($appConfig, $rokkoConfig);

$app = new \Rokko\App(
		new \Rokko\Request($_SERVER, $appConfig, $rokkoConfig),
		new \Rokko\Response($appConfig),
		$appConfig, $rokkoConfig
		);
$app->run();
