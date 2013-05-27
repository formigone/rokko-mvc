<h1>My name is <?= $data->name; ?></h1>
<ul>
	<?php foreach ($data->todo as $items): ?>
		<li><?= $items; ?></li>
	<?php endforeach; ?>
</ul>
