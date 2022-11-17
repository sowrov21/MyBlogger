<?php
 
	include '../backend/init.php';
	if(isset($_GET['blogID']) && !empty($_GET['blogID'])){
		$blogID = (int) $_GET['blogID'];
		$blog   = $dashObj->blogAuth($blogID);

  		if(!$blog){
			header('Location: 404');
		}


		if(strpos($_SERVER['REQUEST_URI'], '?type=all')){
			$type = 'alltime';
		}elseif(strpos($_SERVER['REQUEST_URI'], '?type=now')){
			$type = 'today';
		}elseif(strpos($_SERVER['REQUEST_URI'], '?type=day')){
			$type = 'yesterday';
		}elseif(strpos($_SERVER['REQUEST_URI'], '?type=week')){
			$type = 'week';
		}elseif(strpos($_SERVER['REQUEST_URI'], '?type=month')){
			$type = 'month';
		}else{
			$type = 'alltime';
		}

  	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stats - Dashboard - MyBlogger</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>frontend/assets/css/style.css"/>
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
					<div>
						<i class="fab fa-blogger"></i>
					</div>
					<div class="fl-1">
						<h3>MyBlogger</h3>
					</div>
				</div>
				<div class="fl-4">
					<h3>Stats</h3>
				</div>
			</div>
			<div class="header-right fl-2">
				<div class="h-r-in">
					<img src="<?php echo BASE_URL.$blog->profileImage;?>"/>
					<div class="log-out">
						<div>
							<a href="<?php echo BASE_URL; ?>frontend/logout.php">logout</a>
						</div>
					</div>
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
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/">Posts</a>
					</li>
					<li class="active"><span><i class="far fa-chart-bar"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/stats">Stats</a>
					</li>
					<li><span><i class="fas fa-comment"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/comments">Comments</a>
					</li>
					<li><span><i class="far fa-copy"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/pages">Pages</a>
					</li>
					<li><span><i class="fas fa-object-group"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/layout">Layout</a>
					</li>
					<li><span><i class="fas fa-pager"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/template/edit">Template</a>
					</li>
					<li><span><i class="fas fa-cog"></i></span>
						<a href="<?php echo BASE_URL; ?>admin/blogID/<?php echo $blog->blogID;?>/dashboard/settings">Settings</a>
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
			<div class="stats-wrap">
			<div class="stats-inner">
				<div class="stats-header flex">
					<div class="stats-header-buttons">
						<button onclick="window.location = '?type=now';">Now</button>
						<button onclick="window.location = '?type=day';">Day</button>
						<button onclick="window.location = '?type=week';">Week</button>
						<button onclick="window.location = '?type=month';">Month</button>
						<button onclick="window.location = '?type=all';">All time</button>
					</div>
				</div>
				<div class="stats">
					<div class="stats-box2 fl-c">

						<div class="stat2-table-body fl-4 flex fl-c">
							<div class="st-body-list">
								<div class="flex fl-row">
									<div class="fl-4">
										<p>Pageviews today</p>
									</div>
									<div class="fl-1">
										<?php echo $statsObj->getStats($blog->blogID, 'today');?>
									</div>
								</div>
							</div>
							<div class="st-body-list">
								<div class="flex fl-row">
									<div class="fl-4">
										<p>Pageviews yesterday</p>
									</div>
									<div class="fl-1">
									<?php echo $statsObj->getStats($blog->blogID, 'yesterday');?>

									</div>
								</div>
							</div>
							<div class="st-body-list">
								<div class="flex fl-row">
									<div class="fl-4">
										<p>Pageviews last week</p>
									</div>
									<div class="fl-1">
										<?php echo $statsObj->getStats($blog->blogID, 'week');?>
									</div>
								</div>
							</div>
							<div class="st-body-list">
								<div class="flex fl-row">
									<div class="fl-4">
										<p>Pageviews last month</p>
									</div>
									<div class="fl-1">
										<?php echo $statsObj->getStats($blog->blogID, 'month');?>

									</div>
								</div>
							</div>
							<div class="st-body-list">
								<div class="flex fl-row">
									<div class="fl-4">
										<p>Pageviews all time history</p>
									</div>
									<div class="fl-1">
									<?php echo $statsObj->getStats($blog->blogID, 'alltime');?>
									</div>
								</div>
							</div>
						</div>
					</div><!--STATS-BOX ENDS-->
					<div class="stats-box fl-c">
						<div class="stat-head">
							Posts
						</div>
						<div class="stat-table">
							<div class="stat-table-head fl-row flex">
								<div class="fl-4">
									Entry
								</div>
								<div class="fl-1">
									Pageviews
								</div>
							</div>
						</div>
						<div class="stat-table-body fl-4 flex fl-c">
						<?php  $statsObj->getPosts($blog->blogID, $type);?>
						</div>
					</div><!--STATS-BOX ENDS-->
					<div class="stats-box fl-c">
						<div class="stat-head">
							Referring Sites  
						</div>
						<div class="stat-table">
							<div class="stat-table-head fl-row flex">
								<div class="fl-4">
									Entry
								</div>
								<div class="fl-1">
									Pageviews
								</div>
							</div>
						</div>
						<div class="stat-table-body fl-4 flex fl-c">
						<?php  $statsObj->getReferringSites($blog->blogID, $type);?>
						</div>
					</div><!--STATS-BOX ENDS-->
					<div class="stats-box fl-c">
						<div class="stat-head">
							Audience
						</div>
						<div class="stat-table">
							<div class="stat-table-head fl-row flex">
								<div class="fl-4">
									Entry
								</div>
								<div class="fl-1">
									Pageviews
								</div>
							</div>
						</div>
						<div class="stat-table-body fl-4 flex fl-c">
							<?php  $statsObj->getAudience($blog->blogID, $type);?>
						</div>
					</div><!--STATS-BOX ENDS-->
					
					<div class="stats-box fl-c">
						<div class="stat-head">
							Pages
						</div>
						<div class="stat-table">
							<div class="stat-table-head fl-row flex">
								<div class="fl-4">
									Entry
								</div>
								<div class="fl-1">
									Pageviews
								</div>
							</div>
						</div>
						<div class="stat-table-body fl-4 flex fl-c">
							<?php  $statsObj->getPages($blog->blogID, $type);?>
						</div>
					</div><!--STATS-BOX ENDS-->
					<!-- Js files -->
					<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/addNewBlog.js"></script>

 				</div><!--STATS ENDS HERE-->
			</div><!--STATS INNER ENDS HERE-->
			</div><!--STATS-WRAP-->
		</div><!--MAIN-Right-DIV-ENDS-HERE-->
	</div>
	</div><!--MAIN-DIV-ENDS-HERE-->
</div>
</div>
</body>
</html>