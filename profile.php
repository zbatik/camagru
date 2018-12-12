<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<script>
window.addEventListener("DOMContentLoaded",function() {
        var userform = "profile-username-form";
        document.getElementById(userform).addEventListener("submit", function (event) {
            event.preventDefault();
            PostUpdateForm(userform, "profile_username_handler.php");
        });
        var emailform = "profile-email-form";
        document.getElementById(emailform).addEventListener("submit", function (event) {
            event.preventDefault();
            PostUpdateForm(emailform , "profile_email_handler.php");
        });
        var pswform = "profile-password-form";
        document.getElementById(pswform).addEventListener("submit", function (event) {
            event.preventDefault();
            PostUpdateForm(pswform, "profile_password_handler.php");
        });
});
</script>

<h2> My Profile </h2>
<h3> Update My info </h3>

<form id="profile-username-form" action="" method="post">
  <div class="container">
    
    <div id="username-msg"></div>
    <label for="username"><b>Username</b></label>
    <input type="text" name="username" id="username" value="<?php echo $_SESSION["username"]?>" required>

    <button type="submit" id="submit1">Change Username</button>
  </div>
</form>

<form id="profile-email-form" action="" method="post">
  <div class="container">
    
    <div id="email-msg"></div>
    <label for="email"><b>Email</b></label>
    <input type="email" name="email" id="email" value="<?php echo $_SESSION["email"]?>" required>

    <button type="submit" id="submit2">Change Email</button>
  </div>
</form>

<form id="profile-password-form" action="" method="post">
  <div class="container">

    <label for="old_psw"><b>Old Password</b></label>
    <input type="password" name="old_psw" id="old_psw" required>
   
    <label for="new_psw"><b>New Password</b></label>
    <input type="password" name="new_psw" id="new_psw" required>

    <label for="new_psw_conf"><b>Confirm New Password</b></label>
    <input type="password" name="new_psw_conf" id="new_psw_conf" required>

    <button type="submit" id="submit3">Change Password</button>
  </div>
</form>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>
