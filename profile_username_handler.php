<?php

    require_once './classes/db.class.php';
    
    if (isset($_POST["username"]))
    {
        session_start();
        $db = new DB;
        $success = $db->UpdateUserItem("username", $_POST["username"], "id", $_SESSION["id"]);
        if ($success) { 
            $_SESSION["username"] = $_POST["username"];
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
?>