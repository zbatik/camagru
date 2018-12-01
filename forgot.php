<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<script>

window.addEventListener("DOMContentLoaded",function() {
        document.getElementById("forgot-form").addEventListener("submit", function (event) {
            event.preventDefault();
            PostForgotForm("forgot-form", "forgot_handler.php");
        });
});

</script>
<h3> Enter Email to Recieve a Recovery Password </h3>
<form action="" method="post" id="forgot-form">
  <div class="container">
    <label for="username"><b>Recovery Email</b></label>
    <input type="text" placeholder="Enter Email" name="username" required>

    <button type="submit">Recover Password</button>
  </div>
</form>