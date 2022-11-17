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
												   'postType'    => 'Page', 
												   'isComments'  => 'blocked'], 
												   ['postID' => $post->postID, 
												    'blogID' => $blog->blogID]);
					}
				}
			}
		}
	}