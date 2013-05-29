<?php
interface ITasksRepository {
	public function getTasks();
	public function saveTask($task);
	public function deleteTask($id);
}