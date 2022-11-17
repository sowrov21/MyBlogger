<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID     = (int) $_POST['blogID'];
			$authorID   = (int) $_POST['authorID'];
			$blog       = $dashObj->blogAuth($blogID);
			$author     = $userObj->userData($authorID);

			if($blog){
				if($blog->role !== "Admin"){
					echo "You don't have rights to delete user!";
				}else{
					if($blog->CreatedBy  === $author->userID){
						echo "Blog Creator can't be removed!";
					}else{
						if($blog->userID !== $author->userID){
						  $userObj->delete('users', ['userID' => $author->userID]);
						  $userObj->delete('blogsAuth', ['userID' => $author->userID]);
						}else{
							echo 'You can\' remove your self from author list!';
						}
					}
				}
			}
		}
	}