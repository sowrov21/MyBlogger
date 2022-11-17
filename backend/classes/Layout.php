<?php

	class Layout extends Blog { 
		protected $db;
		protected $user;
		

		public function __construct(){
			$this->db   = Database::instance();
			$this->user = new Users; 
 		}

		public function getBlog(){
			if(preg_match('/^([a-zA-Z0-9]+)\.localhost/',$_SERVER['HTTP_HOST'], $match)){
				$subdomain = $match[1];

				if($blog = $this->user->get('blogs', ['domain' => $subdomain])){
					return $blog;
				}else{
					$this->user->redirect('404');
				}
			}
		}

		public function getHeaderGadget(){
			$blog    = $this->getBlog();
			$gadget  = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'header', 'position' => '1']);
			$content = json_decode($gadget->content);
			if($gadget){
				echo '<header>
						<div class="bg-des-title-wrap">
							<a href="'.BASE_URL.'">
								<h1 class="blogtitle">'.$blog->Title.'</h1>
							</a>
							<p>
							  '.$blog->Description.'
							</p>
						</div>
					</header>
					';
			}
		}


		public function getNavGadget(){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'nav', 'displayOn' => 'nav', 'position' => '2']);
			$content = json_decode($gadget->content);

			if($gadget){
				?>
				<nav>
					<?php 
						for ($i=1; $i <= $content->{'total'} ; $i++) { 
							echo '<a href="'.$content->{'link'.$i}.'">'.$content->{'name'.$i}.'</a>';
						}
					?>
				</nav>
				<?php
			} 
		}

		public function getSearchGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'search', 'displayOn' => $area]);
			if($gadget){
				echo '<!--Search WRAP-->
						<div class="search-wrap">
						<div class="search-inner">
							<div class="search-box">
								<div class="aside-heading">
									<h3>Search</h3>	
								</div>
								<div class="search-input">
									<span>
										<input type="text" name="search" id="search" >
									</span>
									<span>
										<button id="searchBtn">Search</button>
									</span>
								</div>
							</div>
						</div>	
						</div>
						<!--Search Ends here-->
						<script type="text/javascript" src="'.BASE_URL.'frontend/assets/js/searchBlog.js"></script>';
			} 
		}

		public function getLabelsGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'labels', 'displayOn' => $area]);
			if($gadget){
				$stmt = $this->db->prepare("SELECT * FROM `labels` WHERE `blogID` = :blogID GROUP BY `labelName`");
				$stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
				$stmt->execute();
				$labels = $stmt->fetchAll(PDO::FETCH_OBJ);
				?>
				<div class="label-wrap">
					<div class="label-inner">
						<div class="label">
							<div class="aside-heading">
								<h3>Labels</h3>	
							</div>
							<div class="label-lists">
								<ul>
								 <?php 
								 	foreach ($labels as $label) {
								 		echo '<li><a href="'.BASE_URL.'search/label/'.$label->labelName.'">'.$label->labelName.'</a></li>';
								 	}
								 ?>	
								</ul>
							</div>
						</div>
					</div>	
				</div><!--LABLES WRAP ends-->
				<?php 
			}
		}

		public function getHtmlGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'html', 'displayOn' => $area]);
			if($gadget){
				$content = json_decode($gadget->content);
				?>
				<div class="label-wrap">
				<div class="label-inner">
					<div class="label">
						<div class="aside-heading">
							<h3><?php echo $content->{'title'};?></h3>	
						</div>
						<div class="label-lists">
							<?php echo $gadget->html;?>
						</div>
					</div>
				</div>	
				</div><!--LABLES WRAP ends-->
				<?php
			}
		}

		public function getListGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'list', 'displayOn' => $area]);

			if($gadget){
				$content  = json_decode($gadget->content);
				?>
				<!--LIST WIDGET-->
				<div class="list-widget-wrap">
				<div class="list-widget-inner">
					<div class="aside-heading">
						<h3>Lists</h3>	
					</div>
					<div class="list-body">
						<ul>
						 <?php 
							for ($i=1; $i <= $content->{'total'} ; $i++) { 
								echo '<li><a href="'.$content->{'link'.$i}.'">'.$content->{'name'.$i}.'</a></li>';
							}
						 ?>								 
					   </ul>
					</div>
				</div>	
				</div><!--LIST WIDGET ENDS-->
				<?php
			} 
		}

		public function getAuthorGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'profile', 'displayOn' => $area]);
			$author = $this->user->userData($blog->CreatedBy);
			if($gadget){
				$content  = json_decode($gadget->content);
				echo '<!--ABOUTME WRAP-->
						<div class="aboutme-wrap">
							<div class="aboutme-inner">
								<div class="about-me">
									<div class="aside-heading">
										<h3>About</h3>	
									</div>
									<div class="aboutme-img">
										<img src="'.BASE_URL.$author->profileImage.'"/>
									</div>
									<div class="aboutme-body">
										<p>'.$content->{'description'}.'</p>
									</div>
									<div class="aboutme-footer">
									<div class="aboutme-social">
										<ul>
										'.(($content->{'Facebook'} !== '') ? 
											'<li><a href="'.$content->{'Facebook'}.'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>' : 
										'').'

										 '.(($content->{'Twitter'} !== '') ? 
											' <li><a href="'.$content->{'Twitter'}.'" target="_blank"><i class="fab fa-twitter"></i></a></li>' : 
										'').'

										 '.(($content->{'Instagram'} !== '') ? 
											'<li><a href="'.$content->{'Instagram'}.'" target="_blank"><i class="fab fa-instagram"></i></a></li>' : 
										'').'

									   '.(($content->{'Youtube'} !== '') ? 
											'<li><a href="'.$content->{'Youtube'}.'" target="_blank"><i class="fab fa-youtube"></i></a></li>' : 
										'').'
										</ul>
									</div>
									</div>
								</div>
							</div>
						</div>
						';
			}
		}

		public function getTopPostsGadget($area){
			$blog   = $this->getBlog();
			$gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'topPosts', 'displayOn' => $area]);
			$author = $this->user->userData($blog->CreatedBy);
			if($gadget){
				$content  = json_decode($gadget->content);
				$stmt = $this->db->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `authorID` = `userID` WHERE `blogID` = :blogID ORDER BY `postID` DESC LIMIT :postLimit");
				$stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
				$stmt->bindParam(":postLimit", $content->{'postLimit'}, PDO::PARAM_INT);
				$stmt->execute();
				$posts =  $stmt->fetchAll(PDO::FETCH_OBJ);
				?>
				<!--PAPULAR POST WRAP-->
				<div class="papular-wrap">
				<div class="papular-inner">
					<div class="papular">
						<div class="aside-heading">
							<h3><?php echo $content->{'title'}?></h3>	
						</div>
						<div class="papular-body">
						<?php 
							foreach ($posts as $post) {
								echo '<div class="papular-list">
										<div class="papular-img">
											<img src="'.$this->getFirstImage($post->content).'"/>
										</div>
										<div class="papular-links">
										<a href="http://'.$blog->Domain.'.localhost/MyBlogger/'.$post->slug.'">
										   '.$post->title.'
										</a>
										</div>
									</div>';
							}
						?>			 
						</div>
					</div>	
				</div>
				</div><!--PAPULAR POST ENDS-->
				<?php
			}
		}

		public function getAllGadgets($blogID = ''){
			if($blogID != ''){
				$blog = $this->user->get('blogs', ['blogID' => $blogID]);
			}else{
				$blog = $this->getBlog();
			}

			$stmt = $this->db->prepare("SELECT * FROM `gadgets` WHERE `blogID` = :blogID ORDER BY `position`");
			$stmt->bindParam("blogID", $blog->blogID, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getSideBar(){
			$gadgets  = $this->getAllGadgets();
			$i = 1;

			foreach($gadgets as $gadget){
				if($gadget->displayOn === "sideBar"){
					do{
						if($gadget->type === "search"){
							$this->getSearchGadget($gadget->displayOn);
						}else if($gadget->type === "labels"){
							$this->getLabelsGadget($gadget->displayOn);
						}else if ($gadget->type === "html"){
							$this->getHtmlGadget($gadget->displayOn);
						}else if ($gadget->type === "list"){
							$this->getListGadget($gadget->displayOn);
						}else if ($gadget->type === "profile"){
							$this->getAuthorGadget($gadget->displayOn);
						}else if ($gadget->type === "topPosts"){
							$this->getTopPostsGadget($gadget->displayOn);
						}

						$i++;
					}while ($gadget->position === $i);
				}
			}
		}

		public function getFooter(){
			$gadgets  = $this->getAllGadgets();
			$i = 1;

			foreach($gadgets as $gadget){
				if($gadget->displayOn === "footer"){
					do{
						if($gadget->type === "search"){
							echo '<div class="col-3">';
							$this->getSearchGadget($gadget->displayOn);
							echo '</div>';
						}else if($gadget->type === "labels"){
							echo '<div class="col-3">';
							$this->getLabelsGadget($gadget->displayOn);
							echo '</div>';
						}else if ($gadget->type === "html"){
							echo '<div class="col-3">';
							$this->getHtmlGadget($gadget->displayOn);
							echo '</div>';
						}else if ($gadget->type === "list"){
							echo '<div class="col-3">';
							$this->getListGadget($gadget->displayOn);
							echo '</div>';
						}else if ($gadget->type === "profile"){
							echo '<div class="col-3">';
							$this->getAuthorGadget($gadget->displayOn);
							echo '</div>';
						}else if ($gadget->type === "topPosts"){
							echo '<div class="col-3">';
							$this->getTopPostsGadget($gadget->displayOn);
							echo '</div>';
						}

						$i++;
					}while ($gadget->position === $i);
				}
			}
		}

		public function sideBarGadgets($blogID){
			$blog    = $this->user->get('blogs', ['blogID' => $blogID]);
			$gadgets = $this->getAllGadgets($blog->blogID);

			foreach ($gadgets as $gadget) {
				if($gadget->displayOn === 'sideBar'){
					$content = json_decode($gadget->content);
					echo '<div class="gadget" id="drag" draggable="true" data-id="'.$gadget->gadgetID.'" data-type='.$gadget->type.' data-area='.$gadget->displayOn.' data-pos="'.$gadget->position.'">
							<div class="gadget-body flex fl-row">
								<div class="gadget-left">
									<span>
										<i class="fas fa-ellipsis-v"></i>
									</span>
								</div>
								<div class="gadget-right flex fl-4 fl-c">
									<div>
										<span>'.$content->{'title'}.'</span>
									</div>
									<div>
										<span>'.$content->{'caption'}.'</span>
									</div>
								</div>
								<span>
									<a href="javascript:;" id="editGadget" data-blog='.$blog->blogID.' data-type='.$gadget->type.' data-area='.$gadget->displayOn.' data-pos="'.$gadget->position.'">Edit</a>
									<a href="javascript:;" id="deleteGadget" data-blog='.$blog->blogID.' data-type='.$gadget->type.' data-area='.$gadget->displayOn.' data-pos="'.$gadget->position.'">Delete</a>
				        	  	</span>
							</div>
						</div>
							';
				}
			}
		}


	}