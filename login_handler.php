<?php
    require_once './classes/db.class.php';
    
    if (isset($_POST["username"]) && isset($_POST["psw"]))
    {
        $username = $_POST["username"];
        $incoming_hash = password_hash($_POST["psw"], PASSWORD_DEFAULT);
        $db = new DB;
        $db_hash = ($db->GetUserInfo($username))["password"];
        if ($db_hash == null)
        {
            echo 0;
            echo "null";
        }  else if ($db_hash != $incoming_hash) {
            echo 0;
            echo "no match";
        } else {
            echo 1;
            echo "success";
        }
        echo PHP_EOL."username: $username".PHP_EOL;
        echo "password: ".$_POST["psw"].PHP_EOL;
        echo "db hash:".PHP_EOL.$db_hash.PHP_EOL;
        echo "incoming hash:".PHP_EOL.$incoming_hash.PHP_EOL;
        
    }
?>