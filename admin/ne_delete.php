<?php
include "include/header.php";
?>

<h1>Administrace &gt; Smazání novinky</h1>

<?php
$result = mysql_query("select autor from novinky where id = $id",$db);
$row = mysql_fetch_array($result);

if ($row["autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from novinky where id = $id";
$res = mysql_query($sql);
if (!$res) {
  alert("Novinka nebyla smazána z databáze!");
} else {
  alert("Novinka byla úspìšnì smazána z databáze.");
}

} else {
  alert("Neoprávnìný pøístup!<br/>Smazat mùžete pouze své vlastní novinky!");
}

include "include/footer.php";
?>