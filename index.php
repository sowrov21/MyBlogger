<?php 

	include 'backend/init.php';
	if(!$blogObj->getBlog()){
		//$userObj->redirect('login.php');
	}
	
	if($blog->DefaultTemplate === 'false'){
		$templateObj->renderTemplate($blog->Template, "POST");
		exit();
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php $blogObj->getTitle();?></title>
	<?php $blogObj->getStyles();?>
	<?php $blogObj->getMeta();?>
	
</head>
<body>
<div class="wrapper">
<div class="inner-wrapper">
	<div class="header-wrap">
		<div class="header-wrap-inner flex fl-c">
			<div class="header flex fl-4">
				<?php $blogObj->getHeader();?>
			</div>
			<div class="nav">
				<?php $blogObj->getNav();?>
			</div>
		</div>
	</div>
	
	<div class="web-body">
		<div class="web-body-inner flex fl-row">
			<div class="main">
				<section></section>
				<main>
					<div class="post-out-wrap">
					<div class="post-out-inner">
						<!-- Blog Posts -->
					 	<?php $blogObj->getBlogPosts();?>
					</div>
					</div>
				</main>
				<section></section>
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
						MyBlogger
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