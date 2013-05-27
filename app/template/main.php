<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>RokkoMVC &reg;</title>
</head>
<body>
	<img src="<?= $_helper->view->rootPath("res/img/logo.png"); ?>" />
	<p>
		App Root:
		<?= $data->config->app_root; ?>
	</p>
	<hr />
	<?= $data->viewContents; ?>
</body>
</html>
