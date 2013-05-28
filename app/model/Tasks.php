<?php
class Tasks {
	private $db;
	private $context;

	public function __construct(\Rokko\App $context) {
		$this->context = $context;
		$this->db = new Rokko\Database\MySQLDatabase($context->getDefaultDatabase());
	}

	public function getTasks() {
		return $this->db->query("select * from todo order by task");
	}

	public function saveTask($task) {
		return $this->db->query("insert into todo (task) values (:task)", array(":task" => $task));
	}

	public function deleteTask($id) {
		return $this->db->query("delete from todo where id = :id", array(":id" => $id));
	}
}
