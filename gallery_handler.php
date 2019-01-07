<?php

require_once './classes/db.class.php';

if (isset($_POST["update_gallery"]))
{    
    session_start();
    $username = $_SESSION["username"];
    $photo = $_POST["photo_data"];
    $time = time();
    echo "$username, $photo, $time";
    $db = new DB;
    $db->InsertIntoGallery($username, $photo, $time);
}
?>