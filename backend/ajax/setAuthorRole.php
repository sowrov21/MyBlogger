<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID     = (int) $_POST['blogID'];
			$authorID   = (int) $_POST['authorID'];
			$authorRole = Validate::escape($_POST['role']);
			$blog       = $dashObj->blogAuth($blogID);
			$author     = $userObj->userData($authorID);

			if($blog){
				if($blog->role !== "Admin"){
					echo "You don't have rights to change Permission!";
				}else{
					if($blog->CreatedBy  === $author->userID){
						echo "Blog Creator Permission can't be changed!";
					}else{
						$userObj->update('blogsAuth', ['role' => $authorRole], 
													  ['userID' => $author->userID, 
													   'blogID' => $blog->blogID]);
					}
				}
			}
		}
	}