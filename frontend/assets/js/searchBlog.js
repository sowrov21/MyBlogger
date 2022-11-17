var searchBtn  = document.querySelector("#searchBtn");

searchBtn.addEventListener("click", function(event){
	var search = document.querySelector("#search");

	if(search.value != ''){
		window.location = "http://"+ window.location.host.split('.')[0] + ".localhost/MyBlogger/search/" + search.value;
	}
});