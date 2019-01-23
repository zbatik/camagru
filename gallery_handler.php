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
            $ov_arr = $_POST["overlay_arr"];
            $dest = imagecreatefrompng($photo);
            foreach ($ov_arr as $ov)
            {
                $details = getimagesize($ov);
                $src = imagecreatefrompng($ov);
                imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 300, $details[0], $details[1]);
            }
            $file_name = "img/user/".uniqid().".png";
            imagepng($dest, $file_name);
            // echo $post_img;
            // var_dump($dest);
            $time = time();
            $db = new DB;
            $db->InsertIntoGallery($user_id, $file_name, $time);
        }
        if ($_POST["action"] == "delete_photo")
        {
            $db = new DB;
            $db->DeletePhoto($_POST["photo_id"]);
        }
    }
}
?>