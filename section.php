<?php
include "include/header.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];

/* --- zjist˜ n˜zev sekce --- */

  $vysledek = mysql_query("select rubrika from rubriky where id = '$id'",$db);
  $odp_1 = mysql_num_rows($vysledek);

  if ($odp_1 == "1") {

    while ($row = mysql_fetch_row($vysledek)) {
      $naz_sek = $row[0];
      cr_head($sitename, $naz_sek);
      echo "<h2>Rubrika $naz_sek</h2>";
    } 

/* --- listov˜n˜ --- */

    $cas = time();

    if (!isset($_GET["list"])) {
      $list = 1;
      $zaznam = 0;
    } else {
      $_list = $_GET["list"];
      $list = $_list--;
      $zaznam = $pocet * $_list;
    }

    $_pocet = $zaznam + $pocet;
    $vysledek_celk = mysql_query("select id from clanky where stav = 'v' and id_rubrika = '$id' and datum <= $cas");

/* --- vybere ˜l˜nky z datb˜ze --- */

    $vysledek = mysql_query("select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and c.id_rubrika = '$id' and datum <= $cas order by c.datum desc limit $zaznam, $_pocet",$db);
    $control = mysql_num_rows($vysledek);

    if ($control == "0") {
      if (!isset($_GET["list"])) {
        echo "<p style=\"text-align: center\">V t˜to rubrice zat˜m nejsou ˜˜dn˜ ˜l˜nky!</p>";
      } else {        
        echo "<p style=\"text-align: center\">Neexistuj˜c˜ parametr LIST. Bez spr˜vn˜ho parametru nen˜ mo˜n˜ zobrazit ˜l˜nky.<br/>Pros˜m pokra˜ujte na <a href=\"index.php\">tituln˜ str˜nku</a>.\n";
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
          $hl_cm = "koment˜˜";
        } elseif ($comx >= "5" or $comx == "0") {
          $hl_cm = "koment˜˜˜\n";
        } else {
          $hl_cm = "koment˜˜e\n";
        } 
    
        $comx2 = "$comx $hl_cm";
  
        clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx2);    
      }
      include "listovani.php";
    }

  } else {
    cr_head($sitename, "Neo˜ek˜van˜ chyba"); 
    echo "<h2>Neo˜ek˜van˜ chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistuj˜c˜ parametr ID. Bez spr˜vn˜ho parametru nen˜ mo˜n˜ zobrazit ˜l˜nky.<br/>Pros˜m pokra˜ujte na <a href=\"index.php\">tituln˜ str˜nku</a>.\n";
  }

} else {
  cr_head($sitename, "Neo˜ek˜van˜ chyba"); 
  echo "<h2>Neo˜ek˜van˜ chyba</h2>\n";
  echo "<p style=\"text-align: center\">Nen˜ zad˜n parametr ID. Bez tohoto parametru nen˜ mo˜n˜ zobrazit ˜l˜nky.<br/>Pros˜m pokra˜ujte na <a href=\"index.php\">tituln˜ str˜nku</a>.\n";
}

include "include/footer.php";
?>
