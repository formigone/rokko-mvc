<?php
class Tasks {
	private $db;
	private $context;

	public function __construct(\Rokko\App $context) {
		$this->context = $context;
		$this->db = new Rokko\Database\MySQLDatabase($context->getDefaultDatabase());
	}

	public function getTasks() {
		return $this->db->query("select * from todo");
	}
}
