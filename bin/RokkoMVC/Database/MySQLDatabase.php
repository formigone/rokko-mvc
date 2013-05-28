<?php
namespace Rokko\Database;

class MySQLDatabase extends Database {
	const ADAPTER = "mysql";

	public function __construct(Array $appConfig) {
		parent::__construct($appConfig);
		$this->connect(self::ADAPTER);
	}
}
