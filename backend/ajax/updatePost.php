<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$postID       = (int) $_POST['postID'];
			$title        = Validate::escape($_POST['title']);
			$description  = Validate::escape($_POST['description']);
			$slug         = Validate::escape($_POST['slug']);
			$blog         = $dashObj->blogAuth($blogID);
			$post         = $userObj->get('posts', ['postID' => $postID, 'blogID' => $blog->blogID]);
			$slug         = $blogObj->createPostSlug($slug, $blog->blogID, $postID);
			$comments     = (($_POST['comments'] === "allowed") ? 'allowed' : 'blocked');
			$labels       = $_POST['labels'];
			$labels       = explode(',', $labels);
			$content     = $_POST['content'];
			$date        = date('Y-m-d H:i:s');
			
			if($blog){
				if(!empty($title)){
					if($blog->role === "Admin" OR $blog->userID === $post->authorID){
 						$postID = $userObj->update('posts', [
												   'title'       => $title, 
												   'description' => $description, 
												   'slug'        => $slug, 
												   'content'     => $content, 
												   'postStatus'  => 'published', 
												   'isComments'  => $comments], 
												   ['postID' => $post->postID, 
												    'blogID' => $blog->blogID]);

						foreach($labels as $label){
							$label = Validate::escape($label);
							$row   = $userObj->get('labels', ['labelname' => $label, 
															  'postID'    => $post->postID, 
															  'blogID'    => $blog->blogID]);						
							if(!$row){
								$userObj->dalete('labels', ['postID'    => $postID, 
															'blogID'    => $blog->blogID]);
							}
						}

						foreach($labels as $label){
							$label = Validate::escape($label);
							if(!empty($label)){
								$row   = $userObj->get('labels', ['labelname' => $label, 
															  'postID'    => $post->postID, 
															  'blogID'    => $blog->blogID]);						
								if(!$row){
									$userObj->create('labels', ['labelName' => $label,
																'postID'    => $postID, 
																'blogID'    => $blog->blogID]);
								}
							}
						}
					}
				}
			}
		}
	}