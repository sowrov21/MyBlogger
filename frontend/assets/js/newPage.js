var publish     = document.querySelector("#publish");
var saveBtn     = document.querySelector("#saveBtn");
var title       = document.querySelector("#title");
var slug        = document.querySelector('#slugDiv');
var linkOp      = document.querySelectorAll('.postLinkOp');
var urlDiv      = document.querySelector('#custom-url-area');
var customUrl   = document.querySelector('#customSlug');
var customUrlEr = document.querySelector('#urlError');
urlDiv.style.display = "none";


title.addEventListener("keydown", function(event){
	if(document.querySelectorAll('.postLinkOp').value != ''){
		if(linkOp[0].value === "automatic"){
			checkTyping();
		}
	}
});

customUrl.addEventListener("keyup", function(even){
	regex = /^([a-zA-Z0-9-]+)$/gm;
	if(this.value != ''){
		if(this.value.match(regex)){
			customUrlEr.innerHTML = "";
			slug.innerHTML = this.value+".html";
		}else{
			slug.innerHTML = "";
			customUrlEr.innerHTML = "Invaild characters!";
		}
	}else{
		slug.innerHTML = "";
	}
});

linkOp.forEach(function(el){
	el.addEventListener("change", function(event){
		if(el.value === "custom"){
			slug.innerHTML = '';
			urlDiv.style.display = "block";
			customUrl.value = '';
		}else{
			slug.innerHTML = '';
			urlDiv.style.display = "none";
			if(title.value != ''){
				displaySlug();
			}
		}
	});
});

var typingTimer    = null;
var typingInterval = 5000;

function checkTyping(){
	clearTimeout(typingTimer);
	typingTimer = setTimeout(displaySlug, 1000);
}

function displaySlug(){
	var formData  = new FormData();

	formData.append("blogID", publish.dataset.blog);
	formData.append("title",  title.value);

	var httpRequest = new XMLHttpRequest();

	if(httpRequest){
		httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/getSlug.php', true);
		httpRequest.onreadystatechange = function(){
			if(this.readyState === 4 && this.status === 200){
				if(this.responseText.length != 0){
					slug.innerHTML = this.responseText;
				}
			}
		}

		httpRequest.send(formData);
	}	
}


publish.addEventListener("click", function(event){
	var blogID        = this.dataset.blog;
	var title         = document.querySelector('#title').value.trim();
	var description   = document.querySelector('#description').value.trim();
	var slug          = document.querySelector('#customSlug').value.trim();
	var content       = document.querySelector('#editor').firstChild.innerHTML;

	if(title != ''){
		if(slug === ''){
			slug = title;
		}

		var formData  = new FormData();

		formData.append("blogID", blogID);
		formData.append("title",  title);
		formData.append("description",  description);
		formData.append("content",  content);
		formData.append("slug",  slug);

		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addPage.php', true);
			httpRequest.onreadystatechange = function(){
				if(this.readyState === 4 && this.status === 200){
					window.location.href = "http://localhost/MyBlogger/admin/blogID/"+blogID+"/dashboard/pages";
				}
			}

			httpRequest.send(formData);
		}	
	}else{
		alert('Please add page title!');
	}
});

if(saveBtn != null){
saveBtn.addEventListener("click", function(event){
	var blogID        = publish.dataset.blog;
	var title         = document.querySelector('#title').value.trim();
	var description   = document.querySelector('#description').value.trim();
	var slug          = document.querySelector('#customSlug').value.trim();
	var content       = document.querySelector('#editor').firstChild.innerHTML;

	if(title != ''){
		if(slug === ''){
			slug = title;
		}

		var formData  = new FormData();

		formData.append("blogID", blogID);
		formData.append("title",  title);
		formData.append("description",  description);
		formData.append("content",  content);
		formData.append("slug",  slug);

		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/saveNewPage.php', true);
			httpRequest.onreadystatechange = function(){
				if(this.readyState === 4 && this.status === 200){
					window.location.href = "http://localhost/MyBlogger/admin/blogID/"+blogID+"/page/"+this.responseText+"/edit/";
				}
			}

			httpRequest.send(formData);
		}	
	}else{
		alert('Please add page title!');
	}
});
}