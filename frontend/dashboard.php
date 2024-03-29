<?php
	include '../backend/init.php';
	if(isset($_GET['blogID']) && !empty($_GET['blogID'])){
		$blogID = (int) $_GET['blogID'];
		$blog   = $dashObj->blogAuth($blogID);
  		if(!$blog){
			header('Location: 404');
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Dashboard - MyBlogger</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>frontend/assets/css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
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
					<div><i class="fab fa-blogger"></i></div>
					<div class="fl-1">
						<h3>MyBlogger</h3>
					</div>
				</div>
				<div class="fl-4">
					<h3>All posts</h3>
				</div>
			</div>
			<div class="header-right fl-2">
				<div class="h-r-in">
					<!-- Profile Image -->
					<img src="<?php echo BASE_URL.$blog->profileImage;?>"/>
					<div class="log-out">
						<div>
							<a href="<?php echo BASE_URL;?>frontend/logout.php">logout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--HEADER-IN-ENDS-HERE-->
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
 		<div class="header-b-right flex fl-4">
		<div class="h-b-r-inner flex fl-row">
			<div class="hbr-in-left fl-1 flex fl-row">
				<div>
					<button class="btn-newp" value="New post" onclick="window.location.href='http://localhost/MyBlogger/admin/blogID/<?php echo $blog->blogID;?>/post/new/';">New post</button>
				</div>
				<div class="flex fl-row fl-1">
					<!-- profile Image -->
					<div class="avatar-image">
						<img src="<?php echo BASE_URL.$blog->profileImage;?>">
					</div>
					<div class="fl-1">Using Mylogger as 
						<span class="bold"><?php echo $blog->fullName;?></span>
					</div>
				</div>
			</div>
			<div class="hbr-in-right">
			<div class="flex fl-row">
				<div></div>
				<div class="fl-1">
					<div>
					<input type="text" id="postSearch" data-blog="<?php echo $blog->blogID;?>">
					<i class="fas fa-search"></i> 
					</div>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
 	</div>
 	<!--HEADER-WRAPPER-ENDS-HERE-->
	<!--MAIN-->
	<div class="main fl-1 flex">
	<div class="main-inner flex fl-1 fl-row ">
		<div class="main-left flex fl-1">
		<div class="main-left-inner flex fl-c fl-1">
			<div class="main-menu fl-4">
				<ul>
					<li class="active"><span><i class="fas fa-newspaper"></i></span><a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/">Posts</a></li>
					<ul>
						<li id="active" class="active">
							<a href="<?php echo BASE_URL;?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/">All<?php $dashObj->getPostsCount('Post', '', $blog->blogID);?>
							</a>
						</li>
						<li>
							<a href="?type=draft" id="draft">Draft<?php $dashObj->getPostsCount('Post', 'draft', $blog->blogID);?></a>
						</li>
						<li>
							<a href="?type=published" id="published">Published<?php $dashObj->getPostsCount('Post', 'published', $blog->blogID);?></a>
						</li>
					</ul>
					
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
					<li><span><i class="fas fa-pager"></i></span>
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
		<div class="main-right-inner flex fl-c">
			<!--main-right-header-->
			<div class="main-right-header">
			<div class="main-right-header-in flex fl-row">
				<div class="m-r-header-left fl-1 flex fl-row">
					<div class="flex fl-1">
					<div class="flex">
						<span class="all-check">
							<input type="checkbox" id="checkAll">
						</span>
					</div>
					<div class="fl-4">
						<button id="labelMenu" tabindex="0"> 
							<span><i class="fas fa-tag"></i></span>
							<span ><i class="fas fa-sort-down"></i></span>
						</button>

						<div class="label-menu">
							<ul>
								<li>
									<a href="javascript:;" id="newLabel" data-blog="<?php echo $blog->blogID;?>">New label...</a>
								</li>
								 <?php $dashObj->getLabelsMenu($blog->blogID);?>
							</ul>
						</div>

						<button id="publishBtn">Publish</button>
						<button id="draftBtn">Revert to darft</button>
						<button id="deleteBtn"><i class="fas fa-trash"></i></button>
					</div>
					</div>
				</div>
				<div class="m-r-header-right flex fl-row">
					<div>
					<div>
 						<button class="br disabled" id="previousPage" disabled="true"><i class="fas fa-chevron-left"></i>
 						</button>
						
						<button id="postJumpMenu" class="disabled" disabled="true">
							<span id="currentPageNum">1</span>
							<span><i class="fas fa-sort-down"></i></span>
						</button>

						<div class="p-num">
							<ul id="page-num">
				 				<?php 
				 				  if(strpos($_SERVER['REQUEST_URI'], '?type=published')){
										$dashObj->getPaginationPages('10','Post','published',$blog->blogID);
								
									}else if(strpos($_SERVER['REQUEST_URI'], '?type=draft')){
										$dashObj->getPaginationPages('10','Post','draft',$blog->blogID);
									
									}else{
										$dashObj->getPaginationPages('10','Post','',$blog->blogID);
									}
				 				?>
							</ul>
						</div>

						<button class="bl disabled" id="nextPage" disabled="true" data-blog="<?php echo $blog->blogID;?>">
							<i class="fas fa-chevron-right"></i>
						</button>

					<span id="pageJump">
						<select style="margin-left: 14px;" name="postLimit" id="pageLimit" disabled="true">
						  <option value="10" selected>10</option>
						  <option value="25">25</option>
						  <option value="50">50</option>
						  <option value="100">100</option>
						</select> 
					</span>
					</div>
					</div>
				</div>
			</div>	
			</div>
			<!--main-right-Content-->
			<div id="posts" class="main-right-content fl-4">
				<!-- POSTS  -->
				<?php 
					if(strpos($_SERVER['REQUEST_URI'], '?type=published')){
						$dashObj->getAllPosts('1','10','Post','published',$blog->blogID);
				
					}else if(strpos($_SERVER['REQUEST_URI'], '?type=draft')){
						$dashObj->getAllPosts('1','10','Post','draft',$blog->blogID);
					
					}else{
						$dashObj->getAllPosts('1','10','Post','',$blog->blogID);
					}
				?>
					
 			</div>
 			<!-- JS FILES -->
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/labelMenu.js"></script>
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/postStatus.js"></script>
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/removePosts.js"></script>
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/postPagination.js"></script>
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/searchPosts.js"></script>
 			<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/addNewBlog.js"></script>
   
      		</div>
		<!--MAIN-Right-inner-DIV-ENDS-HERE-->
		</div>
		<!--MAIN-Right-DIV-ENDS-HERE-->
	</div>
	</div>
	<!--MAIN-DIV-ENDS-HERE-->
</div>
</div>
</body>
</html>