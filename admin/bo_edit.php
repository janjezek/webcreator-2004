<?php
include "include/header.php";
?>

<h1>Administrace &gt; �prava boxu</h1>

<?php
/* --- zji�t�n� pr�v u�ivatele --- */

if ($_data["prava"] == "1") {

  /* --- zji�t�n� p��tomnosti prom�nn� $id --- */

  if (isset($_POST["submit"])) {
  
    if (isset($_POST["id"])) { 

      $id = $_POST["id"];
      $strana = $_POST["strana"];
      $pozice = $_POST["pozice"];
      $head = $_POST["head"];  
      $body = $_POST["body"];

      $sql = "update boxy set strana = '$strana', pozice = '$pozice', head = '$head', body = '$body' where id = $id";
      $result = mysql_query($sql);
    
        /* --- chybov� hl�en� --- */
    
        if (!$result) {
          alert2("Box nebyl upraven v datab�zi!");
        } else {
          alert("Box byl �sp�n� upraven v datab�zi.");
        }
    
    } else {
      alert2("Po�adavek nelze prov�st! Nen� stanoven parametr ID!");
    }
  
  } else {
  
    /* --- zji�t�n� p��tomnosti prom�nn� $id --- */

    if (isset($_GET["id"])) {
  
      $id = $_GET["id"];  
      $result = mysql_query("select * from boxy where id = $id",$db);
      $odp_1 = mysql_num_rows($result);
    
/* --- kontrola spr�vnosti parametru ID --- */

      if ($odp_1 == "1") {
        $myrow2 = mysql_fetch_array($result);
?>

<form method="post" action="bo_edit.php">

<table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td> 
        Strana: 
      </td>
      <td>
        <select name="strana">
          <?php           
            if ($myrow2["strana"] == "0") {
              echo "<option value=\"0\" checked=\"checked\">vlevo</option><option value=\"1\">vpravo</option>";
            } else {
              echo "<option value=\"1\" checked=\"checked\">vpravo</option><option value=\"0\">vlevo</option>";
            }
          ?>
        </select>        
      </td>
    </tr>
    <tr>
      <td>    
        <input type="hidden" name="id" value="<?php echo $myrow2["id"];?>"/>
        Pozice: 
      </td>
      <td>
        <select name="pozice">
          <?
          for ($i=1; $i<= 10; $i++)
          {
            echo "<option value=$i";            
            if ($myrow2["pozice"] == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>        
      </td>
    </tr>
    <tr>
      <td>
        Nadpis: 
      </td>
      <td>
        <input type="text" name="head" value="<?php echo $myrow2["head"];?>" size="70"/>
      </td>
    </tr>
      <tr>
      <td>
        Obsah: 
      </td>
      <td>
        <textarea name="body" rows="5" cols="70"><?php echo $myrow2["body"];?></textarea>        
      </td>
    </tr>
  </table>

<input type="submit" name="submit" value="Ulo�it"/>
</form>

<?php
/* --- chybov� hl�en� --- */
    
      } else {
        alert2("Po�adavek nelze prov�st! Je stanoven chybn� parametr ID!");
      }
  
    } else {
      alert2("Po�adavek nelze prov�st! Nen� stanoven parametr ID!");
    }
  }

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>
