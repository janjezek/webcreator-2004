<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání èlánku</h1>\n";

$res = mysql_query("select id_autor from clanky where id = $id",$db);
$row = mysql_fetch_array($res);

if ($row["id_autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from clanky where id = $id";
$result = mysql_query($sql);
if (!$result) {
alert("Èlánek nebyl smazán z databáze!");
} else {
alert("Èlánek byl úspìšnì smazán z databáze.");
}

} else {
  alert("Neoprávnìný pøístup!<br/>Smazat mùžete pouze své vlastní èlánky!");
}

include "include/footer.php";
?>