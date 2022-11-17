var deleteBtn  = document.querySelectorAll('.deleteAuthor');

if(deleteBtn){
	deleteBtn.forEach(function(el){
		el.addEventListener("click", function(event){
			event.preventDefault();
			var authorID   = this.dataset.author;
			var blogID     = this.dataset.blog;

			if(confirm("Are you sure? You want to delete this user?")){
				var formData  = new FormData();
    			formData.append("blogID", blogID);
    			formData.append("authorID", authorID);

				var httpRequest = new XMLHttpRequest();

				if(httpRequest){
					httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/removeAuthor.php', true);
					httpRequest.onreadystatechange = function(){
						if(this.readyState === 4 && this.status === 200){
							if(this.responseText.length != 0){
								alert(this.responseText);
							}
							location.reload(true);
						}
					}

					httpRequest.send(formData);
				}	
			}
		});
	});
}