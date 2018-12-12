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