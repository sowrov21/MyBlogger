<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$title        = Validate::escape($_POST['title']);
			$area         = Validate::escape($_POST['area']);
			$blog         = $dashObj->blogAuth($blogID);
			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => 'search', 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			
			if($blog){
				if($blog->role === "Admin"){
					$content = '{"title": "'.$title.'", "caption" : "Blog Search Gadget"}';
					if(!$gadget){
						$userObj->create('gadgets', ['blogID'      => $blog->blogID, 
													 'type'        => 'search', 
													 'content'     => $content, 
													 'displayOn'   => $area, 
													 'position'    => $pos, 
													 'html'        => '']);

					}else{
						$userObj->update('gadgets',['content' => $content], ['blogID'      => $blog->blogID, 
													 'type'        => 'search', 
													 'displayOn'   => $area, 
													 'position'    => $pos]);
					}
				}
			}
		}
	}