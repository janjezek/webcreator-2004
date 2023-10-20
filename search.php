<?php
include "include/header.php";

/* --- listování èlánkù --- */

if (isset($_GET["id"])) {
$vyh = $_GET["id"];

cr_head($sitename, "Vyhledávání výrazu \"$vyh\"");
echo "<h2><font color=#486c2d>Vyhledávání výrazu \"$vyh\"</font></h2>";

$cas = time();

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysql_query("select id from clanky where nadpis like '%$vyh%'  and stav = 'v' and datum <= $cas");


/* --- vybrání èlánkù z databáze --- */

$vysledek = mysql_query("select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum from clanky c, rubriky r, autori a where (c.nadpis like '%$vyh%' or c.obsah like '%$vyh%' or c.perex like '%$vyh%') and c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and datum <= $cas order by c.datum desc limit $zaznam, $pocet",$db);
$control = mysql_num_rows($vysledek);

if ($control == "0") {
  if (!isset($_GET["list"])) {
    echo "<p style=\"text-align: center\"><font color=#486c2d>Hledanému výrazu neodpovídají žádné èlánky!</font></p>";
  } else {
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistující parametr LIST. Bez správného parametru není mo?né zobrazit èlánky.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }
} else {
  while ($row = mysql_fetch_row($vysledek)) {
    $id2 = $row[0];
    $nadpis = $row[1];
    $perex = $row[2];
    $r_id = $row[3];
    $rubrika = $row[4];
    $a_id = $row[5];
    $jmeno = $row[6];  
    $datum = date("d.m.Y",$row[7]);  
    
    $vysledek2 = mysql_query("select id from komentare where id_clanek = $id2",$db);
    $comx = mysql_num_rows($vysledek2);   
    
    if ($comx == "1") {
      $hl_cm = "komentáø";
    } elseif ($comx >= "5" or $comx == "0") {
      $hl_cm = "komentáøù\n";
    } else {
      $hl_cm = "komentáøe\n";
    } 
    
    $comx2 = "$comx $hl_cm";
  
    clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx2);    
  }
  include "listovani.php";
}
}

include "include/footer.php";
?>
