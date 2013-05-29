<?php
class TasksRepository implements ITasksRepository {
	private $db;
	private $context;

	public function __construct(\Rokko\App $context) {
		$this->context = $context;
		$this->db = new Rokko\Database\MySQLDatabase($context->getDefaultDatabase());
	}

	public function getTasks() {
		$res = $this->db->query("select * from todo order by task");
		$this->db->query("status");
		return $res;
	}

	public function saveTask($task) {
		$res = $this->db->query("insert into todo (task) values (:task)", array(":task" => $task));
		return $res;
	}

	public function deleteTask($id) {
		$res = $this->db->query("delete from todo where id = :id", array(":id" => $id));
		return $res;
	}
}
