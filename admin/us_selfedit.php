<?php
include "include/header.php";
?>

<h1>Administrace &gt; Úprava uživatele</h1>

<?php
if(isset($_POST["update"]))
{
  $login = $_POST["login"];
  $heslo = $_POST["heslo"];
  $jmeno = $_POST["jmeno"];
  $email = $_POST["email"];
  $informace = $_POST["informace"];
 
  $sql = "update autori set login = '$login', heslo = '$heslo', jmeno = '$jmeno', email = '$email', informace = '$informace' where id = $_id";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Uživatelovy údaje nebyly upraveny!");
  }
  alert("Uživatelovy údaje byly úspìšnì opraveny.");
}
else
{
  $result = mysql_query("select * from autori where id = $_id",$db);
  $row = mysql_fetch_array($result);
?>
  <form method="post" action="us_selfedit.php">

  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>        
        Pozice: 
      </td>
      <td>
        <?php
        $prava = $_data["prava"];
        
        if ($prava == "1") {
          $pozice = "Administrátor";
        } else {
          $pozice = "Redaktor";
        }
        echo $pozice;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Nick: 
      </td>
      <td>
        <input type="text" name="login" size="40" value="<?php echo $row["login"];?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Heslo: 
      </td>
      <td>
        <input type="text" name="heslo" size="40" value="<?php echo $row["heslo"];?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Jméno: 
      </td>
      <td>
        <input type="text" name="jmeno" size="40" value="<?php echo $row["jmeno"];?>"/>
      </td>
    </tr>
    <tr>
      <td>        
        Email: 
      </td>
      <td>
        <input type="text" name="email" size="40" value="<?php echo $row["email"];?>"/>
      </td>
    </tr>    
    <tr>
      <td>
        Poznámka:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="40"><?php echo $row["informace"];?></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Upravit"/>
  </form>
<?php
}

include "include/footer.php";
?>