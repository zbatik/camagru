<?php
    require_once './classes/db.class.php';
    $db = new DB;
    $user_info = $db->GetUserInfo("token", $_GET["token"]);
// turn validate on
    if ($user_info != null) {
        session_start();
        $db->ActivateUser($user_info["username"]);
        $_SESSION["username"] = $user_info["username"];
        $_SESSION["email"] = $user_info["email"];
        $_SESSION["logged_on"] = 1;
        header("Location: index.php");
    } else {
        echo "<h1> Invalide Attivstion Request </h1>";
    }
?>