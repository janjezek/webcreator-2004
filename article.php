<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

/* --- z�sk�n� dat z datab�ze --- */

    $result = mysql_query("select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika from clanky c, autori a, rubriky r where c.id = $id and c.id_autor = a.id and c.id_rubrika = r.id and c.stav = 'v'",$db);
    $odp_1 = mysql_num_rows($result);

    if ($odp_1 == "1") { 
      $row = mysql_fetch_array($result);

      $vic = $row["counter"]+1;

/* --- aktualizace po��tadla --- */

      $sql = "update clanky set counter = '$vic' where id = $id";
      mysql_query($sql);

      $dates = date("d.m.Y",$row["datum"]);

/* --- zobrazen� �l�nku --- */

      $pop = "$row[rubrika] - $row[nadpis]";

      cr_head($sitename, $pop);

      echo "<div id=\"clanek\">\n"; 
      echo "<h2 class=\"clanek-title\">$row[nadpis]</h2>\n";            
      echo "<p class=\"perex\">$row[perex]</p><br />\n";   
         
      echo $row["obsah"]; 
      
      echo "<div class=\"clanek-paticka\">�etlo u� �ten���: $row[counter] | <img src=\"./images/vydano.gif\" /> $dates | Rubrika: <a href=\"section.php?id=$row[id_rubrika]\" class=\"link-rubrika\">$row[rubrika]</a> ";// | <a href=\"author.php?id=$a_id\">$jmeno</a>";

    echo "</div>\n";
      echo "</div>\n";
      
/* --- zobrazen� koment��� --- */

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
    echo "<br/><p class=\"al_right\"><a href=\"comment.php?id=$id\">��st koment��e</a>, <a href=\"comment.php?id=$id\">P�idat koment��</a></p>";
  } else {
    echo " \n\n";
    echo "<p> </p>";
    echo "<p class=\"al_right\"><a href=\"comment.php?id=$id\">P�idat koment��</a></p>";
  }  

/* --- chybov� hl�?en� --- */

    } else {
      cr_head($sitename, "Neo�ek�van� chyba");  
      echo "<h2>Neo�ek�van� chyba</h2>\n";
      echo "<p style=\"text-align: center\">Neexistuj�c� parametr ID. Bez spr�vn�ho parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
    }
  
  } else {
    cr_head($sitename, "Neo�ek�van� chyba");  
    echo "<h2>Neo�ek�van� chyba</h2>\n";
    echo "<p style=\"text-align: center\">Pr�zdn� parametr ID. Bez spr�vn�ho parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
  }

} else {
  cr_head($sitename, "Neo�ek�van� chyba");  
  echo "<h2>Neo�ek�van� chyba</h2>\n";
  echo "<p style=\"text-align: center\">Nen� zad�n parametr ID. Bez tohoto parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
}

include "include/footer.php";
?>
