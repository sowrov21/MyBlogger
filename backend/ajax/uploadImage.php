<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(!empty($_FILES['image']['name'][0])){
			$image = $userObj->uploadImage($_FILES['image']);
			echo '{"url":"'.$image.'"}';
		}
	}