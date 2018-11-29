<?php
   // init_set('display_errors', 1);
   // init_set('display_startup_errors', 1);
   // error_reporting(E_ALL);
    
    //include_once ($_SERVER["DOCUMENT_ROOT"]."/camagru/classes/db.class.php");
if (isset($_POST["check_duplicate"]))
{
    require_once './classes/db.class.php';
    $field = $_POST["duplicate_type"];
    $equals = $_POST["look_for"];
    $db = new DB;
    $exists = $db->ItemExists($field, $equals);
    echo $exists;

}

?>