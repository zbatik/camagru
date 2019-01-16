<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<script>

window.addEventListener("DOMContentLoaded",function() {
        document.getElementById("login-form").addEventListener("submit", function (event) {
            event.preventDefault();
            PostLoginForm("login-form", "login_handler.php");
        });
});

</script>



<form action="" method="post" id="login-form">
  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw">Forgot <a href="forgot.php">password?</a></span>
  </div>
</form>
