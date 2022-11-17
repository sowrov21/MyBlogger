var drag       = document.querySelectorAll("#drag");
var saveBtn    = document.querySelector("#saveLayoutBtn");
var dragFrom   = new Array;
var dropTo     = new Array;

drag.forEach(function(el){
	el.addEventListener("dragstart", function(event){
		dragEl = this;
		event.dataTransfer.effectAllowed = 'move';
		event.dataTransfer.setData('text/html', this.innerHTML);
	});

	el.addEventListener("dragover", function(event){
		event.preventDefault();
		event.dataTransfer.dropEffect = 'move';
		return false;
	});

	el.addEventListener("drop", function(event){
		if(dragEl != this.innerHTML){
			saveBtn.classList.remove('disabled');
			saveBtn.disabled = false;
			dragFrom.push(dragEl.dataset.id);
			dropTo.push(this.dataset.id);

			dragEl.innerHTML  =  this.innerHTML;
			this.innerHTML = event.dataTransfer.getData('text/html');
		}
		return false;
	});
});

saveBtn.addEventListener("click", function(event){
    if(dragFrom.length && dropTo.length > 0){
    	this.disabled = true;
    	var formData  = new FormData();

		formData.append("blogID", this.dataset.blog);
		formData.append("dragFrom", JSON.stringify(dragFrom));
		formData.append("dropTo", JSON.stringify(dropTo));
		
		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/saveLayout.php', true);
			httpRequest.onreadystatechange = function(){
				if(this.readyState === 4 && this.status === 200){
					if(this.responseText.length > 0){
						alert(this.responseText);
					}else{
						alert('Layout saved');
					}
					location.reload(true);
				}
			}

			httpRequest.send(formData);
		}	
    }
});

