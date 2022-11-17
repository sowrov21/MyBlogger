var metaBtn         = document.querySelector("#metaDescBtn");
var metaBlock       = document.querySelector("#metaDescBlock");
var metaCancelBtn   = document.querySelector("#metaCancelBtn");
var metaSaveBtn     = document.querySelector("#metaSaveBtn");
var metaBox         = document.querySelector("#metaDescBox");

metaBtn.addEventListener("click", function(event){
	metaBlock.style.display = "block";

	metaCancelBtn.addEventListener("click", function(event){
		metaBlock.style.display = "none";
	});

	metaSaveBtn.addEventListener("click", function(event){
		metaText  = document.querySelector("#metaDescInput");
 		if(metaText.value.trim().length < '150'){
			var formData  = new FormData();

			formData.append("metaription", metaText.value.trim());
			formData.append("blogID", blogID);

			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/updateMeta.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						if(/OwnnerError$/i.exec(this.responseText)){
							alert("You cannot preform this action!");
							location.reload(true);
						}else{
							this.value = this.responseText;
						}

						metaBlock.style.display = "none";
						metaBox.innerHTML  = metaText.value;
						
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			document.querySelector("#metaDescError").innerHTML = "Must be at most 500 characters!";
		}
	});

});
