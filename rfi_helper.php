<?php

include("../../../include/lib/main.lib.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = mysql_connect('db', 'root', '1234');
$res = db_query("SELECT password FROM eclass.user where user_id = 1", 'eclass');
$row = mysql_fetch_row($res);
echo $row[0];


?>