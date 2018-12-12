<?php

    require_once './classes/db.class.php';
    
    if (isset($_POST["username"]))
    {
        session_start();
        $db = new DB;
        $db->UpdateUserItem("username", $_POST["username"], "email", $_SESSION["email"]);
        $_SESSION["username"] = $_POST["username"];
        echo 1;
    } else {
        echo 0;
    }
?>