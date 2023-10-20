<?php
include "include/header.php";
?>

<h1>Administrace &gt; Úprava uživatele</h1>

<?php
if ($_data["prava"] == "1") {

if(isset($_POST["update"]))
{
  $sql = "update autori set login = '$login', heslo = '$heslo', jmeno = '$jmeno', email = '$email', prava = '$pozic', informace = '$informace' where id = $id";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Uživatelovy údaje nebyly upraveny!");;  
  }
  alert("Uživatelovy údaje byly úspìšnì opraveny.");  
}
else
{
  $result = mysql_query("select * from autori where id = $id",$db);
  $myrow = mysql_fetch_array($result);
?>
  <form method="post" action="us_edit.php">

  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>        
        Pozice: 
      </td>
      <td>
        <select name="pozic">
        <?php
        $prava = $myrow["prava"];
        
        if ($prava == "1") {
          echo "<option value=\"1\">Administrátor</option>\n<option value=\"0\">Redaktor</option>\n";
        } else {
          echo "<option value=\"0\">Redaktor</option>\n<option value=\"1\">Administrátor</option>\n";
        }
        ?>         
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow["id"]?>"/>
        Pøihlašovací jméno: 
      </td>
      <td>
        <input type="text" name="login" size="40" value="<?php echo $myrow["login"]?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Heslo (min: 4 znaky max: 20 znakù): 
      </td>
      <td>
        <input type="text" name="heslo" size="40" value="<?php echo $myrow["heslo"]?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Nick (jméno): 
      </td>
      <td>
        <input type="text" name="jmeno" size="40" value="<?php echo $myrow["jmeno"]?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Email: 
      </td>
      <td>
        <input type="text" name="email" size="40" value="<?php echo $myrow["email"]?>"/>
      </td>
    </tr>    
    <tr>
      <td>
       Napište nìco o sobì:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="70"><?php echo $myrow["informace"]?></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Upravit"/>
  </form>
<?php
}

} else {
  alert("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>