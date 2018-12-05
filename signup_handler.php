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
    $db->InsertIntoUser ($username, $email, $psw);
    //send email
}
?>