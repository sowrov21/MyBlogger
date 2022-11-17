<?php 
	include '../init.php';

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(isset($_POST['blogID'])){
			$blogID       = (int) $_POST['blogID'];
			$pos          = (int) $_POST['pos'];
			$title        = Validate::escape($_POST['title']);
			$area         = Validate::escape($_POST['area']);
			$blog         = $dashObj->blogAuth($blogID);
			$links        = json_decode($_POST['urlArr']);
			$names        = json_decode($_POST['nameArr']);
			$gadget       = $userObj->get('gadgets', ['blogID'    => $blog->blogID, 
													  'type'      => 'nav', 
													  'displayOn' => $area, 
													  'position'  => $pos]);
			$data         = '';
			$i            = 1;

			foreach ($links as $key => $link) {
				$data .= '"link'.$i.'" : "'.$link.'", "name'.$i.'" : "'.$names[$key].'"';
				if($i < count($links)){
					$data .= ",";
				}
				$i++;
			}
			if($blog){
				if($blog->role === "Admin"){
					$content = '{"title": "'.$title.'", "caption" : "Nav Gadget", '.$data.', "total" : "'.count($links).'"}';

					
					$userObj->update('gadgets',['content' => $content], ['blogID'      => $blog->blogID, 
												 'type'        => 'nav',
												 'displayOn'   => $area, 
												 'position'    => $pos]);
					
				}
			}
		}
	}