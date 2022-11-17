<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$title        = Validate::escape($_POST['title']);
			$area         = Validate::escape($_POST['area']);
			$desc         = Validate::escape($_POST['desc']);
			$blog         = $dashObj->blogAuth($blogID);
			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => 'header', 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			
			if($blog){
				if($blog->role === "Admin"){
					$content = '{"title": "'.$title.'", "caption" : "Header Gadget"}';
					
					$userObj->update('blogs',  ['Title' => $title, 'Description' => $desc], 
											   ['blogID'  => $blog->blogID]);

					$userObj->update('gadgets',['content' => $content], ['blogID'      => $blog->blogID, 
												 'type'        => 'header',
												 'displayOn'   => $area, 
												 'position'    => $pos, 
												 'html'        => '']);
					
				}
			}
		}
	}
