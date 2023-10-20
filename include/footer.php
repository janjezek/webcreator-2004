<?php
$akt_rok = date("Y");
if ($akt_rok != $start_year) {
  $bt_dt = "$start_year - $akt_rok";
} else {
  $bt_dt = $akt_rok;
}
?>
  </div>
  
  <div id="sidebox">
    <div id="okraj">
    <!-- pravý sloupec -->
    
<?php
echo "<h2 id=\"novinky\">Aktuality</h2>\n";

$vysledek_n = mysql_query("select n.*, a.id, a.jmeno from novinky n, autori a where n.autor = a.id and stav = 'v' order by n.id desc limit $pocet_n",$db);
$kontrola = mysql_num_rows($vysledek_n);

if ($kontrola == "0") {
  echo "Žádné novinky nebyly zatím vloženy!";
} else {
  while ($row_n = mysql_fetch_array($vysledek_n)) {
    $datum2 = $row_n["datum"];
    $titulek2 = $row_n["titulek"];
    $novinka2 = $row_n["novinka"];
    $n_a_id = $row_n["id"];
    $jmeno2 = $row_n["jmeno"];

    echo "<font size=1> $novinka2</font><p><font size=1>  $datum2  </font><a href=\"author.php?id=$n_a_id\">$jmeno2</a></p>\n";
  }
}

/* --- rubriky --- */

$res = mysql_query("select id, rubrika from rubriky order by rubrika",$db);

echo "<h2 class=\"title\">Rubriky</h2>\n";
echo "<div class=\"box\">\n<div id=\"menu\">\n";
echo "<ul>";

while ($row2 = mysql_fetch_array($res)) {
  $id2 = $row2["id"];
  $jmeno = $row2["rubrika"];
  if (($id2==1) or ($id2==2) or ($id2==3) or ($id2==4) or ($id2==5) or($id2==6) or ($id2==7) or ($id2==8) or ($id2==9) or ($id2==10) or ($id2==11) or ($id2==12) or ($id2==13) or ($id2==14) or ($id2==15) or ($id2==16) or ($id2==17) or ($id2==18) or ($id2==19) or ($id2==20) or ($id2==21) or ($id2==22) or ($id2==23) or ($id2==24) or ($id2==25) or ($id2==26) or ($id2==27) or ($id2==28) or ($id2==29) or ($id2==30) or ($id2==31) or ($id2==32) or ($id2==33)) {
    echo "<li><a href=\"section.php?id=$id2\">$jmeno</a></li>\n";
  }
}

echo "</ul></div>\n</div>\n";



/* --- boxy --- */

$vysledek = mysql_query("select pozice, head, body from boxy where strana = 0 order by pozice asc",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $hd = $row["head"];
  $bd = $row["body"]; 
  
box($hd, $bd);
}


 
$vysledek = mysql_query("select pozice, head, body from boxy where strana = 1 order by pozice asc",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $hd = $row["head"];
  $bd = $row["body"]; 
  
box($hd, $bd);
}
?>
      </div>
    </div>
  </div>
</div>

</body>
</html>
