<?php
include "include/header.php";
?>

<h1>Administrace &gt; Seznam box�</h1>

<?php
if ($_data["prava"] == "1") {

$vysledek = mysql_query("select * from boxy order by pozice asc",$db);

while ($row = mysql_fetch_array($vysledek)) {
  $id = $row["id"];
  $pozice = $row["pozice"];
  $head = $row["head"];
  $body = $row["body"]; 

  echo "<div class=\"vp_clanek\">\n<div class=\"vp_nadpis\">$head <span class=\"vp_other\">(pozice $pozice)</span></div>\n<div class=\"vp_perex\">$body</div>\n<div class=\"vp_odkazy\"><a href=\"bo_edit.php?id=$id\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"bo_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento box?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></div>\n</div>\n";
}

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>