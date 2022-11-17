<?php
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['email'])){
			$blogID     = (int) $_POST['blogID'];
			$email      = Validate::escape($_POST['email']);
			$name       = Validate::escape($_POST['name']);
			$blog       = $dashObj->blogAuth($blogID);

			if(!empty($email) && !empty($name)){
				if($blog){
					if(Validate::filterEmail($email)){
						if($blog->email !== $email){
							$data = $userObj->emailExist($email);

							if($data){
								echo "Email is Already in use!";
								exit;
							}
						}

						if(!empty($_FILES['file']['name'][0])){
							$image = $userObj->uploadImage($_FILES['file']);

							if(!$image){
								echo $userObj->imageError();
							}
						}else{
							$image = $blog->profileImage;
						}

						$userObj->update('users', ['email' => $email, 
												   'fullName' =>$name, 
												   'profileImage' => $image], ['userID' => $blog->userID]);
					}else{
						echo "Invalid Email Format!";
					}
				}
			} 
		}	
	}