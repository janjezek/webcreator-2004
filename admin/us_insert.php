<?php
include "include/header.php";
?>

<h1>Administrace &gt; P�idat u�ivatele</h1>

<?php
if ($_data["prava"] == "1") {

if(isset($_POST["update"]))
{
  $sql = "insert into autori values ('', '$login', '$heslo', '$jmeno', '$email', '$pozic', '$informace')";
  $result = mysql_query($sql);
  if (!$result) {
  alert("U�ivatel nebyl p�id�n!");;  
  }
  alert("U�ivatel byl �sp�n� p�id�n.");  
}
?>
  <form method="post" action="us_insert.php">

  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>        
        Pozice: 
      </td>
      <td>
        <select name="pozic">
          <option value="1">Administr�tor</option>
          <option value="0">Redaktor</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        P�ihla�ovac� jm�no:
      </td>
      <td>
        <input type="text" name="login" size="40"/>
      </td>
    </tr>
    <tr>
      <td>        
        Heslo: 
      </td>
      <td>
        <input type="text" name="heslo" size="40"/>
      </td>
    </tr>
    <tr>
      <td>        
        Nick (Jm�no): 
      </td>
      <td>
        <input type="text" name="jmeno" size="40"/>
      </td>
    </tr>
    <tr>
      <td>        
        Email: 
      </td>
      <td>
        <input type="text" name="email" size="40"/>
      </td>
    </tr>    
    <tr>
      <td>
        Napi�te n�co o sob�:
      </td>
      <td>
        <textarea name="informace" rows="10" cols="70"></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Vlo�it"/>
  </form>
<?php

}
 else {
  alert("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>