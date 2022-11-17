<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['postLimit'])){
			$postLimit   = Validate::escape($_POST['postLimit']);
			$blogID  = (int) $_POST['blogID'];
			$blog    = $dashObj->blogAuth($blogID);

			if($blog){
				if($blog->role === "Admin"){
					if(!empty($postLimit)){
						if(preg_match('/^[0-9]+$/', $postLimit)){
							if($postLimit >= '10'){
								$userObj->update('blogs', ['PostLimit' => $postLimit], 
								   	 	      ['blogID' => $blog->blogID]);
							}
						}else{
							echo "Please enter a vaild number!"; 
						}
					}
				}else{
					echo "Your don't have rights to update Post Limit!";
				}

			} 
		}
	}