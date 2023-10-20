<?php
include "include/header.php";
?>

<h1>Administrace &gt; Schválit novinky</h1>

<?php
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sql = "update novinky set stav = 'v' where id = $id";
  $result = mysql_query($sql);

  if (!$result) {
  alert2("Novinka nebyla schválena!");
  } else {
  alert("Novinka byla úspìšnì schválena.");
  }
}

$pocet = "10";

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysql_query("select id from novinky where stav = 'n'");

$vysledek = mysql_query("select n.*, a.jmeno from novinky n, autori a where n.autor = a.id and stav = 'n'order by n.datum desc limit $zaznam, $pocet",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $id = $row["id"];
  $datum = $row["datum"];
  $titulek = $row["titulek"];
  $novinka = $row["novinka"];
  $jmeno = $row["jmeno"];  

  echo "<div class=\"vp_clanek\">\n<div class=\"vp_nadpis\">$titulek <span class=\"vp_other\">(autor $jmeno, vloženo $datum)</span></div>\n<div class=\"vp_perex\">$novinka</div>\n<div class=\"vp_odkazy\"><a href=\"ne_schval.php?id=$id\"><img src=\"icons/pass.gif\" alt=\"Schválit\"/> Schválit</a>, <a href=\"ne_edit.php?id=$id\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"ne_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tuto novinku?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></div>\n</div>\n";
}

include "listovani.php";
include "include/footer.php";
?>