<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

/* --- získání dat z databáze --- */

    $result = mysql_query("select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika from clanky c, autori a, rubriky r where c.id = $id and c.id_autor = a.id and c.id_rubrika = r.id and c.stav = 'v'",$db);
    $odp_1 = mysql_num_rows($result);

    if ($odp_1 == "1") { 
      $row = mysql_fetch_array($result);

      $vic = $row["counter"]+1;

/* --- aktualizace poèítadla --- */

      $sql = "update clanky set counter = '$vic' where id = $id";
      mysql_query($sql);

      $dates = date("d.m.Y",$row["datum"]);

/* --- zobrazení èlánku --- */

      $pop = "$row[rubrika] - $row[nadpis]";

      cr_head($sitename, $pop);

      echo "<div id=\"clanek\">\n"; 
      echo "<h2 class=\"clanek-title\">$row[nadpis]</h2>\n";            
      echo "<p class=\"perex\">$row[perex]</p><br />\n";   
         
      echo $row["obsah"]; 
      
      echo "<div class=\"clanek-paticka\">Èetlo už ètenáøù: $row[counter] | <img src=\"./images/vydano.gif\" /> $dates | Rubrika: <a href=\"section.php?id=$row[id_rubrika]\" class=\"link-rubrika\">$row[rubrika]</a> ";// | <a href=\"author.php?id=$a_id\">$jmeno</a>";

    echo "</div>\n";
      echo "</div>\n";
      
/* --- zobrazení komentáøù --- */

  $result = mysql_query("select id from komentare where id_clanek = $id",$db);
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 != "0") {
    echo " \n\n";

    $vysledek = mysql_query("select datum, jmeno, predmet, email from komentare where id_clanek = $id order by id desc",$db);

      echo " ";
    while ($row = mysql_fetch_array($vysledek)) {
      $datum = $row["datum"];
      $jmeno = $row["jmeno"];
      $predmet = $row["predmet"];
      $email = $row["email"]; 

      echo "  \n";
    }
    echo " ";
    echo "<br/><p class=\"al_right\"><a href=\"comment.php?id=$id\">Èíst komentáøe</a>, <a href=\"comment.php?id=$id\">Pøidat komentáø</a></p>";
  } else {
    echo " \n\n";
    echo "<p> </p>";
    echo "<p class=\"al_right\"><a href=\"comment.php?id=$id\">Pøidat komentáø</a></p>";
  }  

/* --- chybové hlá?ení --- */

    } else {
      cr_head($sitename, "Neoèekávaná chyba");  
      echo "<h2>Neoèekávaná chyba</h2>\n";
      echo "<p style=\"text-align: center\">Neexistující parametr ID. Bez správného parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
    }
  
  } else {
    cr_head($sitename, "Neoèekávaná chyba");  
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p style=\"text-align: center\">Prázdný parametr ID. Bez správného parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }

} else {
  cr_head($sitename, "Neoèekávaná chyba");  
  echo "<h2>Neoèekávaná chyba</h2>\n";
  echo "<p style=\"text-align: center\">Není zadán parametr ID. Bez tohoto parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
}

include "include/footer.php";
?>
