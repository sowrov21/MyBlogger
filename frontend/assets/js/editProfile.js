var formBtn = document.querySelector("#saveProfileBtn");

formBtn.addEventListener("click", function(event){
	var email  = document.querySelector("#editEmail");
	var name   = document.querySelector("#editDisplayName");
	var file   = document.querySelector("#editProfile").files[0];

	if(email.value === ""){
		document.querySelector("#editEmailError").innerHTML = "Requried field must not be blank!";
	}

	if(name.value === ""){
		document.querySelector("#displayNameError").innerHTML = "Requried field must not be blank!";

	}

	if(name.value && email.value !== ""){
		var blogID    = this.dataset.blog;
		var formData  = new FormData();
		formData.append("blogID", blogID);
		formData.append("email", email.value);
		formData.append("name", name.value);
		formData.append("file", file);

		var httpRequest = new XMLHttpRequest();

		if(httpRequest){
			httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/editProfile.php', true);
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

document.querySelector('#editProfile').addEventListener("change", function(event){
		var regex = /(\.jpg|\.jpeg|\.png|\.zip)$/i;
		if(!regex.exec(this.value)){
			alert("Only '.jpeg','.jpg','.png', formats are allowed");
			this.value = '';
			return false;
		}else{
			if(this.files && this.files[0]){
				var reader  = new FileReader();
				reader.onload = function(event){
					document.querySelector("#editProfileImage").src = event.target.result;
				}
				reader.readAsDataURL(this.files[0]);
			}
		}
	});

var savePassBtn = document.querySelector("#savePassBtn");

savePassBtn.addEventListener("click", function(event){
	var currPass    = document.querySelector("#editCurPass").value;
	var newPass     = document.querySelector("#editNewPass").value;
	var newPassRe   = document.querySelector("#editNewPassAgain").value;

	if(currPass && newPass && newPassRe !== ""){
		if(newPass.length && newPassRe.length < 6){
			alert("Your password is too short");
		}else{
			if(newPass !== newPassRe){
				alert("Your new password does not match!");	
			}else{
				var blogID    = this.dataset.blog;
				var formData  = new FormData();
				formData.append("blogID", blogID);
				formData.append("currPass", currPass);
				formData.append("newPass", newPass);
				formData.append("newPassRe", newPassRe);

				var httpRequest = new XMLHttpRequest();

				if(httpRequest){
					httpRequest.open('POST', 'http://localhost/MyBlogger/backend/ajax/changePassword.php', true);
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
		}
	}else{
		alert("Enter your Password to update!");
	}
});