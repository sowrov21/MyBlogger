var customBtn   = document.querySelector("#customEditBtn");
var customBox   = document.querySelector("#customBox");
var customBlock = document.querySelector("#customBlock");
var cSaveBtn    = document.querySelector("#customSaveBtn");
var cCancelBtn  = document.querySelector("#customCancelBtn");


customBtn.addEventListener("click", function(event){
	customBlock.style.display  = "block";

	cCancelBtn.addEventListener("click", function(event){
		customBlock.style.display = "none";
	});

	cSaveBtn.addEventListener("click", function(event){
		var textArea  = document.querySelector("#customInput");
		var blogID    = this.dataset.blog;
		var formData  = new FormData();
		formData.append("blogID", blogID);
		formData.append("error", textArea.value);

		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/setCustomError.php', true);
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
	});
})