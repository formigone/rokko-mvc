<h1>My name is <?= $data->name; ?></h1>
<ul>
	<?php foreach ($data->todo as $item): ?>
		<li><?= $item["task"]; ?></li>
	<?php endforeach; ?>
</ul>
