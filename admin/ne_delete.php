<?php
include "include/header.php";
?>

<h1>Administrace &gt; Smaz�n� novinky</h1>

<?php
$result = mysql_query("select autor from novinky where id = $id",$db);
$row = mysql_fetch_array($result);

if ($row["autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from novinky where id = $id";
$res = mysql_query($sql);
if (!$res) {
  alert("Novinka nebyla smaz�na z datab�ze!");
} else {
  alert("Novinka byla �sp�n� smaz�na z datab�ze.");
}

} else {
  alert("Neopr�vn�n� p��stup!<br/>Smazat m��ete pouze sv� vlastn� novinky!");
}

include "include/footer.php";
?>