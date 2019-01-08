<?php
    require_once './classes/db.class.php';
    
    if (isset($_POST["username"]) && isset($_POST["psw"]))
    {
        $username = $_POST["username"];
        $db = new DB;
        $user_info = $db->GetUserInfo("username", $username);
        $db_hash = $user_info["password"];
        if ($db_hash == null)
        {
            echo 0;
        }  else if (0 == password_verify($_POST["psw"], $db_hash)) {
            echo 0;
        } else {

            if ($user_info["validated"]){
                echo 1;
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $user_info["email"];
                $_SESSION["id"] = $user_info["id"];
                $_SESSION["logged_on"] = 1;
            } else {
                echo -1;
            }
        }       
    }
?>