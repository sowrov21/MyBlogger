<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['currPass'])){
			$currPass   = $_POST['currPass'];
			$newPass    = $_POST['newPass'];
			$newPassRe  = $_POST['newPassRe'];
			$blogID     = (int) $_POST['blogID'];
			$blog       = $dashObj->blogAuth($blogID);
			if($blog){
				if(!empty($currPass) && !empty($newPass) && !empty($newPassRe)){
					if($newPass === $newPassRe){
						if(strlen($newPass) > 5){
							$hash = $userObj->hash($newPass);
							if(password_verify($currPass, $blog->password)){
								//update password
								$userObj->update('users', ['password' => $hash], 
														  ['userID' => $blog->userID]);
							}else{
								echo "Your password is incorrect!";
							}
						}else{
							echo "Your new password is too short";
						}
					}else{
						echo "Your new password does not match!";
					}
				}
			} 
		}
	}