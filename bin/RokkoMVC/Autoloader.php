<?php
namespace Rokko;

class Autoloader {
//	const DEFAULT_CLASS_PREFIX = "Rokko_";
	private $toLoad;
	private $base_namespace;

	public function __construct(Array $appConfig, Array $rokkoConfig) {
		$this->toLoad = $appConfig["autoload_directories"];
		$this->base_namespace = $rokkoConfig["base_namespace"];
		spl_autoload_register(array($this, "loadStdClasses"));
		spl_autoload_register(array($this, "loadAppClasses"));
	}

	// TODO: Load the right file within subdirectories
	public function loadStdClasses($class) {
/* 		$parts = explode("\\", $class);
		$path = $class;

		// Load standard RokkoMVC class
		if (count($parts) > 1 && $parts[0]."_" == self::DEFAULT_CLASS_PREFIX) {
			$filename = str_replace(self::DEFAULT_CLASS_PREFIX, "", $parts[1]);
			$path = BIN_PATH."/{$filename}.php";
		}

		self::load($path, $class);
 */
		$file = str_replace($this->base_namespace, "", $class);
		$file = str_replace("\\", DIRECTORY_SEPARATOR, $file);
		$this->load(BIN_PATH."/{$file}.php");
	}

	public function loadAppClasses($class) {
		$parts = explode("\\", $class);

		foreach ($this->toLoad as $assetType) {

			// Load namespaced class
			if (count($parts) > 1) {
				$filename = $parts[count($parts) - 1];
				$path = APP_PATH."/{$assetType}/{$filename}.php";
			} else {
				$path = APP_PATH."/{$assetType}/{$class}.php";
			}

			if ($this->load($path)) {
				break;
			}
		}
	}

	private function load($path) {
		if (is_file($path)) {
			require_once($path);
			return true;
		}

		return false;
	}
}
