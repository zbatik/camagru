function PostSignupForm(form_id, post_to) {
    var xhttp = new XMLHttpRequest();

    // Bind the FormData object and the form element
    var formobj = document.getElementById(form_id);
    form_data = new FormData(formobj);
    
    // Define what happens on successful data submission
    xhttp.addEventListener("load", function(event) {
        window.location.href = "http://localhost:8080/camagru/confirm.php"
    });

    // Define what happens in case of error
    xhttp.addEventListener("error", function(event) {
        alert('Oops! Something went wrong.');
    });

    // Set up our request
    xhttp.open("POST", post_to);

    // The data sent is what the user provided in the form
    xhttp.send(form_data);
}

function PostLoginForm(form_id, post_to) {
    var xhttp = new XMLHttpRequest();

    // Bind the FormData object and the form element
    var formobj = document.getElementById(form_id);
    form_data = new FormData(formobj);
    
    // Define what happens on successful data submission
    xhttp.addEventListener("load", function(event) {
        if (event.target.responseText == 1) {
            window.location.href = "http://localhost:8080/camagru/index.php"
        } else {
            alert("incorrect login");
        }
    });

    // Define what happens in case of error
    xhttp.addEventListener("error", function(event) {
        alert('Oops! Something went wrong.');
    });

    // Set up our request
    xhttp.open("POST", post_to);

    // The data sent is what the user provided in the form
    xhttp.send(form_data);
}

function PostForgotForm(form_id, post_to) {
    var xhttp = new XMLHttpRequest();

    // Bind the FormData object and the form element
    var formobj = document.getElementById(form_id);
    form_data = new FormData(formobj);
    
    // Define what happens on successful data submission
    xhttp.addEventListener("load", function(event) {
        //window.location.href = "http://localhost:8080/camagru/index.php"
        alert(event.target.responseText);
    });

    // Define what happens in case of error
    xhttp.addEventListener("error", function(event) {
        alert('Oops! Something went wrong.');
    });

    // Set up our request
    xhttp.open("POST", post_to);

    // The data sent is what the user provided in the form
    xhttp.send(form_data);
}