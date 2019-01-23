<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>
<script>

function passwordError (error_msg) {
    alert(error_msg);
    document.getElementById("psw").value = "";
    document.getElementById("psw_conf").value = "";
}

function CheckDuplicate (field){
    obj = document.getElementById(field);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            //console.log(field+"-msg");
            msg = document.getElementById(field+"-msg");
            if (this.responseText == 1) {
                msg.innerHTML = obj.value + " is a taken " + field;
                msg.style.backgroundColor = 'red';
                //passwordError(field + " already exists"); 
            } else {
                msg.innerHTML = "";
                msg.style.backgroundColor = 'initial';
            }
            return ;
        } 
    };
    xhttp.open("POST", "signup_handler.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //console.log("check_duplicate=1&duplicate_type="+field+"&look_for="+obj.value);
    xhttp.send("check_duplicate=1&duplicate_type="+field+"&look_for="+obj.value);
}

window.addEventListener("DOMContentLoaded",function() {
    document.getElementById("username").addEventListener('keyup', function(){
        CheckDuplicate("username");
    });
    document.getElementById("email").addEventListener('keyup', function(){
        CheckDuplicate("email");
    });
    document.getElementById("signup-form").addEventListener("submit", function (event) {
        event.preventDefault();
        psw      = document.getElementById("psw").value;
        psw_conf = document.getElementById("psw_conf").value;
        match    = psw == psw_conf;
        
        if (!match) {
            passwordError("passwords don't match");
            return ;
        }
        if (psw.length < 7) {
            passwordError("password must be at least 6 characters");
            return ;
        }
        if (!/\d/.test(psw)) {
            passwordError("password must be at least 1 number"); 
            return ;
        }
        if ("red" == document.getElementById("username-msg").style.backgroundColor ||
            "red" == document.getElementById("email-msg").style.backgroundColor) {
            alert("make sure you have selected a unique username and/or password")
            return ;
        }
        PostSignupForm("signup-form", "signup_handler.php");
    });
});

</script>


<form id="signup-form" action="" method="post">
  <div class="container">
    
    <div id="username-msg"></div>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>

    <div id="email-msg"></div>
    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="psw"><b>Confirm Password</b></label>
    <input type="password" placeholder="Re-Enter Password" name="psw_conf" id="psw_conf" required>

    <button type="submit" id="submit">Sign Up</button>
  </div>
</form>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>