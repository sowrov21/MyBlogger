<?php

	include 'backend/init.php';

	if($blog = $blogObj->getUserBlog()){
		$userObj->redirect("admin/blogID/{$blog->blogID}/dashboard/");
	}

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['signup'])){
			$name         = Validate::escape($_POST['name']);
			$email        = Validate::escape($_POST['email']);
			$title        = Validate::escape($_POST['title']);
			$blogUrl      = Validate::escape($_POST['blogUrl']);
			$password     = Validate::escape($_POST['password']);

			if(!empty($name) && !empty($email) && !empty($title) && !empty($blogUrl) && !empty($password)){
				if(!Validate::filterEmail($email)){
					$error['email'] = "Invalid email format!";
				}else if(strlen($title) > 150 OR strlen($title) < 1){
			 		$error['title'] = "Title Must be between 1 and 150 characters long.";
			 	}else if(strlen($blogUrl) < 1 OR strlen($blogUrl) > 50){
			 		$error['url']   = 'This blog address is invalid or not supported.';
			 	}else if(!preg_match('/^([a-z]+)$/', $blogUrl)){
			 		$error['url']   =  'This blog address is invalid or not supported.';
			 	}else if($blogObj->blogExist($blogUrl)){
			 		$error['url']   = 'This blog is not available.';
			 	}else if(strlen($password) < 4 or strlen($password) > 16){
			 		$error['password'] = "Password Must be between 1 and 16 characters long.";
			 	}else if(strlen($name) < 1 or strlen($name) > 16){
			 		$error['name'] = "Name Must be between 1 and 16 characters long.";
			 	}else{
			 		if(isset($_FILES['profileImage'])){
			 			if(!empty($_FILES['profileImage']['name'][0])){
			 				$image  = $userObj->uploadImage($_FILES['profileImage']);
			 			}
			 		}else{
			 			$image = "frontend/assets/images/avatar.png";
			 		}

			 		$hash  = $userObj->hash($password);
			 		$userID = $userObj->create('users', ['email' => $email, 
			 								   'password' => $hash, 
			 								   'fullName' => $name, 
			 								   'profileImage' => $image]);

			 		if($userID){
			 			$_SESSION['user_id'] = $userID;
			 			$html = file_get_contents('index.php', FALSE, NULL, 217);
				 		$html = htmlentities($templateObj->addTemplateTags($html));
				 		$blogID = $userObj->create('blogs', ['Title'          => $title, 
				 											 'Description'    =>  'Blog Description', 
				 											 'Domain'         => $blogUrl, 
				 											 'Comments'       => 'always', 
				 											 'PostLimit'      => 10, 
				 											 'CreatedBy'      => $userID, 
				 											 'Template'       => $html, 
				 											 'DefaultTemplate' => 'true']);

				 		$userObj->create('blogsAuth', ['blogID' => $blogID, 
				 									   'userID' => $userID, 
				 									   'role' => 'Admin']);

				 		$blogObj->createDefaultGadgets($blogID);
				 		$userObj->redirect("admin/blogID/{$blogID}/dashboard/");
			 		}
			 	}
			}else{
				$error['allFields'] = "All fields are required!";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create a New Blog - MyBlogger</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>frontend/assets/css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
</head>
<body>
<!--WRAPPER-->
<div class="wrapper">	
<div class="inner-wrapper flex fl-c">

	<div class="sign-up-wrapper fl-row flex fl-1">
		<div class="signup-logo flex fl-1">
			<div class="">
				<span><i class="fab fa-blogger"></i></span>
				<h2>Publish your passions, your way</h2>
				<p>Create a unique and beautiful blog. It’s easy and free.</p>
			</div>
		</div>
		<div class="sign-up-box-wrap flex fl-c fl-1"> 
		<div class="sign-up-box flex fl-c fl-1">
			<div class="sign-up-h flex fl-row">
				<form method="post" enctype="multipart/form-data">
				<div class="sign-up-avatar fl-4">
					<div style="width: 200px;">
						<div class="avatar-div">
							<img id="previewImage" src="<?php echo BASE_URL;?>frontend/assets/images/avatar.png"/>
						</div>
						<div>
							<input id="file" style="padding-top: 10px;" type="file" name="profileImage">
						</div>
					</div>
				</div>
			</div>
			
			<div class="sign-up-body">
 				<div class="blog-t">
					<div>
						Blog Title
					</div>
					<div>
						<input type="text" name="title" placeholder="e.g This is blog is about PHP" autocomplete="off">
						<div><?php echo ((isset($error['title'])) ? $error['title'] : '');?></div>
					</div>
				</div>
				<div class="blog-t">
					<div>
						Blog Address
					</div>
					<div>
						<input type="text" name="blogUrl" placeholder="e.g mynewblogdomain.localhost/" autocomplete="off">
						<div class="b-add-error"><?php echo ((isset($error['url'])) ? $error['url'] : '');?></div>
					</div>
				</div>
				<div class="sup-div">
					<div class="sup-div">
						<input type="text" name="name" placeholder="Name here" autocomplete="off">
						<div><?php echo ((isset($error['name'])) ? $error['name'] : '');?></div>
					</div>
					<div class="sup-div">
						<input type="email" name="email" placeholder="Email here" autocomplete="off">
						<div><?php echo ((isset($error['email'])) ? $error['email'] : '');?></div>
					</div>
					<div class="sup-div">
						<input type="password" name="password" placeholder="Password" autocomplete="off">
						<div><?php echo ((isset($error['password'])) ? $error['password'] : '');?></div>
					</div>
					<div><?php echo ((isset($error['allFields'])) ? $error['allFields'] : '');?></div>

				</div>
			</div>
			<div class="sign-footer">
				<button type="submit" name="signup" class="l-btn">Sign-Up</button>
			</div>	
		</form>
		<script type="text/javascript">
			document.querySelector('#file').addEventListener("change", function(event){
				var regex = /(\.jpg|\.jpeg|\.png|\.zip)$/i;
				if(!regex.exec(this.value)){
					alert("Only '.jpeg','.jpg','.png', formats are allowed");
					this.value = '';
					return false;
				}else{
					if(this.files && this.files[0]){
						var reader  = new FileReader();
						reader.onload = function(event){
							document.querySelector("#previewImage").src = event.target.result;
						}
						reader.readAsDataURL(this.files[0]);
					}
				}
			});
		</script>
		</div>
		</div>
	</div>
</div>
</div>
</body>
</html>