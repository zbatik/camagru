<?php
    require_once './classes/db.class.php';
    $db = new DB;
    $db->AddComment($_POST['photo_id'] ,$_POST['user_id'], $_POST['comment'], time());
    $user_info = $db->GetUserInfo('id', $_POST['photo_user_id']);
    if ($user_info["receive_notifications"])
    {
        $msg = "You got a comment on Camagru. Well done, someone cares\n".$_POST['comment'];
        mail($user_info["email"], "New Comment", $msg);
    }
?>