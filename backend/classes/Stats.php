<?php 
 
	class Stats{
		protected $pdo;
		protected $user;
   
		public function __construct(){
			$this->pdo    = Database::instance();
			$this->user   = new Users;
  		}

 		public function getIP(){
 			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
 				$ip = $_SERVER['HTTP_CLIENT_IP'];
 			}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
 				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 			}else{
 				$ip = $_SERVER['REMOTE_ADDR'];
 			}

 			return $ip;
 		}

 		public function getCountry($ip){
 			$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip={$ip}");
 			return $xml->geoplugin_countryName;
 		}

 		public function getReferLink($subdomain){
 			if(isset($_SERVER['HTTP_REFERER'])){
 				$url = parse_url($_SERVER['HTTP_REFERER']);
 				return "http://{$url['host']}";
 			}else{
 				return "http:///{$subdomain}.localhost/MyBlogger/";
 			}
 		}
 		public function getStats($blogID, $type){
 			if($type === 'alltime'){
 				$sql = "SELECT *, count(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID ORDER BY `statsID` DESC";
 			}else{
 				$sql = "SELECT *, count(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID ORDER BY `date` DESC";

 			}

 			if($type === 'today'){
 				$offset = date('Y-m-d');
 			}elseif($type === 'yesterday'){
 				$offset = date('Y-m-d', strtotime('-1 day'));
 			}elseif($type === 'week'){
 				$offset = date('Y-m-d', strtotime('-7 day'));
 			}elseif($type === 'month'){
 				$offset = date('Y-m-d', strtotime('-1 month'));
 			}

 			$stmt = $this->pdo->prepare($sql);
 			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
 			($type !== 'alltime') ? $stmt->bindParam(":offset", $offset, PDO::PARAM_STR) : '';
 			$stmt->execute();
 			$data = $stmt->fetch(PDO::FETCH_OBJ);

 			if($data){
  				echo '<div class="st-body-list">
						<div class="flex fl-row">
							<div class="fl-4">
							</div>
							<div class="fl-1">
								'.$data->pageviews.'
							</div>
						</div>
					</div>
					';
 			}
 		}


 		public function getAudience($blogID, $type){
 			$offset = '';
 			if($type === 'alltime'){
 				$sql = "SELECT *, count(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID GROUP BY `country`";
 			}else{
 				$sql = "SELECT *, count(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID GROUP BY `country`";

 			}

 			if($type === 'today'){
 				$offset = date('Y-m-d');
 			}elseif($type === 'yesterday'){
 				$offset = date('Y-m-d', strtotime('-1 day'));
 			}elseif($type === 'week'){
 				$offset = date('Y-m-d', strtotime('-7 day'));
 			}elseif($type === 'month'){
 				$offset = date('Y-m-d', strtotime('-30 day'));
 			}

 			$stmt = $this->pdo->prepare($sql);
 			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
 			($type !== 'alltime') ? $stmt->bindParam(":offset", $offset, PDO::PARAM_STR) : '';
 			$stmt->execute();
 			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

 			if(empty($data)){
 				echo '<p>No stats yet, check back later.</p>';
 			}else{
 				foreach ($data as $key => $country) {
 					echo '<div class="st-body-list">
						<div class="flex fl-row">
							<div class="fl-4">
								<p>'.$country->country.'</p>
							</div>
							<div class="fl-1">
								'.$country->pageviews.'
							</div>
						</div>
					</div>
					';
 				}
 			}
 		}

 		public function getReferringSites($blogID, $type){
 			$offset = '';
 			if($type === 'alltime'){
 				$sql = "SELECT `referLink`, count(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID AND `referLink` IS NOT NULL GROUP BY `referLink` ORDER BY `pageviews` DESC";
 			}else{
 				$sql = "SELECT `referLink`, count(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID AND `referLink` IS NOT NULL GROUP BY `referLink` ORDER BY `pageviews` DESC";

 			}

 			if($type === 'today'){
 				$offset = date('Y-m-d');
 			}elseif($type === 'yesterday'){
 				$offset = date('Y-m-d', strtotime('-1 day'));
 			}elseif($type === 'week'){
 				$offset = date('Y-m-d', strtotime('-7 day'));
 			}elseif($type === 'month'){
 				$offset = date('Y-m-d', strtotime('-30 day'));
 			}

 			$stmt = $this->pdo->prepare($sql);
 			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
 			($type !== 'alltime') ? $stmt->bindParam(":offset", $offset, PDO::PARAM_STR) : '';
 			$stmt->execute();
 			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

 			if(empty($data)){
 				echo '<p>No stats yet, check back later.</p>';
 			}else{
 				foreach ($data as $data) {
 					echo '<div class="st-body-list">
						<div class="flex fl-row">
							<div class="fl-4">
								<p><a href="#">'.$data->referLink.'</a></p>
							</div>
							<div class="fl-1">
								'.$data->pageviews.'
							</div>
						</div>
					</div>
					';
 				}
 			}
 		}


 		public function getPosts($blogID, $type){
 			$offset = '';
 			if($type === 'alltime'){
 				$sql = "SELECT *,`S`.`postID`, count(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Post' GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
 			}else{
 				$sql = "SELECT *,`S`.`postID`, count(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Post' AND date(`S`.`date`) = :offset  GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";

 			}

 			if($type === 'today'){
 				$offset = date('Y-m-d');
 			}elseif($type === 'yesterday'){
 				$offset = date('Y-m-d', strtotime('-1 day'));
 			}elseif($type === 'week'){
 				$offset = date('Y-m-d', strtotime('-7 day'));
 			}elseif($type === 'month'){
 				$offset = date('Y-m-d', strtotime('-30 day'));
 			}

 			$stmt = $this->pdo->prepare($sql);
 			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
 			($type !== 'alltime') ? $stmt->bindParam(":offset", $offset, PDO::PARAM_STR) : '';
 			$stmt->execute();
 			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

 			if(empty($data)){
 				echo '<p>No stats yet, check back later.</p>';
 			}else{
 				foreach ($data as $data) {
 					$date = new DateTime($data->date);
 					echo '<div class="st-body-list">
						<div class="flex fl-row">
							<div class="fl-4">
								<p><a href="#">'.$data->title.'</a></p>
								<p>'.$date->format("M d, Y").'</p>
							</div>
							<div class="fl-1">
								'.$data->pageviews.'
							</div>
						</div>
					</div>
					';
 				}
 			}
 		}


 		public function getPages($blogID, $type){
 			$offset = '';
 			if($type === 'alltime'){
 				$sql = "SELECT *,`S`.`postID`, count(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Page' GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
 			}else{
 				$sql = "SELECT *,`S`.`postID`, count(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Page' AND date(`S`.`date`) = :offset  GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";

 			}

 			if($type === 'today'){
 				$offset = date('Y-m-d');
 			}elseif($type === 'yesterday'){
 				$offset = date('Y-m-d', strtotime('-1 day'));
 			}elseif($type === 'week'){
 				$offset = date('Y-m-d', strtotime('-7 day'));
 			}elseif($type === 'month'){
 				$offset = date('Y-m-d', strtotime('-30 day'));
 			}

 			$stmt = $this->pdo->prepare($sql);
 			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
 			($type !== 'alltime') ? $stmt->bindParam(":offset", $offset, PDO::PARAM_STR) : '';
 			$stmt->execute();
 			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

 			if(empty($data)){
 				echo '<p>No stats yet, check back later.</p>';
 			}else{
 				foreach ($data as $data) {
 					$date = new DateTime($data->date);
 					echo '<div class="st-body-list">
						<div class="flex fl-row">
							<div class="fl-4">
								<p><a href="#">'.$data->title.'</a></p>
								<p>'.$date->format("M d, Y").'</p>
							</div>
							<div class="fl-1">
								'.$data->pageviews.'
							</div>
						</div>
					</div>
					';
 				}
 			}
 		}
	}