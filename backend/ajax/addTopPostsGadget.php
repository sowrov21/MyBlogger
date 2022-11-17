<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$title        = Validate::escape($_POST['title']);
			$area         = Validate::escape($_POST['area']);
			$postLimit    = (int) $_POST['postLimit'];
			$blog         = $dashObj->blogAuth($blogID);
			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => 'topPosts', 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			
			if($blog){
				if($blog->role === "Admin"){
					$content = '{"title": "'.$title.'", "caption" : "Popular Posts Gadget", "postLimit" : "'.$postLimit.'"}';
					if(!$gadget){
						$userObj->create('gadgets', ['blogID'      => $blog->blogID, 
													 'type'        => 'topPosts', 
													 'content'     => $content, 
													 'displayOn'   => $area, 
													 'position'    => $pos, 
													 'html'        => '']);

					}else{
						$userObj->update('gadgets',['content' => $content], ['blogID'      => $blog->blogID, 
													 'type'        => 'topPosts',  
													 'displayOn'   => $area, 
													 'position'    => $pos]);
					}
				}
			}
		}
	}