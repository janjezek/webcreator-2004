<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� boxu</h1>\n";

/* --- zji�t�n� pr�v u�ivatele --- */

if ($_data["prava"] == "1") {

/* --- zji�t�n� p��tomnosti prom�nn� $id --- */

  if (isset($_GET["id"])) {  
  
    $id = $_GET["id"];
    $vysledek = mysql_query("select id from boxy where id = '$id'",$db);
    $odp_1 = mysql_num_rows($vysledek);
    
/* --- kontrola spr�vnosti parametru ID --- */

    if ($odp_1 == "1") {
    
      $sql = "delete from boxy where id = $id";
      $result = mysql_query($sql);  

/* --- chybov� hl�en� --- */
    
      if (!$result) {
        alert2("Box nebyl smaz�n z datab�ze!");
      }    
      alert("Box byl �sp�n� smaz�n z datab�ze.");
      
    } else {
      alert2("Po�adavek nelze prov�st! Je stanoven chybn� parametr ID!");
    }
        
  } else {
    alert2("Po�adavek nelze prov�st! Nen� stanoven parametr ID!");
  }  
  
} else {
  alert2("Neopr�vn�n� p��stup! Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>