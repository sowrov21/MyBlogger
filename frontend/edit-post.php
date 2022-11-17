<?php

	include '../backend/init.php';
	if(isset($_GET['postID']) && isset($_GET['blogID'])){
		$blogID = (int) $_GET['blogID'];
		$postID = (int) $_GET['postID'];
		$blog   = $dashObj->blogAuth($blogID);
		$post   = $userObj->get('posts', ['postID' => $postID, 'blogID' => $blog->blogID]);

  		if(!$blog){
			header('Location: 404');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EDIT POST - MyBlogger</title>
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
		<div class="header-in flex fl-row">
			<div class="header-left flex fl-row fl-1">
				<div class="logo flex fl-row fl-1">
					<div><i class="fab fa-blogger"></i></div>
					<div class="fl-1">
						<h3>MyBlogger</h3>
					</div>
				</div>
				<div class="fl-4">
					<h3>Edit Post</h3>
				</div>
			</div>
			<div class="header-right fl-2">
				<div class="h-r-in">
					<img src="<?php echo BASE_URL.$blog->profileImage;?>"/>
				</div>
			</div>
		</div><!--HEADER-IN-ENDS-HERE-->
	</header>
	</div><!--HEADER-WRAPPER-ENDS-HERE-->
	<div class="edit-wrap fl-4">
	<div class="edit-wrap-inner flex fl-c">
		<div class="edit-head-wrap">
		<div class="edit-head-inner flex fl-row">
			<div class="edit-post-title">
			<div class="edit-pt">
				<h2 class="flex fl-row">
					<a href="#" class="fl-1"><?php echo $blog->Title;?>
					</a>
					<span>Post</span>
				</h2>
			</div>
			</div>
			<div class="edit-input fl-4">
				<input type="text" id="title" name="title" value="<?php echo $post->title;?>"/>
			</div>
			<div class="edit-button flex fl-row">
				<div class="flex fl-row ">
					<div class="avatar-image">
						<img src="<?php echo BASE_URL.$blog->profileImage;?>">
					</div>
					<div class="fl-1">Posting as 
						<span class="bold">
							<?php echo $blog->fullName;?>
						</span>
					</div>
				</div>
				<div class="eb-buttons flex fl-1">
					<div>
						<?php if($post->postStatus === "draft"):?>
						<button id="publish" data-blog="<?php echo $blog->blogID?>" data-post="<?php echo $post->postID;?>">Publish</button>
						<button id="saveBtn">Save</button>
						<?php else:?>

						<button id="publish" data-blog="<?php echo $blog->blogID?>" data-post="<?php echo $post->postID;?>">Update</button>
						<button id="draft">Revent to draft</button>
						<?php endif;?>
  						<button onclick="window.location.href='<?php echo BASE_URL.'admin/blogID/'.$blog->blogID.'/dashboard/';?>'">Close</button>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="edit-main-wrap fl-4">
			<div class="edit-main-inner flex fl-row">
			<div class="edit-main-left fl-4 fl-c">
			<div class="edit-main-editor">
				 <link href="<?php echo BASE_URL;?>frontend/assets/css/quill.snow.css" rel="stylesheet">
					<!-- Create the editor container -->
					<div id="editor">
						<?php echo $post->content;?>
					</div>

					<!-- Include the Quill library -->
					<script src="<?php echo BASE_URL;?>frontend/assets/js/quill.js"></script>

					<!-- Initialize Quill editor -->
					<script type="text/javascript">

					  var toolbarOptions = [
						  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
						  ['blockquote', 'code-block'],

						  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
						  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
						  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
						  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
						  [{ 'direction': 'rtl' }],                         // text direction

						  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
						  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

						  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
						  [{ 'font': [] }],
						  [{ 'align': [] }],
						  ['link', 'image',{ 'size': ['small', false, 'large', 'huge'] }],

						  ['clean']                                         // remove formatting button
						];
						var editor = new Quill('#editor', {
							modules: {
								    toolbar: toolbarOptions
								  },
						    theme: 'snow'
						  });

						function selectImage(){
								var input = document.createElement('input');
								input.setAttribute('type','file');
								input.click();

								input.onchange = function(){
									var file = input.files[0];

									if(/^image\//.test(file.type)){
										var formData  = new FormData();

										formData.append("image", file);

										var httpRequest = new XMLHttpRequest();

										if(httpRequest){
											httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/uploadImage.php', true);
											httpRequest.onreadystatechange = function(){
												if(this.readyState === 4 && this.status === 200){
													if(this.responseText.length != 0){
														var url   = JSON.parse(this.responseText).url;
														var range = editor.getSelection();
														editor.insertEmbed(range.index, 'image', 'http://localhost/MyBlogger/'+url); 
													}
												}
											}

											httpRequest.send(formData);
										}	
									}else{
										alert('You can only upload images');
									}
								}
							}

							editor.getModule('toolbar').addHandler('image', function(){
								selectImage();
							});
					</script>
			</div>
			</div>
				<div class="edit-main-right fl-1">
				<div class="edit-main-right-inner">
					<div class="edit-right-menu">
						<div class="edit-right-menu-inner">
							<div class="edit-menu-title">
								<a href="#">
									<span><i class="fas fa-sort-down"></i></span>
									<span>Post Settings</span>
								</a>
							</div>
							<div class="edm-label-box edit-active">
								<a href="#">
								<div class="edm-label-head">
									<span><i class="fas fa-tag"></i></span>
									<span>Label</span>
								</div>
								</a>
								<div class="edm-label-show">
									<div id="postLabels">
										<?php echo strip_tags($blogObj->getPostLabels($post->postID, $post->blogID));?>
									</div>
								</div>	
								<div class="edm-label-body" id="label">
									<div class="edm-label-textarea">
										<textarea rows="4" id="labelArea"><?php echo strip_tags($blogObj->getPostLabels($post->postID, $post->blogID));?></textarea>
										<span>Separate labels by commas</span>
									</div>
									<div class="edm-label-list">
										<div>
 											<?php echo $blogObj->getAllLabels($blog->blogID);?>
										</div>
									</div>
									<div class="edm-label-button">
 									</div>
								</div>
							</div><!--EDIT MENU LABEL BOX ENDS-->
							<div class="edm-label-box">
								<a href="#">
								<div class="edm-label-head">
									<span><i class="fas fa-link"></i></span>
									<span>Permalink</span>
 								</div>
								</a>
								<div class="edm-label-show">
									<div>
										<span id="urlError" style="color:red;"></span>
										<div class="short-div" id="slugDiv"><?php echo "http://www.{$blog->Domain}.localhost/MyBlogger/{$post->slug}";?></div>
									</div>
								</div>	
								<div class="edm-label-body">
									<div class="edm-label-list">
										<div class="radio-btn-box">
											<input id="auto" class="postLinkOp" type="radio" name="link" value="automatic" checked="true">
											<label for="auto">Automatic Permalink</label><br>
											<input id="custom" class="postLinkOp" type="radio" name="link" value="custom">
											<label for="custom">Custom Permalink</label>
										</div>
									</div>
								<div id="custom-url-area">
										<div class="custom-input">
											<input type="text" name="slug" id="customSlug">
											<span>.html</span>
										</div>
									
									<div class="edm-label-button">
 									</div>
								</div>
								</div>
							</div><!--EDIT MENU LABEL BOX ENDS-->
							<div class="edm-label-box">
								<a href="#">
								<div class="edm-label-head">
									<span><i class="fas fa-search"></i></span>
									<span>Search Description</span>
								</div>
								</a>
								<div class="edm-label-body">
									<div class="edm-label-textarea">
										<textarea rows="4" id="description"><?php echo $post->description; ?></textarea>
									</div>
									<div class="edm-label-button">
 									</div>
								</div>
							</div><!--EDIT MENU LABEL BOX ENDS-->
							<div class="edm-label-box">
								<a href="#">
								<div class="edm-label-head">
									<span><i class="fas fa-cog"></i></span>
									<span>Options</span>
								</div>
								</a>
								<div class="edm-label-show">
									<div>
										 Reader comments
									</div>
								</div>	
								<div class="edm-label-body">
									<div class="edm-label-list">
										<div class="radio-btn-box">
											<input id="allow" type="radio"  class="comments" name="commentOption" value="allowed" <?php echo (($post->isComments === "allowed") ? 'checked' : '');?>>
											<label for="allow">Allow</label><br>
											<input id="dont-allow" type="radio"  class="comments" name="commentOption"value="blocked" <?php echo (($post->isComments === "blocked") ? 'checked' : '');?>>
											<label for="dont-allow">Don't allow</label>
										</div>
									</div>
									<div class="edm-label-button">
 									</div>
								</div>
							</div>
							<!--EDIT MENU LABEL BOX ENDS-->
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<!-- JS Files -->
		<script type="text/javascript" src="<?php echo BASE_URL;?>frontend/assets/js/editPost.js"></script>
	</div>
	<!--EDIT-INNER-ENDS-->	
	</div>
	<!--EDIT-WRAP-ENDS-->
</div>
</div>
</body>
</html>