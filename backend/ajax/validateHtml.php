<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$html         = $_POST['html'];
			$blog         = $dashObj->blogAuth($blogID);
			$shortCodes   = ["TITLE", "META", "HEADER", "NAV", "POSTS", "SIDEBAR", "FOOTER"];
			
			
			if($blog){
				if($blog->role === "Admin"){
					foreach ($shortCodes as $key => $value) {
						$count = preg_match_all('/{{'.$value.'}}/', html_entity_decode($html), $matches);
					
						if($count === 1){
							if($key === 6){
								$html = htmlentities($html);
								$userObj->update('blogs', ['Template' => $html, 'DefaultTemplate' => 'false'], ['blogID' => $blog->blogID]);

							}
						}else{
							echo 'You cannot add or remove blog reserverd tags!';
							break;
						}
					}
				}else{
					echo 'You cannot preform this action!';
				}
			}
		}
	}