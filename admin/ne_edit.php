<?php
include "include/header.php";
?>

<h1>Administrace &gt; Úprava novinky</h1>

<?php
$res = mysql_query("select autor from novinky where id = $id",$db);
$row2 = mysql_fetch_array($res);

if ($row2["autor"] == $_id or $_data["prava"] == "1") {

if(isset($_POST["submit"]))
{
  $titulek = $_POST["titulek"];
  $id = $_POST["id"];
  $novinka = $_POST["novinka"];

  $sql = "update novinky set titulek = '$titulek', novinka = '$novinka' where id = $id";
  $result = mysql_query($sql);
  if (!$result) {
    alert("Novinka nebyla upravena v databázi!");
  } else {
    alert("Novinka byla úspìšnì upravena v databázi.");
  }
} else {
$result = mysql_query("select n.*, a.jmeno from novinky n, autori a where n.id = $id and n.autor = a.id",$db);
$myrow2 = mysql_fetch_array($result);
?>

<form method="post" action="ne_edit.php">

<table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>    
        <input type="hidden" name="id" value="<?php echo $myrow2["id"];?>"/>
        Autor: 
      </td>
      <td>
        <?php echo $myrow2["jmeno"];?>
      </td>
    </tr>
    <tr>
      <td>
        Vloženo: 
      </td>
      <td>
        <?php echo $myrow2["datum"];?>        
      </td>
    </tr>
    <tr>
      <td>
        Titulek: 
      </td>
      <td>
        <input type="text" name="titulek" value="<?php echo $myrow2["titulek"];?>" size="70"/>
      </td>
    </tr>
      <tr>
      <td>
        Obsah: 
      </td>
      <td>
        <textarea name="novinka" rows="5" cols="70"><?php echo $myrow2["novinka"];?></textarea>        
      </td>
    </tr>
  </table>

<input type="submit" name="submit" value="Uložit"/>
</form>

<?php
}
} else {
  alert("Neoprávnìný pøístup!<br/>Mùžete upravovat pouze své vlastní novinky!");
}

include "include/footer.php";
?>