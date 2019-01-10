<?php
    require_once './classes/db.class.php';
    $db = new DB;
    $db->AddComment($_POST['photo_id'] ,$_POST['user_id'], $_POST['comment'], time());
?>