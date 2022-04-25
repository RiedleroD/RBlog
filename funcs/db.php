<?php
	function db_connect(){
		$db = new PDO("mysql:host=192.168.43.52;dbname=6m1_1","tgm");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
	function db_get_pq($db,$query,$args){
		$stmt = $db->prepare($query);
		$stmt->execute($args);
		return $stmt;
	}
	function db_add_post($author,$email,$datetime,$content){
		$db = db_connect();
		$db->prepare("INSERT INTO posts VALUES (0,?,?,?)")->execute([$author,$email,$datetime]);
		$i = (int)($db->lastInsertId());
		$j = 1;
		$x = 0;
		foreach($content as $stuff){
			$db->prepare("INSERT INTO elements VALUES (0,?,?)")->execute([$i,$j]);
			$x = (int)($db->lastInsertId());
			switch($stuff["type"]){
				case "txt":
					$db->prepare("INSERT INTO paragraphs VALUES (?,?)")->execute([$x,$stuff['txt']]);
					break;
				case "h":
					$db->prepare("INSERT INTO headers VALUES (?,?)")->execute([$x,$stuff['txt']]);
					break;
				case "img":
					$db->prepare("INSERT INTO images VALUES (?,?,?)")->execute([$x,$stuff['src'],$stuff['alt']]);
					break;
			}
			$j+=1;
		}
	}
	function db_get_posts(){
		$db = db_connect();
		$posts = array();
		foreach($db->query("SELECT * FROM posts ORDER BY date DESC") as $post){
			array_push($posts,
				db_complete_post($db,$post["id"],$post["author"],$post["email"],$post["date"])
			);
		}
		return $posts;
	}
	function db_complete_post($db,$id,$author,$email,$datetime){
		$elements = array();
		foreach($row=$db->query("SELECT id FROM elements WHERE post=$id ORDER BY element ASC") as $row){
			$eid=(int)($row["id"]);
			//going through the types one-by-one because my table structure is bs
			$type = "txt";
			$text = db_get_pq($db,"SELECT text FROM paragraphs WHERE id=?",[$eid])->fetch()["text"];
			if($text==NULL){
				$type = "h";
				$text = db_get_pq($db,"SELECT text FROM headers WHERE id=?",[$eid])->fetch()["text"];
				if($text==NULL){
					$type = "img";
					$data = db_get_pq($db,"SELECT src,alt FROM images WHERE id=?",[$eid])->fetch();
					$src = $data["src"];
					$alt = $data["alt"];
				}
			}
			array_push($elements,array(
				"type"=>$type,
				"txt"=>$text,
				"src"=>$src,
				"alt"=>$alt
			));
		}
		return array($author,$email,$datetime,$elements);
	}
?>