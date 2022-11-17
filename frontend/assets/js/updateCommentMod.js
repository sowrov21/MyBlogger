var commentBtn    = document.querySelector("#commentBtn");
var commentInput  = document.getElementsByName('commentMod');

commentBtn.addEventListener("click", function(event){
	if(!(commentInput[0].checked || commentInput[1].checked)){
		alert("Please Select to Allow Comments Moderation");
		return false;
	}else{
		for(i = 0; i < commentInput.length; i++ ){
			comment = commentInput[i].value;
		}

		var blogID    = this.dataset.blog;
		var formData  = new FormData();
		formData.append("blogID", blogID);
		formData.append("comment", comment);

		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/updateCommentMod.php', true);
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