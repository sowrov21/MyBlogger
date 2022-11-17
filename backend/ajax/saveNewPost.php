<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$postID       = ((isset($_POST['postID'])) ? (int) $_POST['postID'] : null);
			$title        = Validate::escape($_POST['title']);
			$description  = Validate::escape($_POST['description']);
			$slug         = Validate::escape($_POST['slug']);
			$blog         = $dashObj->blogAuth($blogID);
			$slug         = $blogObj->createPostSlug($slug, $blog->blogID, $postID);
			$comments     = (($_POST['comments'] === "allowed") ? 'allowed' : 'blocked');
			$labels       = $_POST['labels'];
			$labels       = explode(',', $labels);
			$content     = $_POST['content'];
			$date        = date('Y-m-d H:i:s');
			
			if($blog){
				if(!empty($title)){
					$post   = $userObj->get('posts', ['postID' => $postID, 'blogID' => $blog->blogID]);
					if($post){
						$postID = $userObj->update('posts', [
												   'title'       => $title, 
												   'description' => $description, 
												   'slug'        => $slug, 
												   'content'     => $content, 
												   'postStatus'  => 'draft',
												   'postType'    => 'Post', 
												   'isComments'  => $comments], 
												   ['postID' => $post->postID, 
												    'blogID' => $blog->blogID]);
						$postID = $post->postID;
					}else{
					$postID = $userObj->create('posts', ['title'       => $title, 
											   'description' => $description, 
											   'slug'        => $slug, 
											   'authorID'    => $blog->userID, 
											   'blogID'      => $blog->blogID, 
											   'content'     => $content, 
											   'postStatus'  => 'draft', 
											   'isComments'  => $comments, 
											   'createdDate' => $date]);
					}

					foreach($labels as $label){
						$label = Validate::escape($label);
						if(!empty($label)){
							$userObj->create('labels', ['labelName' => $label, 
														'postID'    => $postID, 
														'blogID'    => $blog->blogID]);
						}
					}
					echo $postID;
				}
			}
		}
	}