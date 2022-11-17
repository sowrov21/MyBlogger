<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['comment'])){
			$comment   = htmlentities($_POST['comment']);
			$blogID  = (int) $_POST['blogID'];
			$blog    = $dashObj->blogAuth($blogID);

			if($blog){
				if($blog->role === "Admin"){
					if(!empty($comment)){
						if($comment !== $blog->Comments){
							$userObj->update('blogs', ['Comments' => $comment], 
								   	 	      ['blogID' => $blog->blogID]);
						}
					 
					}
				}else{
					echo "You don't have rights to set error message!";
				}

			} 
		}
	}