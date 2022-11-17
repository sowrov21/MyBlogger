<?php

	include '../backend/init.php';
	if(isset($_GET['blogID']) && !empty($_GET['blogID'])){
		$blogID = (int) $_GET['blogID'];
		$blog   = $dashObj->blogAuth($blogID);

  		if(!$blog){
			header('Location: 404');
		}
		//$html = file_get_contents('../index.php',FALSE,NULL,106);
		//$html = htmlentities($html);
		//$html = $templateObj->addTemplateTags($html);
		//$userObj->update('blogs', ['Template' => $html],['blogID' => $blog->blogID]);
 	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Template - Admin Panel - MyBlogger</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>frontend/assets/css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" integrity="sha512-BpBUlZ2+12MdT/wiW1dmcBP6QvO+MeGuDrsgLOnDVhIwFXtPK4kGaTnFJPn+52Af0aWbDP20tfOsH51Aff7atQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
 
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
</head>
<body>
<div class="popup-create-wrap" id="blogFormPopup">
</div>
<!--WRAPPER-->
<div class="wrapper">	
<div class="inner-wrapper flex fl-c">
	<!--HEADER-WRAPPER-->
	<div class="header-wrapper flex fl-c">
	<header class="header">
		<div class="header-in flex fl-row">
			<div class="header-left flex fl-row fl-1">
				<div class="logo flex fl-row fl-1">
					<div>
						<i class="fab fa-blogger"></i>
					</div>
					<div class="fl-1">
						<h3>MyBlogger</h3>
					</div>
				</div>
				<div class="fl-4">
					<h3>Edit Template</h3>
				</div>
			</div>
			<div class="header-right fl-2">
				<div class="h-r-in">
					<img src="<?php echo BASE_URL.$blog->profileImage;?>"/>
				</div>
			</div>
		</div><!--HEADER-IN-ENDS-HERE-->
	</header>
	<div class="header-bottom flex fl-row">
		<div class="header-b-left fl-1">
 			<div>
				<div class="b-h-div">
					<h4><?php echo $blog->Title;?></h4>
				</div>
				<span>
					<a href="javascript:;" id="blogListBtn">
						<i class="fas fa-sort-down"></i>
					</a>
				</span>
				<div class="b-h-menu" id="blogListMenu">
					<div class="bhm-head">
						<h6>Your blogs</h6>
					</div>
					<div class="bhm-body">
					 	<!-- BlogList -->
					 	<?php $dashObj->getBlogList($blogID);?>
					</div>
					<div class="bhm-footer">
						<a href="javascript:;" data-blog="<?php echo $blog->blogID?>" id="newBlogBtn">New Blog...</a>
					</div>
				</div>
			</div>
			<div>
				<a href="http://<?php echo $blog->Domain;?>.localhost/MyBlogger/" target="_blank">ViewBlog</a>
			</div>
		</div>
		<div class="header-b-right flex fl-4"></div>
	</div>
	</div><!--HEADER-WRAPPER-ENDS-HERE-->
	<!--MAIN-->
	<div class="main fl-1 flex">
	<div class="main-inner flex fl-1 fl-row ">
		<div class="main-left flex fl-1">
		<div class="main-left-inner flex fl-c fl-1">
			<div class="main-menu fl-4">
				<ul>
					<li><span><i class="fas fa-newspaper"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/">Posts</a>
					</li>
					<li><span><i class="far fa-chart-bar"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/stats">Stats</a>
					</li>
					<li><span><i class="fas fa-comment"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/comments">Comments</a>
					</li>
					<li><span><i class="far fa-copy"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/pages">Pages</a>
					</li>
					<li><span><i class="fas fa-object-group"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/layout">Layout</a>
					</li>
					<li class="active"><span><i class="fas fa-pager"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/template/edit">Template</a>
					</li>
					<li><span><i class="fas fa-cog"></i></span>
						<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/settings">Settings</a>
					</li>
				</ul>
			</div>
			<!--FOOTER-->
			<div class="footer">
			<div class="footer-inner">
				<ul>
					<li><a href="#">Terms of Service</a></li>|
					<li><a href="#">Privacy</a></li>|
					<li><a href="#">Content Policy</a></li>
				</ul>
			</div>
		</div>
		</div>
		</div>
		<div class="main-right flex fl-4">
			<div class="edit-tamplate-wrap">
				<div class="edit-tamplate-inner">
					<div class="edit-tamplate-head">
						<div class="lt-foo rightpad">
							<div class="bn-button">
								<button id="saveBtn" data-blog="<?php echo $blog->blogID;?>" class="btn-newp">Save Template</button>		
								<button id="revert" class="cancel-btn">Revert to default</button>		
							</div>
						</div>
					</div>
					<div class="edit-tamplate-body">
						<div class="edit-tamplate" id="editor"><textarea rows="5" cols="10" class="code" name="ace-editor"><?php echo $blog->Template;?></textarea></div>
					</div>
				</div>
			</div>
		</div>
		<!--MAIN-Right-DIV-ENDS-HERE-->
	</div>
	</div>
	<!--MAIN-DIV-ENDS-HERE-->
	<script type="text/javascript">
		var editor = ace.edit("editor");
		editor.setTheme('ace/theme/eclipse');
		//editor.setTheme('ace/theme/twilight');
		editor.session.setMode('ace/mode/xml');
		var button     = document.querySelector("#saveBtn");
		var revertBtn  = document.querySelector("#revert");

		button.addEventListener("click", function(event){
			var formData  = new FormData();

			formData.append("blogID", this.dataset.blog);
			formData.append("html", editor.getValue());
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/validateHtml.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						if(this.responseText.length > 0){
							alert(this.responseText);
						}
						location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		});

		revertBtn.addEventListener("click", function(event){
			if(confirm("Are you sure, you want to restore your Template?")){
				var formData  = new FormData();

				formData.append("blogID", button.dataset.blog);
	 			
				var httpRequest = new XMLHttpRequest();

				if(httpRequest){
					httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/restoreTemplate.php', true);
					httpRequest.onreadystatechange = function(){
						if(this.readyState === 4 && this.status === 200){
							if(this.responseText.length > 0){
								alert(this.responseText);
							}
							location.reload(true);
						}
					}

					httpRequest.send(formData);
				}
			}	
		});
	</script>
</div>
</div>
	<!-- JS FILES -->
</body>
</html>