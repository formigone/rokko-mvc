<?php
namespace Rokko\Database;

abstract class Database {
	protected $host;
	protected $database;
	protected $username;
	protected $password;
	protected $conn;

	public function __construct(Array $appConfig) {
		$this->host = $appConfig["host"];
		$this->username = $appConfig["username"];
		$this->password = $appConfig["password"];
		$this->database = $appConfig["database"];
	}

	protected function connect($adapter, $options = null) {
		$this->conn = new \PDO("{$adapter}:host={$this->host};dbname={$this->database}", $this->username, $this->password, $options);
	}

	public function query($query, $params = null, $fetchMode = \PDO::FETCH_ASSOC) {
		$stmt = $this->conn->prepare($query);
		$stmt->execute($params);
		return $stmt->fetchAll($fetchMode);
	}
}
