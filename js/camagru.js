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

window.addEventListener("DOMContentLoaded",function() {

    var video = document.getElementById("video"),
       canvas = document.getElementById("canvas"),
       context = canvas.getContext("2d"),

       vendorUrl = window.URL || window.webkitURL;

   navigator.getMedia =    navigator.getUserMedia ||
                           navigator.webkitGetUserMedia ||
                           navigator.mozGetusermedia ||
                           navigator.msGetUserMedia;

   navigator.getMedia({
       video: true,
       audio: false
   }, function(stream) {
       video.srcObject = stream;
       video.play();
   }, function(error) {
       has_webcam = false;
      // cap_btn.hidden = true;
   });
    document.getElementById("capture-but").addEventListener('click', function(){
        context.drawImage(video, 0, 0, 400, 300);
        currentpic = canvas.toDataURL();
        photo = document.createElement('img');
        photo.setAttribute("src", currentpic);
        camera_roll = document.getElementById("photo-reel");
        camera_roll.insertBefore(photo, camera_roll.firstElementChild);
        photo.setAttribute("style", "transform: rotateY(180deg);-webkit-transform:rotateY(180deg); -moz-transform:rotateY(180deg); ");
    });
});