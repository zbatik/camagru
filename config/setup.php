<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/camagru/classes/db.class.php";

$db = new DB;
$table= "user";
$columns = "id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR( 50 ) NOT NULL,
            email VARCHAR( 150 ) NOT NULL, 
            password VARCHAR( 64 ) NOT NULL, 
            validated tinyint(1) NOT NULL DEFAULT 0,
            token VARCHAR( 64 ) NOT NULL";

//echo "CREATE TABLE IF NOT EXISTS camagru.$table ($columns)";

$return = $db->exec("CREATE TABLE IF NOT EXISTS camagru.$table ($columns)");

/*
if ($return) 
{
    echo "Table $table - Created!<br /><br />";
}
else 
{ 
    echo "Table $table not successfully created! <br /><br />";
}*/
?>