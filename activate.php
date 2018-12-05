<?php

    $user_info = $db->GetUserInfo("email", $_GET["email"]);
// turn validate on
    if ($user_info["token"] == $_GET["token"]) {
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["logged_on"] = 1;
        header("Location: index.php");
    } else {
        echo "<h1> DENIED </h1>";
    }
?>