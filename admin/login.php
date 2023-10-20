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
				$user_data = mysql_fetch_array($query); //Zpracování dotazu
				$_SESSION["user"]["id"] = $user_data["id"]; //Uložíme si do session ID uživatele pro pozdìjší použití 
				$_SESSION["user"]["interval"] = "1200"; //Uložíme také $interval jak dlouho mùže být uživatel neèinný
				$_SESSION["user"]["session_time"] = Time(); //A také aktuální èas 
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