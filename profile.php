<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>
<h2> My Profile </h2>
<h3> Update My info </h3>

<form id="profile-form" action="" method="post">
  <div class="container">
    
    <div id="username-msg"></div>
    <label for="username"><b>Username</b></label>
    <input type="text" name="username" id="username" value="<?php echo $_SESSION["username"]?>" required>

    <div id="email-msg"></div>
    <label for="email"><b>Email</b></label>
    <input type="email" name="email" id="email" value="<?php echo $_SESSION["email"]?>" required>

    <label for="old_psw"><b>Old Password</b></label>
    <input type="password" name="old_psw" id="old_psw" required>
   
    <label for="new_psw"><b>New Password</b></label>
    <input type="password" name="new_psw" id="new_psw" required>

    <label for="psw"><b>Confirm New Password</b></label>
    <input type="password" name="new_psw_conf" id="new_psw_conf" required>

    <button type="submit" id="submit">Update</button>
  </div>
</form>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>
