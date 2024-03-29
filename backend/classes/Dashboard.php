<?php 

	class Dashboard{
		protected $db;
		protected $user;

		public function __construct(){
			$this->db = Database::instance();
			$this->user = new Users;
		}

		public function blogAuth($blogID){
			$user_id = $this->user->ID();
			$stmt = $this->db->prepare("SELECT * FROM `blogs` `B`, `blogsAuth` `A` 
												 LEFT JOIN `users` `U` ON `A`.`userID` = `U`.`userID`
												 WHERE `B`.`blogID` = `A`.`blogID` AND `B`.`blogID` = :blogID
												 AND `U`.`userID` = :userID");
			
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->bindParam(":userID", $user_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function getBlogList($blogID){
			$blog = $this->blogAuth($blogID);
			$blogID = $blog->blogID;
			if($blog){
				$stmt = $this->db->prepare("SELECT * FROM `blogs` `B`, `blogsAuth` `A` LEFT JOIN `users` `U` ON `A`.`userID` = `U`.`userID` WHERE `B`.`blogID` = `A`.`blogID` AND `U`.`userID` = :userID");
			
	 			$stmt->bindParam(":userID", $blog->userID, PDO::PARAM_INT);
				$stmt->execute();
				$data =  $stmt->fetchAll(PDO::FETCH_OBJ);

				foreach ($data as $blog) {
					if($blogID === $blog->blogID){
						echo '<div class="bhm-bl bhm-bl-active"><a href="'.BASE_URL.'admin/blogID/'.$blog->blogID.'/dashboard/">'.$blog->Title.'</a></div>';
					}else{
						echo '<div class="bhm-bl"><a href="'.BASE_URL.'admin/blogID/'.$blog->blogID.'/dashboard/">'.$blog->Title.'</a></div>';
					}
				}
			}
		}

		public function searchPosts($search, $blogID){
			$stmt = $this->db->prepare("SELECT * FROM `posts`,`users` WHERE `authorID` = `userID` AND `title` LIKE ? AND `blogID` = ?");
			$stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR); 
			$stmt->bindValue(2, $blogID, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getAllPosts($offset, $limit, $type, $status, $blogID){
			if($status === ''){
			$sql = "SELECT * FROM `posts` 
							     LEFT JOIN `users` ON `userID` = `authorID`
							     WHERE `postType` = :type AND 
							     	   `blogID`   = :blogID ORDER BY `postID` 
							     DESC LIMIT :offset, :postLimit";
			}else{
				$sql = "SELECT * FROM `posts` 
							     LEFT JOIN `users` ON `userID` = `authorID`
							     WHERE `postType` = :type AND `postStatus` = :status AND
							     	   `blogID`   = :blogID ORDER BY `postID` 
							     DESC LIMIT :offset, :postLimit";
			}

			if(!empty($offset)){
				$offset = ($offset-1)*$limit;
			}

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
			$stmt->bindParam(":postLimit", $limit, PDO::PARAM_INT);
 			$stmt->execute();
			$posts = $stmt->fetchAll(PDO::FETCH_OBJ);

			if($posts){
				foreach($posts as $post){
					$date = new DateTime($post->createdDate);
					echo '<div class="m-r-c-inner">
							<div class="posts-wrap">
							<div class="posts-wrap-inner">
							<div class="post-link flex fl-row">
								<div class="post-in-left fl-1 fl-row flex">
									<div class="p-in-check">
										<input type="checkbox" class="postCheckBox" value="'.$post->postID.'" data-blog="'.$post->blogID.'"/>
									</div>
									<div class="fl-1">
										<div class="p-l-head flex fl-row">
											<div class="pl-head-left fl-1">
												<div class="pl-h-lr-link">
													<a href="'.BASE_URL.'admin/blogID/'.$post->blogID.'/'.strtolower($type).'/'.$post->postID.'/edit">'.$post->title.'</a>
												</div>
												<div class="pl-h-lf-link">
													<ul>
														'.$this->getPostLabels($post->postID, $post->blogID).'
													</ul>
												</div>
											</div>
											<div class="pl-head-right">
												<span>'.(($post->postStatus === 'draft') ? 'Draft' : '').'</span>
											</div>
										</div>
										<div class="p-l-footer">
											<ul>
												<li><a href="'.BASE_URL.'admin/blogID/'.$post->blogID.'/'.strtolower($type).'/'.$post->postID.'/edit">Edit</a></li>|		
												<li><a href="javascript:;" id="deletePost" data-post="'.$post->postID.'" data-blog="'.$post->blogID.'">Delete</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="post-in-right">
								<div class="p-in-right flex fl-1">
									<div class="pl-auth-name"><span>
										<a href="javascript:;">'.$post->fullName.'</a></span>
									</div>
									<div class="pl-cm-count">
										<span>'.$this->getCommentCount($post->postID, $post->blogID).'</span>
										<span><i class="fas fa-comment"></i></span>
									</div>
									<div class="pl-views-count">
										<span>'.$this->getPostViews($post->postID, $post->blogID).'</span>
										<span><i class="fas fa-eye"></i></span>
									</div>
									<div class="pl-post-date">
										<span>'.$date->format('d/m/y').'</span>
									</div> 
								</div>
								</div>
							</div>
							</div>
							</div>
							</div>';
				}
			}else{
				echo '<div class="posts-wrap">
						<div class="posts-wrap-inner">
							<div class="nopost flex">
								<div>
									<p>There are no '.$type.'s. </p><a href="'.BASE_URL.'admin/blogID/'.$blogID.'/'.strtolower($type).'/new/">Create a new '.$type.'</a>
								</div>
							</div>
						</div>
						</div>';
			}
		}

		public function getPostViews($postID, $blogID){
			$stmt = $this->db->prepare("SELECT count(`statsID`) AS `views` FROM `stats` WHERE `postID` = :postID AND `blogID` = :blogID");
			$stmt->bindParam(":postID", $postID, PDO::PARAM_INT);
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_OBJ);
			return $data->views;
		}

		public function getCommentCount($postID, $blogID){
			$stmt = $this->db->prepare("SELECT count(`commentID`) AS `views` FROM `comments` WHERE `postID` = :postID AND `blogID` = :blogID");
			$stmt->bindParam(":postID", $postID, PDO::PARAM_INT);
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_OBJ);
			return $data->views;
		}

		public function getPostLabels($postID, $blogID){
			$stmt = $this->db->prepare("SELECT * FROM `labels` WHERE `postID` = :postID AND `blogID` = :blogID");
			$stmt->bindParam(":postID", $postID, PDO::PARAM_INT);
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$labels = $stmt->fetchAll(PDO::FETCH_OBJ);
			$i = 1;
			$return = '';
			foreach($labels as $label){
				$return .= '<li><a href="#">'.$label->labelName.'</a></li>'.(($i < count($labels)) ? ',' : '');
				$i++;
			}
			return $return;
		}

		public function getLabelsMenu($blogID){
			$stmt = $this->db->prepare("SELECT * FROM `labels` WHERE `blogID` = :blogID GROUP BY `labelName`");
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$labels = $stmt->fetchAll(PDO::FETCH_OBJ);

			foreach($labels as $label){
				echo '<li class="label" data-id="'.$label->ID.'"><a href="javascript:;">'.$label->labelName.'</a></li>';
			}
		}

		public function getPostsCount($type, $status, $blogID){
			if($status === ''){
				$sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `blogID` = :blogID";
			}else{
				$sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `postStatus` = :status AND `blogID` = :blogID";
			}

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

			if($data){
				echo "({$stmt->rowCount()})";
			}
		}

		public function getPaginationPages($postLimit, $type, $status, $blogID){
			if($status === ''){
				$sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `blogID` = :blogID";
			}else{
				$sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `postStatus` = :status AND `blogID` = :blogID";
			}

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->fetchAll(PDO::FETCH_OBJ);
			$total = $stmt->rowCount();

			$pages = ceil($total/$postLimit);
			
			for($i=1; $i < $pages+1; $i++){
				echo '<li class="pageNum">'.$i.'</li>';
			}
		}

		public function getAllComments($offset, $limit, $type,$blogID){
			
			$sql = "SELECT * FROM `users` `U`,`comments` `C`
						     LEFT JOIN `posts` `P` ON `P`.`postID` = `C`.`postID`
							     WHERE `U`.`userID` = `P`.`authorID` AND 
							     		`C`.`blogID` = :blogID AND `C`.`status` = :type
							     		ORDER BY `commentID` DESC LIMIT :offset, :postLimit";

			if(!empty($offset)){
				$offset = ($offset-1)*$limit;
			}

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
			$stmt->bindParam(":postLimit", $limit, PDO::PARAM_INT);
 			$stmt->execute();
			$comments = $stmt->fetchAll(PDO::FETCH_OBJ);

			if($comments){
				foreach($comments as $comment){
					$date = new DateTime($comment->date);
					//comments
					echo '<div class="m-r-c-inner">
							<div class="posts-wrap">
							<div class="posts-wrap-inner">
								<div class="post-link flex fl-row">
									<div class="post-in-left fl-1 fl-row flex">
										<div class="p-in-check">
											<input type="checkbox" class="commentCheckBox" data-post="'.$comment->postID.'" data-comment="'.$comment->commentID.'"/>
										</div>
										<div class="fl-1">
											<div class="p-l-head flex fl-row">
												<div class="pl-head-left fl-1">
													<div class="pl-h-lr-link">
														<span>	
															'.$comment->comment.'
														</span>
														<a href="'.BASE_URL.$comment->title.'">'.$comment->title.'</a>
												</div>
												</div>
											</div>
											<div class="p-l-footer">
											  <ul>'.(($comment->status === "Pending") ? 
											  	'<li>
													<a href="javascript:;" id="publishComment" data-post="'.$comment->postID.'" data-comment="'.$comment->commentID.'">Publish</a>
												</li>' : 
												
												'<li>
													<a href="javascript:;"id="deleteComment" data-post="'.$comment->postID.'" data-comment="'.$comment->commentID.'">Delete</a>
												</li> ').'
												
											   </ul>
											</div>
										</div>
									</div>
									<div class="post-in-right">
									<div class="p-in-right flex fl-1">
										<div class="pl-auth-name">
											<span>
												<a href="#">'.$comment->name.'</a>
											</span>
										</div>
										<div class="pl-post-date">
											<span>'.$date->format('d/m/y').'</span>
										</div> 
									</div>
									</div>
								</div>
							</div>
							</div>
							</div>';
				}
			}else{
				echo '<div class="posts-wrap">
						<div class="posts-wrap-inner">
							<div class="nopost flex">
								<div>
									<p>There are no comments. </p>
								</div>
							</div>
						</div>
					</div>';
			}
		}

		public function getCommentPages($postLimit, $type, $blogID){
			$sql ="SELECT * FROM `users` `U`, `comments` `C` 
							 LEFT JOIN `posts` `P` ON `P`.`postID` = `C`.`postID`
							 WHERE `U`.`userID` = `P`.`authorID` 
							 AND `C`.`status` = :type 
							 AND `C`.`blogID` = :blogID 
							 ORDER BY `C`.`commentID` DESC";

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->fetchAll(PDO::FETCH_OBJ);
			$total = $stmt->rowCount();

			$pages = ceil($total/$postLimit);
			
			for($i=1; $i < $pages+1; $i++){
				echo '<li class="pageNum">'.$i.'</li>';
			}
		}

		public function getAuthorList($blogID){
			$stmt = $this->db->prepare("SELECT * FROM `blogsAuth` `B` 
												 LEFT JOIN `users` `U` ON `U`.`userID` = `B`.`userID` 
												 WHERE `B`.`blogID` = :blogID");
			$stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
			$stmt->execute();
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			if($users){
				foreach($users as $user){
					echo '<div class="ba-box">
							<span class="ba-name">
								<span><i class="fas fa-user-tie"></i></span>
								<span>'.$user->fullName.'</span>
							</span>
							<span class="ba-email">
								<a href="javascript:;">'.$user->email.'</a>
							</span>
							<span class="ba-stats">
								<div class="authorBtn" id="authorMenu" data-blog="'.$user->blogID.'" data-author="'.$user->userID.'">
									'.$user->role.'
								</div>
								<ul class="authorOption">
									<li class="option" role="option" value="Admin">Admin</li>
									<li class="option" role="option" value="Author">Author</li>
								</ul> 
							</span>
							<span class="ba-delete" >
								<a href="javascript:;" class="deleteAuthor" data-blog="'.$user->blogID.'" data-author="'.$user->userID.'"><i class="fas fa-times"></i></a>
							</span>
						</div>
						';
			    }
			}
		}
	}