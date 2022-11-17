<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$title        = Validate::escape($_POST['title']);
			$area         = Validate::escape($_POST['area']);
			$desc         = Validate::escape($_POST['desc']);
			$fbUrl        = Validate::escape($_POST['fbUrl']);
			$twUrl        = Validate::escape($_POST['twUrl']);
			$igUrl        = Validate::escape($_POST['igUrl']);
			$ytUrl        = Validate::escape($_POST['ytUrl']);
			$blog         = $dashObj->blogAuth($blogID);
			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => 'profile', 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			
			if($blog){
				if($blog->role === "Admin"){
					$content = '{"title": "'.$title.'", "caption" : "Profile Gadget", "description" : "'.$desc.'", "Facebook" : "'.$fbUrl.'", "Twitter" : "'.$twUrl.'", "Instagram" : "'.$igUrl.'", "Youtube" : "'.$ytUrl.'"}';
					if(!$gadget){
						$userObj->create('gadgets', ['blogID'      => $blog->blogID, 
													 'type'        => 'profile', 
													 'content'     => $content, 
													 'displayOn'   => $area, 
													 'position'    => $pos, 
													 'html'        => '']);

					}else{
						$userObj->update('gadgets',['content' => $content], ['blogID'      => $blog->blogID, 
													 'type'        => 'profile',
													 'displayOn'   => $area, 
													 'position'    => $pos, 
													 'html'        => '']);
					}
				}
			}
		}
	}
