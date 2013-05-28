<style>
ul {
	padding: 0;
	margin: 0;
	list-style: none;
}

li {
	padding: 5px 10px;
	margin: 0;
	border: 1px solid #aaa;
	border-bottom: 0;
	background: #eee;
	cursor: pointer;
}

li:hover {
	background: #ccc;
}

li:last-child {
	border: 1px solid #aaa;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function(){
	var li = document.querySelectorAll("li");
	for (var i = 0, len = li.length; i < len; i++) {
		li[i].addEventListener("click", deleteTask);
	}

	function deleteTask(event) {
		var id = this.getAttribute("data-task-id");
		var label = this.textContent;
		var confirm = window.confirm("Delete task \"" + label + "\"?");
		if (confirm) {
			window.location = "/rokko-mvc/index/delete/task/" + id;
		}
	}
});
</script>

<h2>A simple TODO list</h2>
<form method="post">
	<p>
		<input type="text" name="task" autofocus placeholder="Type task" />
	</p>
</form>

<ul>
	<?php foreach ($data->todo as $item): ?>
		<li data-task-id="<?= $item["id"]; ?>"><?= $item["task"]; ?></li>
	<?php endforeach; ?>
</ul>
