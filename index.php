<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Riedler's Blog</title>
		<link rel="icon" type="image/svg" href="/favicon.svg"/>
		<link rel="stylesheet" href="./style/main.css"/>
		<?php
		switch($_GET["s"]){
			case "new":
				echo "<link rel='stylesheet' href='./style/newpost.css'/>";
				echo "<script src='./scripts/newpost.js' async></script>";
			case "entries":
				echo "<link rel='stylesheet' href='./style/overview.css'/>";
				break;
		}
		?>
	</head>
	<body>
		<?php
			include "./funcs/nav.php";
			switch($_GET["s"]){
				case "entries":
					include "./funcs/entry.php";
					break;
				case "new":
					include "./funcs/new.php";
					break;
				default:
					include "./funcs/mainsite.php";
			}
		?>
	</body>
</html>