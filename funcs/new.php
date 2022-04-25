<form class="card" action="./?s=entries" method="post">
	<div class="cardheader">
		<b>New Post</b>
		<span>
			<input name="author" type="text" placeholder="Username" maxlength="64" value="<?=$_POST["author"]?>" required/>
			<input name="mail" type="email" placeholder="E-Mail" maxlength="32" value="<?=$_POST["mail"]?>" required/>
		</span>
	</div>
	<div id="stuff" data-post-data="<?=htmlspecialchars(json_encode(array_values($_POST["element"])))?>"></div>
	<button class="elementbtn" type="button" id="new_p">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 7" width="2em">
			<path fill="currentColor" d="M0 0h4v1H0m0 1h7v1H0m0 1h6v1H0m0 1h2v1H0"/>
		</svg>
	</button>
	<button class="elementbtn" type="button" id="new_h">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 5" width="2em">
			<path fill="currentColor" d="M1 0h1v2h1v-2h1v5h-1v-2h-1v2h-1z"/>
		</svg>
	</button>
	<button class="elementbtn" type="button" id="new_i">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 5" width="2em">
			<path fill="currentColor" d="M0 4.5l2-3 2 3zm4-4a1 1 0 000 2 1 1 0 000-2z"/>
		</svg>
	</button>
	<br/>
	<button type="submit">Pfostieren</button>
	<button type="submit" formaction="./?s=new">Vorschau</button>
</form>

<?php
	if($_POST["author"]!=NULL){
		include "./funcs/entry.php";
		if($_POST["element"]==NULL){
			$_POST["element"]=array();
		}
		genBlogEntry(
			$_POST["author"],
			$_POST["mail"],
			(new DateTime())->format('Y-m-d H:i:s'),
			$_POST["element"]
		);
	}
?>