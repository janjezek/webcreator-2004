<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� u�ivatele</h1>\n";

if ($_data["prava"] == "1") {

$sql = "delete from autori where id = $id";
$result = mysql_query($sql);
if (!$result) {
alert("U�ivatel nebyl smaz�n z datab�ze!");
}
alert("U�ivatel byl �sp�n� smaz�n z datab�ze.");

} else {
  alert("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>