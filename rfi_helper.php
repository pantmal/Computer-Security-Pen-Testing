<?php

include("../../../include/lib/main.lib.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = mysql_connect('db', 'root', '1234');
$res = db_query("SELECT password FROM eclass.user where user_id = 1", 'eclass');
$row = mysql_fetch_row($res);
echo $row[0];
$newContent_en = "<script> document.body.innerHTML = \'<p>O <small> pantelis </small> einai <i><b>vlakas</b></i></p> <p>H <sub>2</sub> O</p><br/><h1>My style rocks</h1><p>Lets give some style heeere</p>\' </script>";
// $newContent_en = "<script> alert(1) </script>";
db_query("INSERT INTO admin_announcements
                SET gr_title = '', gr_body = '', gr_comment = '',
                en_title = '', en_body = '$newContent_en', en_comment = '',
                visible = 'V', date = NOW()");


?>