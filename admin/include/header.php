<?
include "include/connect.php";

session_start();

header("Pragma: No-cache");
header("Cache-Control: No-cache, Must-revalidate");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

if(!session_is_registered("user") != FALSE): 
	header("location:index.php?akce=2");	
elseif ((Time() - $_SESSION["user"]["session_time"])>=$_SESSION["user"]["interval"]): 
	header("location:index.php?akce=4");	
else: 
	$_SESSION["user"]["session_time"] = time();
endif;

echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";

function alert($mess) {
  echo "<p class=\"alert\">$mess</p>";
}

function alert2($mess) {
  echo "<p class=\"alert2\">$mess</p>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
               "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>  
  <meta http-equiv="content-type" content="text/html; charset=windows-1250"/>
  <link rel="stylesheet" href="include/style.css" type="text/css"/>
  
  <title><?php echo $sitename; ?> - Administrace</title>
</head>

<body>

<div id="telo">
  <div id="main">

    <div id="hlavicka">
  
    </div>
     
  <hr/>
     
    <div id="vlevo">  
  
    <?php  
    $_id = $_SESSION["user"]["id"];
  
    $_res = mysql_query("select jmeno, prava from autori where id = '$_id'",$db);
    $_data = mysql_fetch_array($_res);
  
    echo "<h2><img src=\"icons/head.gif\" alt=\"\"/> $_data[jmeno]</h2>\n";  
    echo "<ul>\n";
    echo "<li><a href=\"user.php\">Titulní stránka</a></li>\n"; 
    echo "<li><a href=\"us_selfedit.php\">Upravit údaje</a></li>\n"; 
    echo "<li><a href=\"cl_own.php\">Vlastní články</a></li>\n";
    echo "<li><a href=\"index.php?akce=5\">Odhlásit</a></li>\n";
    echo "</ul>\n";  
  
    if ($_data["prava"] == "1") {
      echo "<h2><img src=\"icons/admin.gif\" alt=\"\"/> Admin menu</h2>\n";  
      echo "<ul>\n";
      echo " <li><a href=\"cl_schval.php\">Schválit články</a></li>\n";
      echo "<li><a href=\"ne_schval.php\">Schválit novinky</a></li>\n"; 
      echo "<li><a href=\"us_insert.php\">Přidat uživatele</a></li>\n";
      echo "<li><a href=\"us_prehled.php\">Přehled uživatelů</a></li>\n";
      echo "<li><a href=\"bo_insert.php\">Přidat box</a></li>\n";
      echo "<li><a href=\"bo_seznam.php\">Přehled boxů</a></li>\n";  
      echo "<li><a href=\"cl_sekce.php\">Rubriky</a></li>\n";
      echo "</ul>\n";
    }
    ?>
  
      <h2><img src="icons/arts.gif" alt=""/> Články</h2>
      <ul>
        <li><a href="cl_insert.php">Vložit článek</a></li>
        <li><a href="cl_files.php">Nahrát soubor</a></li>
        <li><a href="cl_passno.php">Neschválené články</a></li>
        <li><a href="cl_pass.php">Schválené články</a></li>
        <li><a href="cl_vydane.php">Vydané články</a></li>        
      </ul> 
        
      <h2><img src="icons/news.gif" alt=""/> Novinky</h2>
      <ul>       
        <li><a href="ne_insert.php">Vložit novinku</a></li>
        <li><a href="ne_passno.php">Neschválené novinky</a></li>
        <li><a href="ne_pass.php">Schválené novinky</a></li>            
      </ul>
        
    </div>

  <hr/>

    <div id="vpravo">