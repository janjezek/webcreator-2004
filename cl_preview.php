<?php
include "include/header.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];

/* --- získání dat z databáze --- */

  $result = mysql_query("select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika from clanky c, autori a, rubriky r where c.id = $id and c.id_autor = a.id and c.id_rubrika = r.id",$db);
  $odp_1 = mysql_num_rows($result);

  if ($odp_1 == "1") { 
    $row = mysql_fetch_array($result);

/* --- zobrazení èlánku --- */

    $dates = date("d.m.Y",$row["datum"]);

    $pop = "$row[rubrika] - $row[nadpis]";

    cr_head($sitename, $pop);

    echo "<div id=\"clanek\">\n"; 
    echo "<h2>$row[nadpis]</h2>\n";            
    echo "<p>$row[perex]</p>\n";   
         
    echo" <p> $row[obsah] </p>"; 

    echo "<p style=\"text-align: right; margin-top: 25px\">\n";
    echo "<a href=\"author.php?id=$row[id]\">$row[jmeno]</a>\n<br/>\n$row[informace]\n";            
    echo "</p>\n";

    echo "<p>\n";
    echo "Rubrika: <a href=\"section.php?id=$row[id_rubrika]\">$row[rubrika]</a><br/>\n";   
    echo "Vydáno: $dates<br/>\n"; 
    echo "Poèítadlo: $row[counter] ";

    if ($row["counter"] == "1") {
      echo "ètenáø\n";
    } elseif ($row["counter"] >= "5" or $row["counter"] == "0") {
      echo "ètenáøù\n";
    } else {
      echo "ètenáøi\n";
    }
            
    echo "</p>\n";
    echo "</div>\n";
  
  } else {
    cr_head($sitename, "Neoèekávaná chyba");  
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistující parametr ID. Bez správného parametru není možné zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }

} else {
  cr_head($sitename, "Neoèekávaná chyba");  
  echo "<h2>Neoèekávaná chyba</h2>\n";
  echo "<p style=\"text-align: center\">Není zadán parametr ID. Bez tohoto parametru není možné zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
}

include "include/footer.php";
?>