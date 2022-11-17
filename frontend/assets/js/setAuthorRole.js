var authorBtn   = document.querySelectorAll("#authorMenu");

if(authorBtn){
	authorBtn.forEach(function(el){
		el.addEventListener("click", function(event){
			var role   = el;
			var menu   = this.nextElementSibling;
			var option = document.querySelectorAll(".option");
			menu.classList.toggle("display");
			var blogID   = this.dataset.blog;
			var authorID = this.dataset.author;

			if(option){
				option.forEach(function(el){
					el.addEventListener("click", function(event){
						if(confirm("Do you want to change permission for this user?")){
							var formData  = new FormData();
							var role = this.textContent;
			    			formData.append("blogID", blogID);
			    			formData.append("authorID", authorID);
			    			formData.append("role", role);

							var httpRequest = new XMLHttpRequest();

							if(httpRequest){
								httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/setAuthorRole.php', true);
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


			document.onclick = function(event){
				event.stopPropagation();
				if(event.target.id !== "authorMenu"){
					menu.classList.remove('display');
				}
			}
		});
	});
}