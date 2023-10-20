<?php
include "include/header.php";
?>

<h1>Administrace &gt; Pøidat uživatele</h1>

<?php
if ($_data["prava"] == "1") {

if(isset($_POST["update"]))
{
  $sql = "insert into autori values ('', '$login', '$heslo', '$jmeno', '$email', '$pozic', '$informace')";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Uživatel nebyl pøidán!");;  
  }
  alert("Uživatel byl úspìšnì pøidán.");  
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
          <option value="1">Administrátor</option>
          <option value="0">Redaktor</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Pøihlašovací jméno:
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
        Nick (Jméno): 
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
        Napište nìco o sobì:
      </td>
      <td>
        <textarea name="informace" rows="10" cols="70"></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Vložit"/>
  </form>
<?php

}
 else {
  alert("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>