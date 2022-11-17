<?php 

	include '../backend/init.php';
	$post = $blogObj->getPost();
	if(!$blogObj->getBlog()){
		$userObj->redirect('login.php');
	}

	if($post){
		$type = "PAGE";
	}else{
		$type = "POST";
	}

	if($blog->DefaultTemplate === 'false'){
		$templateObj->renderTemplate($blog->Template, $type);
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php $blogObj->getTitle()?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>frontend/assets/template/style/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
	<link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<meta name="description" content="Your gorgeous description">
	<meta name="robots" content="index, follow"> 
</head>
<body>
<div class="wrapper">
<div class="inner-wrapper">
	<div class="header-wrap">
	<div class="header-wrap-inner flex fl-c">
		<div class="header flex fl-4">
			<?php $blogObj->getHeader();?>
		</div>
	</div>
	</div>
	<div class="nav">
		<?php $blogObj->getNav();?>
	</div>
	<div class="web-body">
		<div class="web-body-inner flex fl-row">
			<div class="main">
				<main>
					<?php $blogObj->getPostPage();?>
				</main>
			</div>
			<div class="aside">
				<aside>
				<div class="aside-wrap">
					<div class="aside-inner">
						<?php $blogObj->getSideBar();?>
					</div>	
				</div>
				</aside>
			</div>
		</div>
	</div>
	<div class="footer">
	<div class="footer-inner flex fl-c">
		<footer class="fl-6">
			
		<div class="footer-col">
			<div class="footer-col-inner">	
				<?php $blogObj->getFooter();?>
			</div>
		</div>

		</footer>
		<div class="copy-right">
			<div class="copyright-in flex fl-c">
				<div class="copy-head">
					<span>Copyright © 2014 - 2019</span>
					<a href="http://www.meralesson.com/">
						Meralesson.com
					</a><span>| Powered by</span> 
					<a href="#">
						Mylogger
					</a>
				</div>
				<div class="copy-footer">
					Design by <a href="https://www.facebook.com/Meezan-ud-din-102665887884560">
						Meezan ud din
					</a>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</body>
</html>