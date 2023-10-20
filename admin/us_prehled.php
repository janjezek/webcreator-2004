<?php
include "include/header.php";

echo "<h1>Administrace &gt; Pøehled uživatelù</h1>\n";

if ($_data["prava"] == "1") {

$pocet = "10";

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysql_query("select id from autori");

$vysledek  = mysql_query("select id, jmeno, email, informace, prava from autori order by jmeno limit $zaznam, $pocet",$db);

while ($row = mysql_fetch_array($vysledek)) {
$id = $row["id"];
$prava = $row["prava"];
$jmeno = $row["jmeno"];
$email = $row["email"];
$informace = $row["informace"];

if ($prava == "1") {
  $pozice = "Administrátor";
} else {
  $pozice = "Redaktor";
}

echo "<div class=\"vp_clanek\">\n<div class=\"vp_nadpis\">$jmeno <span class=\"vp_other\">($pozice, email <a href=\"mailto:$email\">$email</a>)</span></div>\n<div class=\"vp_perex\">$informace</div>\n<div class=\"vp_odkazy\"><a href=\"us_edit.php?id=$id\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"us_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tohoto uživatele?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></div>\n</div>\n";
}

include "listovani.php";

} else {
  alert("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>