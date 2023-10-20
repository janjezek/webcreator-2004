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
    echo "<li><a href=\"user.php\">Tituln� str�nka</a></li>\n"; 
    echo "<li><a href=\"us_selfedit.php\">Upravit �daje</a></li>\n"; 
    echo "<li><a href=\"cl_own.php\">Vlastn� �l�nky</a></li>\n";
    echo "<li><a href=\"index.php?akce=5\">Odhl�sit</a></li>\n";
    echo "</ul>\n";  
  
    if ($_data["prava"] == "1") {
      echo "<h2><img src=\"icons/admin.gif\" alt=\"\"/> Admin menu</h2>\n";  
      echo "<ul>\n";
      echo " <li><a href=\"cl_schval.php\">Schv�lit �l�nky</a></li>\n";
      echo "<li><a href=\"ne_schval.php\">Schv�lit novinky</a></li>\n"; 
      echo "<li><a href=\"us_insert.php\">P�idat u�ivatele</a></li>\n";
      echo "<li><a href=\"us_prehled.php\">P�ehled u�ivatel�</a></li>\n";
      echo "<li><a href=\"bo_insert.php\">P�idat box</a></li>\n";
      echo "<li><a href=\"bo_seznam.php\">P�ehled box�</a></li>\n";  
      echo "<li><a href=\"cl_sekce.php\">Rubriky</a></li>\n";
      echo "</ul>\n";
    }
    ?>
  
      <h2><img src="icons/arts.gif" alt=""/> �l�nky</h2>
      <ul>
        <li><a href="cl_insert.php">Vlo�it �l�nek</a></li>
        <li><a href="cl_files.php">Nahr�t soubor</a></li>
        <li><a href="cl_passno.php">Neschv�len� �l�nky</a></li>
        <li><a href="cl_pass.php">Schv�len� �l�nky</a></li>
        <li><a href="cl_vydane.php">Vydan� �l�nky</a></li>        
      </ul> 
        
      <h2><img src="icons/news.gif" alt=""/> Novinky</h2>
      <ul>       
        <li><a href="ne_insert.php">Vlo�it novinku</a></li>
        <li><a href="ne_passno.php">Neschv�len� novinky</a></li>
        <li><a href="ne_pass.php">Schv�len� novinky</a></li>            
      </ul>
        
    </div>

  <hr/>

    <div id="vpravo">