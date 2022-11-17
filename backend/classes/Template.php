<?php 

	class Template{
		protected $pdo;
		protected $user;
		protected $blog;
		protected $layout;
 
		public function __construct(){
			$this->pdo    = Database::instance();
			$this->user   = new Users;
			$this->blog   = new Blog;
			$this->layout = new Layout;
		}

		public function title(){
			ob_start();
			$this->blog->getTitle();
			return ob_get_clean();
		}

		public function styles(){
			ob_start();
			$this->blog->getStyles();
			return ob_get_clean();
		}

		public function meta(){
			ob_start();
			$this->blog->getMeta();
			return ob_get_clean();
		}

		public function header(){
			ob_start();
			$this->blog->getHeader();
			return ob_get_clean();
		}

		public function nav(){
			ob_start();
			$this->blog->getNav();
			return ob_get_clean();
		}

		public function blogPosts(){
			ob_start();
			$this->blog->getBlogPosts();
			return ob_get_clean();
		}

		public function postPage(){
			ob_start();
			$this->blog->getPostPage();
			return ob_get_clean();
		}

		public function sideBar(){
			ob_start();
			$this->blog->getSideBar();
			return ob_get_clean();
		}

		public function footer(){
			ob_start();
			$this->blog->getFooter();
			return ob_get_clean();
		}


		public function addTemplateTags($html){
			$html = str_replace('<?php $blogObj->getTitle();?>',     '{{TITLE}}', $html);
			$html = str_replace('<?php $blogObj->getStyles();?>',    '{{STYLES}}', $html);
			$html = str_replace('<?php $blogObj->getMeta();?>',      '{{META}}', $html);
			$html = str_replace('<?php $blogObj->getHeader();?>',    '{{HEADER}}', $html);
			$html = str_replace('<?php $blogObj->getNav();?>',       '{{NAV}}', $html);
			$html = str_replace('<?php $blogObj->getBlogPosts();?>', '{{POSTS}}', $html);
			$html = str_replace('<?php $blogObj->getSideBar();?>',   '{{SIDEBAR}}', $html);
			$html = str_replace('<?php $blogObj->getFooter();?>',    '{{FOOTER}}', $html);
			return $html;
		}

		public function renderTemplate($html, $page = 'POST'){
 			$type = ($page === "PAGE") ? $this->postPage() : $this->blogPosts();
			$html = str_replace('{{TITLE}}', $this->title(), $html);
			$html = str_replace('{{STYLES}}', $this->styles(), $html);
			$html = str_replace('{{META}}', $this->meta(), $html);
			$html = str_replace('{{HEADER}}', $this->header(), $html);
			$html = str_replace('{{NAV}}', $this->nav(), $html);
			$html = str_replace('{{POSTS}}', $type, $html);
			$html = str_replace('{{SIDEBAR}}', $this->sideBar(), $html);
			$html = str_replace('{{FOOTER}}', $this->footer(), $html);
			echo html_entity_decode($html);
		}
	}