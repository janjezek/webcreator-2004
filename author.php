<?php
include "include/header.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];

/* --- zjistí jméno autora --- */

  $vysledek = mysql_query("select jmeno from autori where id = '$id'",$db);
  $odp_1 = mysql_num_rows($vysledek);

  if ($odp_1 == "1") {   
  
    while ($row = mysql_fetch_row($vysledek)) {
      $jme_aut = $row[0];
      cr_head($sitename, $jme_aut);
      echo "<h2>Autor $jme_aut</h2>";
    } 

/* --- listování --- */

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
    $vysledek_celk = mysql_query("select id from clanky where id_autor = $id and stav = 'v' and datum <= $cas");

/* --- vybrání èlánkù z databáze --- */

    $vysledek = mysql_query("select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and a.id = $id  and c.stav = 'v' and datum <= $cas order by c.datum desc limit $zaznam, $_pocet",$db);
    $control = mysql_num_rows($vysledek);

    if ($control == "0") {
      if (!isset($_GET["list"])) {
        echo "<p style=\"text-align: center\">Autor zatím nevydal žádné èlánky!</p>";
      } else {
        echo "<p style=\"text-align: center\">Neexistující parametr LIST. Bez správného parametru není možné zobrazit èlánky.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
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

  } else {
    cr_head($sitename, "Neoèekávaná chyba"); 
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistující parametr ID. Bez správného parametru není možné zobrazit èlánky autora.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }

} else {
  cr_head($sitename, "Neoèekávaná chyba"); 
  echo "<h2>Neoèekávaná chyba</h2>\n";
  echo "<p style=\"text-align: center\">Není zadán parametr ID. Bez tohoto parametru není možné zobrazit èlánky autora.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
}

include "include/footer.php";
?>
