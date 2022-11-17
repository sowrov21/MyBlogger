<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$dragFrom     = json_decode($_POST['dragFrom']);
			$dropTo       = json_decode($_POST['dropTo']);
			$blog         = $dashObj->blogAuth($blogID);
			
			
			if($blog){
				if($blog->role === "Admin"){
					foreach ($dragFrom as $key => $dragFrom) {
						$drag = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'gadgetID' => $dropTo[$key]]); 
						$drop = $userObj->get('gadgets', ['blogID' => $blog->blogID, 'gadgetID' => $dragFrom]); 
					
						if($drag){
							$userObj->update('gadgets', ['type'       => $drop->type, 
														 'content'    => $drop->content, 
														 'position'   => $drag->position, 
														 'displayOn'  => $drag->displayOn, 
														 'html'       => $drag->html], 

														 ['blogID'  => $blog->blogID, 
														  'gadgetID' => $drag->gadgetID]);

							$userObj->update('gadgets', ['type'       => $drag->type, 
														 'content'    => $drag->content, 
														 'position'   => $drop->position, 
														 'displayOn'  => $drop->displayOn, 
														 'html'       => $drop->html], 

														 ['blogID'  => $blog->blogID, 
														  'gadgetID' => $drop->gadgetID]);
						}
					}
				}else{
					echo "You can't preform this action!";
				}
			}
		}
	}