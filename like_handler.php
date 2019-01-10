<?php
require_once './classes/db.class.php';

$headers = getallheaders();
if ($headers["Content-type"] == "application/json") {
    $_POST = json_decode(file_get_contents("php://input"), true);
    $db = new DB;
    if ($_POST['action'] == 'add') {
        $db->AddLike($_POST["photo_id"], $_POST["user_id"]);
    } else if ($_POST['action'] == 'remove') {
        $db->DeleteLike($_POST["photo_id"], $_POST["user_id"]);
    }
}
?>