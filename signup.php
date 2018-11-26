<script>

function passwordError (error_msg) {
    alert(error_msg);
    document.getElementById("psw").value = "";
    document.getElementById("psw_conf").value = "";
}

window.addEventListener("DOMContentLoaded",function() {
    document.getElementById("submit").addEventListener('click', function(){
        psw     =document.getElementById("psw").value;
        psw_conf=document.getElementById("psw_conf").value;
        match = psw == psw_conf
        if (!match)
            passwordError("passwords don't match");
        if (psw.length < 7)
            passwordError("password must be at least 6 characters");
        if (!/\d/.test(psw))
            passwordError("password must be at least 1 number"); 
        // check user name is unique
        // check email is unique

    });  
});
</script>

<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<form action="signup.php">
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