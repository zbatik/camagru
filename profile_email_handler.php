<?php

    require_once './classes/db.class.php';
    
    if (isset($_POST["email"]))
    {
        session_start();
        $db = new DB;
        $success = $db->UpdateUserItem("email", $_POST["email"], "username", $_SESSION["username"]);
        if ($success) {
            $_SESSION["email"] = $_POST["email"];
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
?>