var postListBtn = document.querySelector("#postSaveBtn");

postSaveBtn.addEventListener("click", function(event){
	var blogID = this.dataset.blog;
	var postLimit = document.querySelector("#postInput");
	var regex   = /^\d+$/i;
	if(!regex.exec(postLimit.value)){
		alert("Please Enter A valid number");
		postLimit.value = '10';
		return false;
	}else{
		if(postLimit.value > 10 && postLimit.value < 100){
				var formData  = new FormData();
				var role = this.textContent;
				formData.append("blogID", blogID);
				formData.append("postLimit", postLimit.value);

				var httpRequest = new XMLHttpRequest();

				if(httpRequest){
					httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/updatePostLimit.php', true);
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
		}else{
			alert("Please Enter A valid number");
			postLimit.value = '10';
			return false;
		}
	}
});