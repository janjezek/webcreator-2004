<?php
include "../include/config.php";

$_login = $_POST["us_login"];
$_heslo = $_POST["us_heslo"];

if($_login && $_heslo): 

  $db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
  mysql_select_db("$dbname",$db);
	
	$query = mysql_query("select id from autori where login = '$_login' and heslo = '$_heslo'");
	$check = mysql_num_rows($query);
	
	if($check == 1): 				
		session_start(); 
		$registrace = session_register("user") ; 
			if($registrace): 
				$user_data = mysql_fetch_array($query); //Zpracov�n� dotazu
				$_SESSION["user"]["id"] = $user_data["id"]; //Ulo��me si do session ID u�ivatele pro pozd�j�� pou�it� 
				$_SESSION["user"]["interval"] = "1200"; //Ulo��me tak� $interval jak dlouho m��e b�t u�ivatel ne�inn�
				$_SESSION["user"]["session_time"] = Time(); //A tak� aktu�ln� �as 
				header("location:user.php");				
			else: 
				header("location:index.php?akce=1");					
			endif;
	else: 	
		header("location:index.php?akce=2");					
	endif;
else:
		header("location:index.php?akce=3");	
endif;
 ?>