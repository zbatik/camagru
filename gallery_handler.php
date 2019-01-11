<?php

require_once './classes/db.class.php';

$headers = getallheaders();
if ($headers["Content-type"] == "application/json") {
    $_POST = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST["action"]))
    { 
        if ($_POST["action"] == "post_photo")
        {
            session_start();
            $user_id = $_SESSION["id"];
            $photo = $_POST["photo_data"];
            $time = time();
            $db = new DB;
            $db->InsertIntoGallery($user_id, $photo, $time);
        }
        if ($_POST["action"] == "delete_photo")
        {
            $db = new DB;
            $db->DeletePhoto($_POST["photo_id"]);
        }
    }
}
?>