<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['description'])){
			$meta   = Validate::escape($_POST['description']);
			$blogID  = (int) $_POST['blogID'];
			$blog    = $dashObj->blogAuth($blogID);

			if($blog){
				if($blog->role === "Admin"){
					if(!empty($meta)){
						$userObj->update('blogs', ['MetaDescription' => $meta], 
								   	 	      ['blogID' => $blog->blogID]);
					}
				}else{
					echo "OwnnerError";
				}

			} 
		}
	}