<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
 			$blog         = $dashObj->blogAuth($blogID);
 			
			
			if($blog){
				if($blog->role === "Admin"){
					 $html = file_get_contents('../../index.php', FALSE, NULL, 222);
					 $html = $templateObj->addTemplateTags($html);
					 $html = htmlentities($html);
					 $userObj->update('blogs', ['Template' => $html], ['blogID' => $blog->blogID]);
					 echo 'Template is successfully restored';
				}else{
					echo 'You cannot preform this action!';
				}
			}
		}
	}