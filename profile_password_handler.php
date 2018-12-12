<?php
        if (isset($_POST["psw_old"]))
        {
            start_session();
            $username = $_SESSION["username"];
            $db = new DB;
            $user_info = $db->GetUserInfo("username", $username);
            $db_hash = $user_info["password"];
            if ($db_hash == null)
            {
                echo 0;
            }  else if (0 == password_verify($_POST["psw"], $db_hash)) {
                echo 0;
            } else {
                echo 1;
            }       
        }
?>