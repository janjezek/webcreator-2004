<?php
include "include/header.php";
?>

<h1>Administrace &gt; Vložit èlánek</h1>

<?php
if(isset($_POST["submit"]))
{
  $id_rubrika = $_POST["id_rubrika"];
  $nadpis = strip_tags($_POST["nadpis"], '');
  $perex = strip_tags($_POST["perex"], '');
  $obsah = $_POST["obsah"];

  $datum = time();
  $stav = "n";
  $counter = "0";

  $sql = "insert into clanky (id_autor, id_rubrika, datum, counter, nadpis, perex, obsah, stav) VALUES ('$_id', '$id_rubrika', '$datum', '$counter', '$nadpis', '$perex', '$obsah', '$stav')";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Èlánek nebyl uložen v databázi!");
  }
  alert("Èlánek byl úspìšnì uložen v databázi.");
}
?>
<form method="post" action="cl_insert.php">

  <table cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Autor:
      </td>
      <td>
        <?php echo $_data["jmeno"];?>
      </td>
    </tr>
    <tr>
      <td>
        Název:
      </td>
      <td>
        <input type="text" name="nadpis" size="70"/>
      </td>
    </tr>
    <tr>
      <td>
        Sekce:
      </td>
      <td>
    <?
    echo "<select name=\"id_rubrika\">\n";
    
    $res = mysql_query("select id, rubrika from rubriky order by rubrika",$db);
    
    while ($row = mysql_fetch_array($res)) {
    $id = $row["id"];
    $rubrika = $row["rubrika"];

    echo "<option value=\"$id\">$rubrika</option>\n";
    }
    
    echo "</select>\n";
    ?>
      </td>
    </tr>    
    <tr>
      <td>
        Perex:
      </td>
      <td>
        <textarea name="perex" rows="10" cols="70"></textarea>
      </td>
    </tr>
    <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="obsah" rows="20" cols="70"></textarea>
      </td>
    </tr>
  </table>

  <input type="submit" name="submit" value="Vložit"/>
</form>
<?php


include "include/footer.php";
?>