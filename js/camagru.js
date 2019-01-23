function PostForm(form_id, post_to, load_function) {
    var xhttp = new XMLHttpRequest();
    var formobj = document.getElementById(form_id);
    form_data = new FormData(formobj);
    xhttp.addEventListener("load", load_function);
    xhttp.addEventListener("error", function(event) {
        alert('Oops! Something went wrong.');
    });
    xhttp.open("POST", post_to);
    xhttp.send(form_data);
}

function PostPhoto(photo_data, overlay_arr){
    var xhttp = new XMLHttpRequest();

    var postObj = {
        action: "post_photo",
        photo_data: photo_data,
        overlay_arr: overlay_arr
    }
    xhttp.open("POST", "gallery_handler.php");
    xhttp.setRequestHeader("Content-type", "application/json");
    //console.log(postObj);
    
    xhttp.onreadystatechange = function(data) {
        if (this.readyState == 4 && this.status == 200) {
            //console.log("photo posted");
            //console.log(event.target.responseText);
            return ;
        } 
    };
    xhttp.send(JSON.stringify(postObj));
}

function PostSignupForm(form_id, post_to) {
    PostForm(form_id, post_to, function(event) {
        if (event.target.responseText == 1) {
            window.location.href = "http://localhost:8080/camagru/confirm_wait.php";
        } else {
            alert("error sending confirmation email");
        }
    });
}

function PostLoginForm(form_id, post_to) {
    PostForm(form_id, post_to,  function(event) {
        if (event.target.responseText == 1) {
            window.location.href = "http://localhost:8080/camagru/index.php";
        } else if (event.target.responseText == -1) {
            window.location.href = "http://localhost:8080/camagru/confirm_wait.php";
        } else {
            alert("incorrect login");
        }
    });
}

function PostForgotForm(form_id, post_to) {
    PostForm(form_id, post_to, function(event) {
        if (event.target.responseText == 1) {
            window.location.href = "http://localhost:8080/camagru/login.php";
            alert("Password Reset. Check Emails for new password");
        } else {
            alert("email doesn't exist");
        }

    });
}

function PostUpdateForm(form_id, post_to) {
    PostForm(form_id, post_to, function(event) {
        if (event.target.responseText == 1) {
            window.location.href = "http://localhost:8080/camagru/profile.php";
        } else {
            alert("update falied");
        }
    });
}