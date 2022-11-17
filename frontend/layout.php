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
<!DOCTYPE html>
<html>
<head>
	<title>Layout - MyBlogger</title>
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
					<h3>Layout</h3>
				</div>
			</div>
			<div class="header-right fl-2">
				<div class="h-r-in">
					<img src="<?php echo BASE_URL.$blog->profileImage;;?>"/>
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
			<div class="hbr-in-right">
				<div class="lay-save-div">
					<button id="saveLayoutBtn" data-blog="<?php echo $blog->blogID;?>" class="btn-newp disabled" value="Save arrangement" disabled>Save arrangement</button>
					<button class="cancel-btn">Cancel</button>
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
					<li class="active"><span><i class="fas fa-object-group"></i></span>
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
			<!--main-right-Content-->
			<div class="main-right-content fl-4">
			<div class="m-r-c-inner">
			  <div class="layout-wrapper">
				<div class="layout-inner">
				<div class="layout flex fl-c">
					<!--HEADER-SECTION-->
					<div class="header-section flex fl-c">
						<div class="header-1">
							<div class="lay-border">
								<h3>header</h3>
								<!--layout-widget-box-->
								<div class="layout-widget-box">
								<div class="layout-widget-inner">
									<?php if($gadget = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'header', 'position' => 1])):
											$content = json_decode($gadget->content);
									?>
									<!--HEADER = GADGET-->
									<div class="gadget">
										<div class="gadget-body flex fl-row">
											<div class="gadget-left">
												<span>
													<i class="fas fa-ellipsis-v"></i>
												</span>
											</div>
											<div class="gadget-right flex fl-4 fl-c">
												<div>
													<span><?php echo $blog->Title;?></span>
												</div>
												<div>
													<span>Header Gadget</span>
												</div>
											</div>
											<span>
												<a href="javascript:;" id="editGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Edit</a>
							        	  	</span>
										</div>
									</div><!--gadget ends-->
								<?php endif;?>
								</div><!--layout-widget-box-ends-->
								</div><!--layout-widget-inner-ends-->
								
							</div>
						</div>
						<div class="nav-1">
							<div class="lay-border">
								
								<h3>nav</h3>
								
								<!--Layout-widget-box-->
								<div class="layout-widget-box">
								<div class="layout-widget-inner">
									<?php if($gadget = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'nav', 'position' => 2])):
											$content = json_decode($gadget->content);
									?>
									<!--NAV = GADGET-->
									<div class="gadget">
										<div class="gadget-body flex fl-row">
											<div class="gadget-left">
												<span>
													<i class="fas fa-ellipsis-v"></i>
												</span>
											</div>
											<div class="gadget-right flex fl-4 fl-c">
												<div>
													<span><?php echo $content->{'title'}?></span>
												</div>
												<div>
													<span>Nav Gadget</span>
												</div>
											</div>
											<span>
												<a href="javascript:;" id="editGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Edit</a>
							        	  	</span>
										</div>
									</div>
									<!--GADGET ENDS-->
								<?php endif;?>
								</div><!--Layout-widget-inner-->
								</div><!--Layout-widget-box-->
								
							</div>
						</div>
					</div><!--HEADER-SECTION-ENDS-->
					
					<!--MAIN-SECTION-->
					<div class="main-section flex fl-row">
						<!--MAIN-->
						<div class="main-1 fl-4">
							<div class="lay-border">
								<h3>main</h3>
								<div class="main-widget"></div>
							</div>
						</div><!--MAIN-ENDS-->
						<!--SIDEBAR-ENDS-->
						<div class="sidebar-1 fl-3">
							<div class="lay-border">
								
								<h3>sidebar</h3>
								<!--layout-widget-box-->
								<div class="layout-widget-box">
								<div class="layout-widget-inner">

									<!--add-gadget-->
									<div class="dashed-border add-gadget" data-area="sideBar" data-pos="0">
										<span><i class="fas fa-plus"></i></span>
										<span><a href="javascript:;" id="newGadget">Add a Gadget</a></span>
									</div>
									<!--add-gadget-ends-->
									
									<!-- SIDEBAR GADGETS -->
									<?php $layoutObj->sideBarGadgets($blog->blogID);?>
								</div><!--layout-widget-inner-ends-->
								</div><!--layout-widget-box-ends-->

							</div>
						</div><!--SIDEBAR-ENDS-->
					</div><!--MAIN-SECTION-ENDS-->
					
					<!--FOOTER-SECTION-->
					<div class="footer-section">
						<div class="lay-border flex fl-c">
							<h3>footer</h3>
							<!--layout-widget-box-->
							<div class="layout-widget-box">
							<div class="layout-widget-inner flex fl-row">
								<div class="footer-1 fl-1">
								<!--FOOTER 1 = GADGET-->
								<?php if($gadget = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'displayOn' => 'footer', 'position' => 1])):
										$content = json_decode($gadget->content);
								?>
									<div class="gadget">
										<div class="gadget-body flex fl-row">
											<div class="gadget-left">
												<span>
													<i class="fas fa-ellipsis-v"></i>
												</span>
											</div>
											<div class="gadget-right flex fl-4 fl-c">
												<div>
													<span><?php echo $content->{'title'};?></span>
												</div>
												<div>
													<span><?php echo $content->{'caption'};?></span>
												</div>
											</div>
											<span>
												<a href="javascript:;" id="editGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Edit</a>
												<a href="javascript:;" id="deleteGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Delete</a>
											</span>
										</div>
									</div>
								<?php else:?>
									<!--add-gadget-->	
									<div class="dashed-border add-gadget" id="addGadgetBtn" data-area="footer" data-pos="1">
										<span><i class="fas fa-plus"></i></span>
										<span><a href="javascript:;" id="newGadget">Add a Gadget</a></span>
									</div>
									<!--add-gadget-ends-->
								<?php endif;?>
									</div>
								<div class="footer-2 fl-1">
									
									<!--FOOTER 2 = GADGET-->
									<?php if($gadget = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'displayOn' => 'footer', 'position' => 2])):
										$content = json_decode($gadget->content);
								?>
									<div class="gadget">
										<div class="gadget-body flex fl-row">
											<div class="gadget-left">
												<span>
													<i class="fas fa-ellipsis-v"></i>
												</span>
											</div>
											<div class="gadget-right flex fl-4 fl-c">
												<div>
													<span><?php echo $content->{'title'};?></span>
												</div>
												<div>
													<span><?php echo $content->{'caption'};?></span>
												</div>
											</div>
											<span>
												<a href="javascript:;" id="editGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Edit</a>
												<a href="javascript:;" id="deleteGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Delete</a>
											</span>
										</div>
									</div>
								<?php else:?>
									<!--gadget ends-->

									<!--add-gadget-->	
									<div class="dashed-border add-gadget" id="addGadgetBtn" data-area="footer" data-pos="2">
										<span><i class="fas fa-plus"></i></span>
										<span><a href="javascript:;" id="newGadget">Add a Gadget</a></span>
									</div>
									<!--add-gadget-ends-->
								<?php endif;?>
									</div>
								<div class="footer-3 fl-1">
									<!--FOOTER 3 = GADGET-->
									<?php if($gadget = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'displayOn' => 'footer', 'position' => 3])):
										$content = json_decode($gadget->content);
								?>
									<div class="gadget">
										<div class="gadget-body flex fl-row">
											<div class="gadget-left">
												<span>
													<i class="fas fa-ellipsis-v"></i>
												</span>
											</div>
											<div class="gadget-right flex fl-4 fl-c">
												<div>
													<span><?php echo $content->{'title'};?></span>
												</div>
												<div>
													<span><?php echo $content->{'caption'};?></span>
												</div>
											</div>
											<span>
												<a href="javascript:;" id="editGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Edit</a>
												<a href="javascript:;" id="deleteGadget" data-blog="<?php echo $blog->blogID?>" data-type="<?php echo $gadget->type;?>" data-area="<?php echo $gadget->displayOn;?>" data-pos="<?php echo $gadget->position;?>">Delete</a>
											</span>
										</div>
									</div>
								<?php else:?>
									<!--gadget ends-->
									<!--add-gadget-->
									<div class="dashed-border add-gadget" data-area="footer" data-pos="3">
										<span><i class="fas fa-plus"></i></span>
										<span><a href="javascript:;" id="newGadget">Add a Gadget</a></span>
									</div>
								<?php endif;?>
									<!--add-gadget-ends-->
									</div>	
							</div><!--layout-widget-inner-ends-->
							</div><!--layout-widget-box-ends-->

						</div>
					</div>
					<!--FOOTER-ends-->
				
				</div>
				<!--LAYOUT-ENDS-->
				</div>
				<!--layout-inner-->
				</div>
				<!--layout-wrapper-->
				<!-- JS FILES -->
 				<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/drag-and-drop.js"></script>
 				<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/layout.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/addNewBlog.js"></script>

			</div>
			</div>
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