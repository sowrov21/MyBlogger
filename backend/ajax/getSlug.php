<?php 
	include '../init.php';
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID   = (int) $_POST['blogID'];
			$postID   = ((isset($_POST['postID'])) ? (int) $_POST['postID'] : null);
			$title    = Validate::escape($_POST['title']);
			$blog     = $dashObj->blogAuth($blogID);

			if($blog){
				$slug = $blogObj->createPostSlug($title, $blog->blogID, $postID);
				echo $slug;
			}
		}
	}