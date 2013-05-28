<?php
namespace Rokko;

class Autoloader {
	private $toLoad;
	private $base_namespace;

	public function __construct(Array $appConfig, Array $rokkoConfig) {
		$this->toLoad = $appConfig["autoload_directories"];
		$this->base_namespace = $rokkoConfig["base_namespace"];
		spl_autoload_register(array($this, "loadStdClasses"));
		spl_autoload_register(array($this, "loadAppClasses"));
	}

	public function loadStdClasses($class) {
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
