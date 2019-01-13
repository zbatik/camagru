<?php

require_once './classes/db.class.php';

$headers = getallheaders();
if ($headers["Content-type"] == "application/json") {
    $_POST = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST["action"]))
    { 
        if ($_POST["action"] == "update")
        {
         // echo    $_POST["user_id"], $_POST["preference"];
            $db = new DB;
            $db->UpdateEmailNotificationPreferences($_POST["user_id"], $_POST["preference"]);
        }
    }
}
?>