<?php
include "include/header.php";
?>

<h1>Administrace &gt; Nahrát soubor</h1>

<?php

/* --- zpracování a uložení souborù nahraných pøes formuláø --- */

if (isset($_POST["ok"])) {
  $_nazev = $_FILES["soubor1"]["name"];
  $_typ = $_FILES['soubor1']['type'];  
  $_velikost = $_FILES["soubor1"]["size"];
  
  $dotaz_1 = mysql_query("select * from soubory where nazev = '$_nazev'");
  $odp_1 = mysql_num_rows($dotaz_1);
  
  if ($odp_1 == "0") {  
    $sql = "insert into soubory (nazev, typ, velikost) VALUES ('$_nazev', '$_typ', '$_velikost')";
    $result = mysql_query($sql);
    
    if (!$result) {
      alert2("Soubor nebyl uložen v databázi!");
    }
      alert("Soubor byl úspìšnì uložen v databázi.");  

    copy($_FILES["soubor1"]["tmp_name"], "../archiv/{$_FILES["soubor1"]["name"]}");

  } else {
    alert2("Soubor $_nazev už existuje a proto není možné jej znovu nahrát!<br/> Soubor musíte pøejmenovat a znovu nahrát!");
  }
}  

/* --- smazání souboru --- */

if (isset($_REQUEST["id"])) {
$id = $_REQUEST["id"];

$vys = mysql_query("select nazev from soubory where id = $id",$db);

while ($row = mysql_fetch_array($vys)) {
  $nazev = $row["nazev"];
  
  unlink("../archiv/$nazev");
}

$sql = "delete from soubory where id = $id";
$result = mysql_query($sql);
if (!$result) {
alert2("Soubor nebyl smazán z databáze!");
} else {
alert("Soubor byl úspìšnì smazán z databáze.");
}
}
?>

<form action="cl_files.php" method="post" enctype="multipart/form-data">
  <table>    
    <tr>
      <td style="vertical-align: middle">Soubor:</td>
      <td><input type="file" name="soubor1"/></td>
    </tr>
    <tr>
      <td><input type="submit" name="ok" value="Vložit"/></td>
      <td></td>
    </tr>
  </table>
</form>
  
<br/>

<?

/* --- funkce na formátování velikosti --- */

function zformatovat($a) 
{
		$a = StrRev("".$a);
		$zh="";
		for ($i=0; $i<StrLen($a); $i++)
		{
			$zh.=$a[$i];
			if (($i+1)%3==0) $zh.= ";psbn&";
		}
		$a = StrRev("".$zh);
		if ($a[0]=='&') 
				$a = SubStr ($a,6);
		return $a;
}

/* --- zobrazení seznamu souborù --- */

$pocet = "10";

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysql_query("select id from soubory");

$vysledek = mysql_query("select * from soubory order by id desc limit $zaznam, $pocet",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $id = $row["id"];
  $nazev = $row["nazev"];
  $velikost = $row["velikost"];
  $typ = $row["typ"];
  
/* --- formátování velikosti --- */
	
	$velikost2 = zformatovat($velikost);

/* --- pøidání ikonek k souborùm (dodìlat XLS, PDF, ZIP a MPG) --- */

  if ($typ == "image/gif") {
    $icon = "gif";
  } elseif ($typ == "image/jpeg" || $typ == "image/pjpeg") {
    $icon = "jpg";
  } elseif ($typ == "image/x-png") {
    $icon = "png";
  } elseif ($typ == "text/richtext") {
    $icon = "doc";
  } elseif ($typ == "application/x-tar") {
    $icon = "rar";
  } else {
   $icon = "def";
  }
  
  echo "<table><tr><td style=\"width: 40px\"><img src=\"icons/files/$icon.gif\" alt=\"\"/></td><td style=\"width: 300px\"><b>$nazev</b><br/>\n<i>$velikost2 b, $typ</i></td><td><br/><a href=\"../archiv/$nazev\" target=\"new\"><img src=\"icons/preview.gif\" alt=\"Zobrazit\"/> Zobrazit</a>, <a href=\"cl_files.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento soubor?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td></tr></table>\n";
}

include "listovani.php";
include "include/footer.php";
?>