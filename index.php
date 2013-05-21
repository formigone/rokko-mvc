<?php

define("BIN_PATH", realpath(__DIR__)."/bin/RokkoMVC");
define("APP_PATH", realpath(__DIR__)."/app");

require_once(BIN_PATH."/Autoloader.php");

// TODO: Send in configs to RokkoApp
// TODO: RokkoApp controls controller life cycle
// TODO: Design controller class
// TODO: Design database class
$config = json_decode(file_get_contents(APP_PATH."/config/config.json"), true);
$app = new \Rokko\App(
		new \Rokko\Request($_SERVER, $config),
		new \Rokko\Response($config),
		$config
		);
$app->run();
