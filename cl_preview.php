<?php
include "include/header.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];

/* --- z�sk�n� dat z datab�ze --- */

  $result = mysql_query("select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika from clanky c, autori a, rubriky r where c.id = $id and c.id_autor = a.id and c.id_rubrika = r.id",$db);
  $odp_1 = mysql_num_rows($result);

  if ($odp_1 == "1") { 
    $row = mysql_fetch_array($result);

/* --- zobrazen� �l�nku --- */

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
    echo "Vyd�no: $dates<br/>\n"; 
    echo "Po��tadlo: $row[counter] ";

    if ($row["counter"] == "1") {
      echo "�ten��\n";
    } elseif ($row["counter"] >= "5" or $row["counter"] == "0") {
      echo "�ten���\n";
    } else {
      echo "�ten��i\n";
    }
            
    echo "</p>\n";
    echo "</div>\n";
  
  } else {
    cr_head($sitename, "Neo�ek�van� chyba");  
    echo "<h2>Neo�ek�van� chyba</h2>\n";
    echo "<p style=\"text-align: center\">Neexistuj�c� parametr ID. Bez spr�vn�ho parametru nen� mo�n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
  }

} else {
  cr_head($sitename, "Neo�ek�van� chyba");  
  echo "<h2>Neo�ek�van� chyba</h2>\n";
  echo "<p style=\"text-align: center\">Nen� zad�n parametr ID. Bez tohoto parametru nen� mo�n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
}

include "include/footer.php";
?>