var button = document.querySelectorAll("#newGadget");
var blogID = document.querySelector("#saveLayoutBtn").dataset.blog;


button.forEach(function(el){
	el.addEventListener("click", function(event){
		event.preventDefault();
		var data = this.parentElement.parentElement; 
		var area = data.dataset.area;
		var pos  = data.dataset.pos;
	
		if(pos === '0' && area === 'sideBar'){
			pos  = document.querySelectorAll('#drag').length+1;
		}

		window.open('http://localhost/MyBlogger/blogID/'+blogID+'/gadgets/'+area+'/'+pos, 'about:blank', 'width=780,height=800');
	});
});

//edit gadget
var editBtn = document.querySelectorAll("#editGadget");

editBtn.forEach(function(el){
	el.addEventListener("click", function(event){
		event.preventDefault();
		
		var area  = this.dataset.area;
		var pos   = this.dataset.pos;
		var type  = this.dataset.type;


		window.open('http://localhost/MyBlogger/blogID/'+blogID+'/gadgets/edit/'+type+'/'+area+'/'+pos, 'about:blank', 'width=780,height=800');
	});
});

//delete gadget
var deletebtn = document.querySelectorAll("#deleteGadget");

deletebtn.forEach(function(el){
	el.addEventListener("click", function(event){
		event.preventDefault();
		var blogID = this.dataset.blog;
		var area   = this.dataset.area;
		var pos    = this.dataset.pos;
		var type   = this.dataset.type;
	
	
		if(confirm("Are you sure, you want to delete this gadget?")){
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("type", type);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/removeGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						if(this.responseText.length > 0){
							alert(this.responseText);
						}
						location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			location.reload(true);
		}
	});
});