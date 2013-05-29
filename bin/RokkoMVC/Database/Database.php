<?php
namespace Rokko\Database;

abstract class Database {
	protected $host;
	protected $database;
	protected $username;
	protected $password;
	protected $conn;
	protected $isError;

	/**
	 * 
	 * @param array $appConfig
	 */
	public function __construct(Array $appConfig) {
		$this->host = $appConfig["host"];
		$this->username = $appConfig["username"];
		$this->password = $appConfig["password"];
		$this->database = $appConfig["database"];
		$this->conn = null;
		$this->isError = false;
	}

	public function isConnected() {
		return $this->conn == null;
	}

	public function isConnectionError() {
		return $this->isError;
	}

	/**
	 * 
	 * @param string $adapter
	 * @param string $options
	 */
	protected function connect($adapter, $options = null) {
		try {
			$this->conn = new \PDO("{$adapter}:host={$this->host};dbname={$this->database}", $this->username, $this->password, $options);
		} catch (\Exception $e) {
			$this->isError = true;
			error_log($e->getMessage().$e->getTraceAsString(), 0);
		}
	}

	/**
	 * 
	 * @param string $query
	 * @param string $params
	 * @param int $fetchMode
	 * @return multitype:
	 */
	public function query($query, $params = null, $fetchMode = \PDO::FETCH_ASSOC) {
		if ($this->conn == null) {
			return false;
		}

		$stmt = $this->conn->prepare($query);
		$stmt->execute($params);
		return $stmt->fetchAll($fetchMode);
	}
}
