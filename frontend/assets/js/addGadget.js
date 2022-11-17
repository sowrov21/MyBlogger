var button = document.querySelectorAll("#addGadget");


button.forEach(function(el){
	el.addEventListener("click", function(event){
		event.preventDefault();
		var type   = this.dataset.type;
		var area   = this.dataset.area;
		var pos    = this.dataset.pos;
		var blogID = this.dataset.blog; 
	
		window.location.href= "http://localhost/MyBlogger/blogID/"+blogID+"/gadgets/add/"+type+"/"+area+"/"+pos;
	});
});

//topPosts Gadget
var topPostsBtn  = document.querySelector("#topPostsBtn");

if(topPostsBtn){
	topPostsBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var postLimit  = document.querySelector("#postLimit");
		var error      = document.querySelector("#error");

		if(title.value != "" && postLimit.value != ""){
			error.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			formData.append("postLimit", postLimit.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addTopPostsGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML ="Required field must not be blank";
		}
	});
}


//search gadget
var searchBtn  = document.querySelector("#searchSaveBtn");

if(searchBtn){
	searchBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var error      = document.querySelector("#error");

		if(title.value != ""){
			error.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addSearchGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML ="Required field must not be blank";
		}
	});
}

//html gadget
var htmlBtn  = document.querySelector("#htmlSaveBtn");

if(htmlBtn){
	htmlBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var html       = document.querySelector("#gadgetContent");
		var error      = document.querySelector("#error");
		var error2     = document.querySelector("#contentError");

		if(title.value != "" && html.value != ""){
			error.innerHTML = '';
			error2.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			formData.append("html", html.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addHtmlGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML  ="Required field must not be blank";
			error2.innerHTML ="Required field must not be blank";
		}
	});
}


//html gadget
var profileBtn  = document.querySelector("#profileBtn");

if(profileBtn){
	profileBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var desc       = document.querySelector("#gadgetContent");
		var fbUrl      = document.querySelector("#fbUrl");
		var twUrl      = document.querySelector("#twitterUrl");
		var igUrl      = document.querySelector("#igUrl");
		var ytUrl      = document.querySelector("#ytUrl");
		var error      = document.querySelector("#error");
		var error2     = document.querySelector("#contentError");

		if(title.value != "" && desc.value != ""){
			error.innerHTML = '';
			error2.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			formData.append("desc", desc.value);
			formData.append("fbUrl", fbUrl.value);
			formData.append("twUrl", twUrl.value);
			formData.append("igUrl", igUrl.value);
			formData.append("ytUrl", ytUrl.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addProfileGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML  ="Required field must not be blank";
			error2.innerHTML ="Required field must not be blank";
		}
	});
}

//Labels gadget
var labelBtn  = document.querySelector("#labelBtn");

if(labelBtn){
	labelBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var error      = document.querySelector("#error");

		if(title.value != ""){
			error.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addLabelsGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML ="Required field must not be blank";
		}
	});
}


//List gadget
var listBtn      = document.querySelector("#listSaveBtn");
var addLink      = document.querySelector("#addLink");
var title        = document.querySelector("#gadgetTitle");
var siteUrl      = document.querySelector("#siteUrl");
var siteName     = document.querySelector("#siteName");
var titleEr      = document.querySelector("#titleError");
var urlEr        = document.querySelector("#urlError");
var nameEr       = document.querySelector("#nameError");
var deleteLink = document.querySelectorAll("#deleteLink");
var links      = document.querySelectorAll("#link");

var urlArr       = [];
var nameArr       = [];

if(listBtn){
	listBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var error      = document.querySelector("#error");

		if(title.value != "" && links != null){
			titleEr.innerHTML = "";
			nameEr.innerHTML  = "";
			urlEr.innerHTML   = "";

			links.forEach(function(el){
				urlArr.push(el.href);
				nameArr.push(el.innerHTML);
			});

			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			formData.append("urlArr", JSON.stringify(urlArr));
			formData.append("nameArr", JSON.stringify(nameArr));
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addListGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			titleEr.innerHTML = "Required field must not be blank";
			nameEr.innerHTML  = "Required field must not be blank";
			urlEr.innerHTML   = "Required field must not be blank";
		}
	});
}

if(addLink){
addLink.addEventListener("click", function(event){
	event.preventDefault();
	if(title.value !== '' && siteUrl.value !== '' && siteName.value !== ''){
		var pattern = /^(http|https):\/\//;

		if(!pattern.test(siteUrl.value)){
			url  = "http://" + siteUrl.value;
		}else{
			url  =  siteUrl.value;
		}

		var link = document.createElement('li');
		link.innerHTML = "<span><a href='javascript:;' id='deleteLink'>Delete</a></span><span><a href='"+url+"' id='link' target='_blank'>"+siteName.value+"</a></span>";
		siteUrl.value = '';
		siteName.value = '';
		linkArea.appendChild(link);
		link.children[0].children[0].addEventListener("click", remove, false);
		links  = document.querySelectorAll("#link")
	}else{
		titleEr.innerHTML = "Required field must not be blank";
		nameEr.innerHTML  = "Required field must not be blank";
		urlEr.innerHTML   = "Required field must not be blank";
	}
});
}

