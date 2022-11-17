<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['postID'])){
			$postID   = (int) $_POST['postID'];
			$blogID   = (int) $_POST['blogID'];
			$post     = $userObj->get('posts', ['postID' => $postID, 
												'blogID' => $blogID]);
			$blog     = $dashObj->blogAuth($blogID);

			if($blog){
				if($blog->role === "Admin" or $blog->userID === $post->authorID){
					if($post){
						$userObj->delete('posts', ['postID' => $post->postID, 
												   'blogID' => $post->blogID]);
					}
				}else{
					echo 'you don\'t have rights to preform this action!';
				}
			}


		}else{
			echo 'something went wrong!';
		}
	}