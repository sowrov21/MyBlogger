<?php 

	include '../backend/init.php';

	if($blogObj->getBlog()){
		$userObj->redirect();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog not found - MyBlogger</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>frontend/assets/css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
</head>
<body>
<!--WRAPPER-->
<div class="wrapper">	
<div class="inner-wrapper flex fl-c">
	<!--HEADER-WRAPPER-->
	<div class="header-wrapper flex fl-c">
	<header class="header">
		<div class="header-popup flex f-c">
			<div class="header-in flex fl-row">
				<div class="logo flex fl-row fl-1">
					<div><i class="fab fa-blogger"></i></div>
					<div class="fl-1"><h3>MyBlogger</h3></div>
				</div>
			</div><!--HEADER-IN-ENDS-HERE-->
		</div>
	</header>
	</div><!--HEADER-WRAPPER-ENDS-HERE-->
	
	<div class="error-page flex fl-1">
	<div class="error-page-inner fl-c">
		<div class="error-heading flex">
			<h3>Blog not found</h3>
		</div>
		<div class="error-text">
			<p>Sorry, the blog you were looking for does not exist. However, you can still try to register new one</p>
		</div>
	</div><!--error-page-inner ends-->
	</div><!--error-page ends-->
	<div class="foo">
		<div class="foo-bottom">
			<div class="foo-inner-left">
				
			</div>
			<div class="fo-in-right">
				
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>