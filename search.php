<?php
include "include/header.php";

/* --- listov�n� �l�nk� --- */

if (isset($_GET["id"])) {
$vyh = $_GET["id"];

cr_head($sitename, "Vyhled�v�n� v�razu \"$vyh\"");
echo "<h2><font color=#486c2d>Vyhled�v�n� v�razu \"$vyh\"</font></h2>";

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


/* --- vybr�n� �l�nk� z datab�ze --- */

$vysledek = mysql_query("select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum from clanky c, rubriky r, autori a where (c.nadpis like '%$vyh%' or c.obsah like '%$vyh%' or c.perex like '%$vyh%') and c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and datum <= $cas order by c.datum desc limit $zaznam, $pocet",$db);
$control = mysql_num_rows($vysledek);

if ($control == "0") {
  if (!isset($_GET["list"])) {
    echo "<p style=\"text-align: center\"><font color=#486c2d>Hledan�mu v�razu neodpov�daj� ��dn� �l�nky!</font></p>";
  } else {
    echo "<h2>Neo�ek�van� chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistuj�c� parametr LIST. Bez spr�vn�ho parametru nen� mo?n� zobrazit �l�nky.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
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
      $hl_cm = "koment��";
    } elseif ($comx >= "5" or $comx == "0") {
      $hl_cm = "koment���\n";
    } else {
      $hl_cm = "koment��e\n";
    } 
    
    $comx2 = "$comx $hl_cm";
  
    clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx2);    
  }
  include "listovani.php";
}
}

include "include/footer.php";
?>
