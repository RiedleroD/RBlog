<?php
function genBlogEntry($author,$email,$datetime,$content){
	$author = htmlentities($author);
	$email = htmlentities($email);
	echo "<div class='card blogpost'>";
		echo "<div class='cardheader'><span>Posted by: $author &lt;<a href='mailto:$email'>$email</a>&gt;</span><span>$datetime</span></div>";
		foreach($content as $stuff){
			switch($stuff["type"]){
				case "txt":
					echo "<p>";
					echo htmlentities($stuff['txt']);
					echo "</p>";
					break;
				case "h":
					echo "<h3>";
					echo htmlentities($stuff['txt']);
					echo "</h3>";
					break;
				case "img":
					$alt = htmlentities($stuff['alt']);
					echo "<div class='bpimgcontainer'><img src='";
					echo htmlentities($stuff['src']);
					echo "' alt='$alt'><span>$alt</span></div>";
					break;
				default:
					echo "<p>Unrecognized content type: ${stuff['type']}</p>";
			}
		}
	echo "</div>";
}
if($_GET["s"]=="entries"){
	include "./funcs/db.php";
	if($_POST["author"]!=NULL){
		if($_POST["element"]==NULL){
			$_POST["element"]=array();
		}
		db_add_post(
			$_POST["author"],
			$_POST["mail"],
			(new DateTime())->format('Y-m-d H:i:s'),
			$_POST["element"]
		);
	}
	foreach(db_get_posts() as $post){
		genBlogEntry(...$post);
	}
}
?>