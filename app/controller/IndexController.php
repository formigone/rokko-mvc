<?php

class IndexController extends \Rokko\Controller {
	/**
	 * (non-PHPdoc)
	 * @see \Rokko\Controller::init()
	 */
	public function init() {
		parent::init();
		$resp = $this->getResponse();
		$resp->setLayout("main");
	}

	/**
	 * 
	 */
	public function indexExec() {
		$mTasks = new TasksService($this->getContext());
		$request = $this->getRequest();

		if ($request->isPost()) {
			$task = $request->getParam("task");
			$mTasks->saveTask($task);
			$this->getResponse()->redirect();
		}

		$items = $mTasks->getTasks();
		$this->setData("todo", $items);
	}

	/**
	 * 
	 */
	public function deleteExec() {
		$mTasks = new TasksService($this->getContext());
		$request = $this->getRequest();
		$id = $request->getParam("task");

		$mTasks->deleteTask($id);
		$this->getResponse()->redirect("/rokko-mvc");
	}
}
