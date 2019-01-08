<?php

require_once './classes/db.class.php';

$headers = getallheaders();
if ($headers["Content-type"] == "application/json") {
    $_POST = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST["update_gallery"]))
    { 
        session_start();
        $username = $_SESSION["username"];
        $photo = $_POST["photo_data"];
        $time = time();
        $db = new DB;
        $db->InsertIntoGallery($username, $photo, $time);
    }
}
?>