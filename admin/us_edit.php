<?php
include "include/header.php";
?>

<h1>Administrace &gt; �prava u�ivatele</h1>

<?php
if ($_data["prava"] == "1") {

if(isset($_POST["update"]))
{
  $sql = "update autori set login = '$login', heslo = '$heslo', jmeno = '$jmeno', email = '$email', prava = '$pozic', informace = '$informace' where id = $id";
  $result = mysql_query($sql);
  if (!$result) {
  alert("U�ivatelovy �daje nebyly upraveny!");;  
  }
  alert("U�ivatelovy �daje byly �sp�n� opraveny.");  
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
          echo "<option value=\"1\">Administr�tor</option>\n<option value=\"0\">Redaktor</option>\n";
        } else {
          echo "<option value=\"0\">Redaktor</option>\n<option value=\"1\">Administr�tor</option>\n";
        }
        ?>         
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow["id"]?>"/>
        P�ihla�ovac� jm�no: 
      </td>
      <td>
        <input type="text" name="login" size="40" value="<?php echo $myrow["login"]?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Heslo (min: 4 znaky max: 20 znak�): 
      </td>
      <td>
        <input type="text" name="heslo" size="40" value="<?php echo $myrow["heslo"]?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Nick (jm�no): 
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
       Napi�te n�co o sob�:
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
  alert("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>