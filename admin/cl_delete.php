<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� �l�nku</h1>\n";

$res = mysql_query("select id_autor from clanky where id = $id",$db);
$row = mysql_fetch_array($res);

if ($row["id_autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from clanky where id = $id";
$result = mysql_query($sql);
if (!$result) {
alert("�l�nek nebyl smaz�n z datab�ze!");
} else {
alert("�l�nek byl �sp�n� smaz�n z datab�ze.");
}

} else {
  alert("Neopr�vn�n� p��stup!<br/>Smazat m��ete pouze sv� vlastn� �l�nky!");
}

include "include/footer.php";
?>