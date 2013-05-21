<?php
namespace Rokko;

class Autoloader {
	const DEFAULT_CLASS_PREFIX = "Rokko_";
	private static $toLoad = array("model", "controller", "lib");

	public static function loadStdClasses($class) {
		$parts = explode("\\", $class);
		$path = $class;

		// Load standard RokkoMVC class
		if (count($parts) > 1 && $parts[0]."_" == self::DEFAULT_CLASS_PREFIX) {
			$filename = str_replace(self::DEFAULT_CLASS_PREFIX, "", $parts[1]);
			$path = BIN_PATH."/{$filename}.php";
		}

		self::load($path, $class);
	}

	public static function loadAppClasses($class) {
		$parts = explode("\\", $class);

		foreach (self::$toLoad as $assetType) {

			// Load namespaced class
			if (count($parts) > 1) {
				$filename = $parts[count($parts) - 1];
				$path = APP_PATH."/{$assetType}/{$filename}.php";
			} else {
				$path = APP_PATH."/{$assetType}/{$class}.php";
			}

			if (self::load($path, $class)) {
				break;
			}
		}
	}

	private static function load($path, $class) {
		if (is_file($path)) {
			require_once($path);
			return true;
		}

		return false;
	}
}

spl_autoload_register("\Rokko\Autoloader::loadStdClasses");
spl_autoload_register("\Rokko\Autoloader::loadAppClasses");
