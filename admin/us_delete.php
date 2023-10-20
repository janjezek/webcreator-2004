<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání uživatele</h1>\n";

if ($_data["prava"] == "1") {

$sql = "delete from autori where id = $id";
$result = mysql_query($sql);
if (!$result) {
alert("Uživatel nebyl smazán z databáze!");
}
alert("Uživatel byl úspìšnì smazán z databáze.");

} else {
  alert("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>