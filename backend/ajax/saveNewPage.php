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
												   'postType'    => 'Page', 
												   'isComments'  => 'blocked'], 
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
											   'postType'    => 'Page',
											   'isComments'  => 'blocked', 
											   'createdDate' => $date]);
				    }

					echo $postID;
				}
			}
		}
	}