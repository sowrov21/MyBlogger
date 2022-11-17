<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['error'])){
			$error   = htmlentities($_POST['error']);
			$blogID  = (int) $_POST['blogID'];
			$blog    = $dashObj->blogAuth($blogID);

			if($blog){
				if($blog->role === "Admin"){
					if(!empty($error)){
						$userObj->update('blogs', ['CustomError' => $error], 
								   	 	      ['blogID' => $blog->blogID]);
					}
				}else{
					echo "You don't have rights to set error message!";
				}

			} 
		}
	}