if(deleteLink){
	deleteLink.forEach(function(el){
		el.addEventListener("click", remove, false);
	});
}

function remove(){
	if(this.parentElement.nextElementSibling){
		this.parentElement.nextElementSibling.remove();
		this.parentElement.remove();
	}

	deleteLink = document.querySelectorAll("#deleteLink");
	links      = document.querySelectorAll("#link");
}

//Header gadget
var headerBtn  = document.querySelector("#headerSaveBtn");

if(headerBtn){
	headerBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var title      = document.querySelector("#gadgetTitle");
		var desc       = document.querySelector("#gadgetContent");
		var error      = document.querySelector("#error");

		if(title.value != "" && desc.value != ""){
			error.innerHTML = '';
			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", title.value);
			formData.append("desc", desc.value);
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addHeaderGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			error.innerHTML  ="Required field must not be blank";
		}
	});
}

//Nav gadget
var navBtn      = document.querySelector("#navSaveBtn");
var paddLink      = document.querySelector("#addLink");
var ptitle        = document.querySelector("#gadgetTitle");
var psiteUrl      = document.querySelector("#pageUrl");
var psiteName     = document.querySelector("#pageName");
var ptitleEr      = document.querySelector("#titleError");
var purlEr        = document.querySelector("#urlError");
var pnameEr       = document.querySelector("#nameError");
var pdeleteLink = document.querySelectorAll("#deleteLink");
var plinks      = document.querySelectorAll("#link");

var purlArr       = [];
var pnameArr       = [];

if(navBtn){
	navBtn.addEventListener("click", function(event){
		var blogID     = this.dataset.blog;
		var area       = this.dataset.area;
		var pos        = this.dataset.pos;
		var ptitle      = document.querySelector("#gadgetTitle");
		var perror      = document.querySelector("#error");

		if(ptitle.value != "" && plinks != null){
			ptitleEr.innerHTML = "";
			pnameEr.innerHTML  = "";
			purlEr.innerHTML   = "";

			plinks.forEach(function(el){
				purlArr.push(el.href);
				pnameArr.push(el.innerHTML);
			});

			var formData  = new FormData();

			formData.append("blogID", blogID);
			formData.append("area", area);
			formData.append("pos", pos);
			formData.append("title", ptitle.value);
			formData.append("urlArr", JSON.stringify(purlArr));
			formData.append("nameArr", JSON.stringify(pnameArr));
			
			var httpRequest = new XMLHttpRequest();

			if(httpRequest){
				httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/addNavGadget.php', true);
				httpRequest.onreadystatechange = function(){
					if(this.readyState === 4 && this.status === 200){
						window.close();
						window.opener.location.reload(true);
					}
				}

				httpRequest.send(formData);
			}	
		}else{
			ptitleEr.innerHTML = "Required field must not be blank";
			pnameEr.innerHTML  = "Required field must not be blank";
			purlEr.innerHTML   = "Required field must not be blank";
		}
	});
}

if(paddLink){
paddLink.addEventListener("click", function(event){
	event.preventDefault();
	if(ptitle.value !== '' && psiteUrl.value !== '' && psiteName.value !== ''){
		var pattern = /^(http|https):\/\//;

		if(!pattern.test(psiteUrl.value)){
			url  = "http://" + psiteUrl.value;
		}else{
			url  =  psiteUrl.value;
		}

		var link = document.createElement('li');
		link.innerHTML = "<span><a href='javascript:;' id='deleteLink'>Delete</a></span><span><a href='"+url+"' id='link' target='_blank'>"+psiteName.value+"</a></span>";
		psiteUrl.value = '';
		psiteName.value = '';
		linkArea.appendChild(link);
		link.children[0].children[0].addEventListener("click", premove, false);
		plinks  = document.querySelectorAll("#link")
	}else{
		ptitleEr.innerHTML = "Required field must not be blank";
		pnameEr.innerHTML  = "Required field must not be blank";
		purlEr.innerHTML   = "Required field must not be blank";
	}
});
}

if(pdeleteLink){
	pdeleteLink.forEach(function(el){
		el.addEventListener("click", premove, false);
	});
}

function premove(){
	if(this.parentElement.nextElementSibling){
		this.parentElement.nextElementSibling.remove();
		this.parentElement.remove();
	}

	pdeleteLink = document.querySelectorAll("#deleteLink");
	plinks      = document.querySelectorAll("#link");
}


