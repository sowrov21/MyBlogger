<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$postID       = (int) $_POST['postID'];
			
			$blog         = $dashObj->blogAuth($blogID);
			$post         = $userObj->get('posts', ['postID' => $postID, 'blogID' => $blog->blogID]);
			
			
			if($blog){
				if($blog->role === "Admin" OR $blog->userID === $post->authorID){
					if($post->postStatus === "published"){
						$userObj->update('posts', ['postStatus' => 'draft'], ['postID' => $post->postID, 'blogID' => $blog->blogID]);
					}
				}
			}
		}
	}