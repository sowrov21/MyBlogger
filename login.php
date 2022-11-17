<?php 

	include 'backend/init.php';
	if($userObj->isLoggedIn()){
		if($blog = $blogObj->getUserBlog()){
			$userObj->redirect("admin/blogID/{$blog->blogID}/dashboard/");
		}
	}
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['login'])){
			$email    = Validate::escape($_POST['email']);
			$password = $_POST['password'];

			if(!empty($email) && !empty($password)){
				if(!Validate::filterEmail($email)){
					$error = "Invalid email format";
				}else{
					if($user = $userObj->emailExist($email)){
						$hash = $user->password;
						if(password_verify($password, $hash)){
							$_SESSION['user_id'] = $user->userID;
							$blog = $userObj->get('blogs', ['CreatedBy' => $user->userID]);
							$userObj->redirect("admin/blogID/{$blog->blogID}/dashboard/");
						}else{
							$error = "Your Email or Password is incorrect!";
						}
					}
				}
			}else{
				$error = "Please enter your email and password!";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - MyBlogger</title>
	<link rel="stylesheet" href="frontend/assets/css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
</head>
<body>
<!--WRAPPER-->
<div class="wrapper">	
<div class="inner-wrapper flex fl-c">

	<div class="sign-in-wrapper flex fl-1">
 		<div class="sign-in-box flex fl-c">
			<div class="sign-up-head">
				<span><i class="fab fa-blogger-b"></i></span>
			</div>
			<form method="post">
	 			<div class="sign-body">
	  				<div>
						<div class="in-div">
							<input class="in-fo" type="email" name="email" placeholder="Email here">
							<span class="in-span">
								<i class="fas fa-envelope"></i>
							</span>
 						</div>
					</div>
					<div>
						<div class="in-div">
							<input class="in-fo" type="password" name="password" placeholder="Password">
							<span class="in-span">
								<i class="fas fa-lock"></i>
							</span>
							<div>
								<?php 
									if(isset($error)){
										echo $error;
									}
								?>		
							</div>
						</div>
					</div>
				</div>
				<div class="sign-footer">
					<button type="submit" name="login">login</button>
					<a type="button" class="cancel-btn" onclick="window.location.href = '<?php echo BASE_URL;?>signup.php';" href="signup.php">Sign-up</a>
								</br>
								</br>
					<p>Your IP: <span style="color: red; font-weight: bold;" id="ipAddress"></span></p>
					<p>Country: <strong id="countryName"></strong></p>
				</div>
			</form>
 		</div>
 	</div>
</div>
</div>
	<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/ipAddress.js"></script>
</body>
</html>