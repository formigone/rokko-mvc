<?php
namespace Rokko;

class ViewHelper {
	private $appConfig;

	public function __construct($appConfig) {
		$this->appConfig = $appConfig;
	}

	public function rootPath($path) {
		return "/{$this->appConfig["app_root"]}/{$path}";
	}
}
