<script>

//generalised AJAXPOST
/*
function AjaxPost (array)
{        
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            return this.responseText;
        } 
    };
    xhttp.open("POST", "ajaxhandler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    $username = document.getElementById("uname").value;
    console.log("username_exist=1&username="+$username);
xhttp.send("username_exist=1&username="+$username);
}
*/

function passwordError (error_msg) {
    alert(error_msg);
    document.getElementById("psw").value = "";
    document.getElementById("psw_conf").value = "";
}
function CheckUser (){
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                return this.responseText;
            } 
        };
        xhttp.open("POST", "ajaxhandler.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        $username = document.getElementById("uname").value;
        console.log("username_exist=1&username="+$username);
        xhttp.send("username_exist=1&username="+$username);
    }

window.addEventListener("DOMContentLoaded",function() {
    document.getElementById("submit").addEventListener('click', function(){
        psw      = document.getElementById("psw").value;
        psw_conf = document.getElementById("psw_conf").value;
        match    = psw == psw_conf;
        /*
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
        }*/
        if (CheckUser() == "1"){
            passwordError("username already exists"); 
            return ;
        }
        // check user name is unique
        // check email is unique

    });
});
</script>

<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>
<form>
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="psw"><b>Confirm Password</b></label>
    <input type="password" placeholder="Re-Enter Password" name="psw_conf" id="psw_conf" required>

    <button type="submit" id="submit">Sign Up</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>
</form>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>