<?php
include "include/header.php";

echo "<h1>Administrace &gt; Schválené èlánky</h1>\n";

$pocet = "10";
$cas = time();

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysql_query("select id from clanky where stav = 'v' and datum >= $cas");

$vysledek = mysql_query("select c.id,c.nadpis,c.perex,r.rubrika,a.jmeno from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and datum >= $cas order by c.datum desc limit $zaznam, $pocet",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $id = $row["id"];
  $nadpis = $row["nadpis"];
  $perex = $row["perex"];
  $rubrika = $row["rubrika"];
  $jmeno = $row["jmeno"];

  echo "<div class=\"vp_clanek\">\n<div class=\"vp_nadpis\">$nadpis <span class=\"vp_other\">(sekce $rubrika, autor $jmeno)</span></div>\n<div class=\"vp_perex\">$perex</div>\n<div class=\"vp_odkazy\"><a href=\"../cl_preview.php?id=$id\" target=\"new\"><img src=\"icons/preview.gif\" alt=\"Zobrazit\"/> Zobrazit</a>, <a href=\"cl_edit.php?id=$id\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"cl_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento èlánek?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></div>\n</div>\n";
}

include "listovani.php";
include "include/footer.php";
?>