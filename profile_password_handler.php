<?php

require_once './classes/db.class.php';
    
if (isset($_POST["old_psw"]))
{
    session_start();
    $db = new DB;
    $user_info = $db->GetUserInfo("username", $_SESSION["username"]);
    $old_psw = $_POST["old_psw"];
    $new_psw = $_POST["new_psw"];
    $success = password_verify($old_psw, $user_info["password"]);
    if ($success) {
        $updated_hash = password_hash($new_psw, PASSWORD_DEFAULT);
        $db->UpdateUserItem("password", $updated_hash, "id", $_SESSION["id"]);
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

// if (isset($_POST["old_psw"]))
// {
//     print_r($_POST);
//     start_session();
//     $username = $_SESSION["username"];
//     $db = new DB;
//     $user_info = $db->GetUserInfo("username", $username);
//     $db_hash = $user_info["password"];
//     if ($db_hash == null)
//     {
//         echo 0;
//     }  else if (0 == password_verify($_POST["old_psw"], $db_hash)) {
//         echo 0;
//     } else {
//         echo 1;
//     }       
// }
?>