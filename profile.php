<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<script>

function updateSubscription(user_id, change_to)
{
        var xhttp = new XMLHttpRequest();
        var postObj = {
            action: "update",
            user_id: user_id,
            preference: change_to
        }
        xhttp.open("POST", "profile_notifications_handler.php");
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.onreadystatechange = function(event) {
            if (this.readyState == 4 && this.status == 200) {
                console.log("notifications preferences updated" + event.target.responseText);
                return ;
            } 
        };
        xhttp.send(JSON.stringify(postObj));
}

function subscribe(user_id) {
  console.log("subscribed");
  var unsub = document.getElementById("unsubscribe-but");
  var sub = document.getElementById("subscribe-but");
  unsub.style.display = "block";
  sub.style.display = "none";
  updateSubscription(user_id, 1);
}

function unsubscribe(user_id) {
  console.log("unsubscribed");
  var unsub = document.getElementById("unsubscribe-but");
  var sub = document.getElementById("subscribe-but");
  unsub.style.display = "none";
  sub.style.display = "block";
  updateSubscription(user_id, 0);
}

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
<?php
  $id = $_SESSION["id"];
  require_once './classes/db.class.php';
  $db = new DB;
  $user_info = $db->GetUserInfo("username", $_SESSION["username"]);
  if ($user_info["receive_notifications"]) {
    $unsub_disp = "block";
    $sub_disp = "none";
  } else {
    $unsub_disp = "none";
    $sub_disp = "block";
  }

  echo "<button id='unsubscribe-but' onclick='unsubscribe($id)' style='background-color: grey; display: $unsub_disp'>unsubscribe from notification mail</button>";  
  echo "<button id='subscribe-but' onclick='subscribe($id)' style='display: $sub_disp'>subscribe to notification mail</button>";
    
?>

<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>
