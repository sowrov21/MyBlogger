<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$area         = Validate::escape($_POST['area']);
			$type         = Validate::escape($_POST['type']);
			$blog         = $dashObj->blogAuth($blogID);

			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => $type, 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			
			if(!empty($gadget)){
				if($blog){
					if($blog->role === "Admin"){
						$userObj->delete('gadgets', ['gadgetID' => $gadget->gadgetID]);
					}else{
						echo "you can't preform this action!";
					}
				}
			}
		}
	}