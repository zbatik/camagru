<?php
    require_once './classes/db.class.php';
    
    if (isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $db = new DB;
        $user_info = $db->GetUserInfo("email", $email);
        if ($user_info == null)
        {
            echo 0;
        } else {
            $newpassword = uniqid();
            ResetPassword($email, $newpassword);
            $msg = "Your new password is $newpassword\nJust don't forget it next time.";
            mail($email, "Password Reset", $msg);
        }       
    }
?>