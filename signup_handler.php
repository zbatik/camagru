<?php
    
require_once './classes/db.class.php';

if (isset($_POST["check_duplicate"]))
{    
    $field = $_POST["duplicate_type"];
    $equals = $_POST["look_for"];
    $db = new DB;
    $exists = $db->ItemExists($field, $equals);
    echo $exists;
}

if (isset($_POST["username"]) && isset($_POST["psw"]))
{
    require_once './classes/db.class.php';
    $username = $_POST["username"];
    $email = $_POST["email"];
    $psw = password_hash($_POST["psw"], PASSWORD_DEFAULT);
    $db = new DB;
    $token = uniqid();
    
    //send email
    $headers = "FROM: noreply@camagru.com";
    $msg = "Welcome to Camagru\nClick the link below to activete your account\n\n";
    $msg .= "http://localhost:8080/camagru/activate.php?email=$email&token=$token\n";
    $msg = wordwrap($msg,120);
    if (mail($email, "Activate Account", $msg, $headers)) {
        $db->InsertIntoUser ($username, $email, $psw, $token);
        echo 1;
    } else {
        echo 0;
    }
}
?>