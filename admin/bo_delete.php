<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání boxu</h1>\n";

/* --- zjištìní práv uživatele --- */

if ($_data["prava"] == "1") {

/* --- zjištìní pøítomnosti promìnné $id --- */

  if (isset($_GET["id"])) {  
  
    $id = $_GET["id"];
    $vysledek = mysql_query("select id from boxy where id = '$id'",$db);
    $odp_1 = mysql_num_rows($vysledek);
    
/* --- kontrola správnosti parametru ID --- */

    if ($odp_1 == "1") {
    
      $sql = "delete from boxy where id = $id";
      $result = mysql_query($sql);  

/* --- chybová hlášení --- */
    
      if (!$result) {
        alert2("Box nebyl smazán z databáze!");
      }    
      alert("Box byl úspìšnì smazán z databáze.");
      
    } else {
      alert2("Požadavek nelze provést! Je stanoven chybný parametr ID!");
    }
        
  } else {
    alert2("Požadavek nelze provést! Není stanoven parametr ID!");
  }  
  
} else {
  alert2("Neoprávnìný pøístup! Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>