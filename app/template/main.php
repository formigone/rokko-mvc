<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="<?= $_helper->view->rootPath("res/favicon/favicon.ico"); ?>" />
<title>RokkoMVC &reg;</title>
</head>
<body>
	<a href="<?= $_helper->view->rootPath(""); ?>"> 
		<img src="<?= $_helper->view->rootPath("res/img/logo.png"); ?>" />
	</a>
	<hr />
	<?= $data->viewContents; ?>
</body>
</html>
