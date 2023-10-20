<?php
include "include/config.php";

$db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
?>