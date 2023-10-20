<?php
include "include/header.php";
?>

<h1>Administrace &gt; Úprava èlánku</h1>

<?php
$res = mysql_query("select id_autor from clanky where id = $id",$db);
$row2 = mysql_fetch_array($res);

if ($row2["id_autor"] == $_id or $_data["prava"] == "1") {

if(isset($_POST["update"]))
{
  $id_autor = $_POST["id_autor"];
  $id_rubrika = $_POST["id_rubrika"];
  $nadpis = $_POST["nadpis"];
  $perex = $_POST["perex"];
  $obsah = $_POST["obsah"];

  if ($_data["prava"] == "1")
  {
  $stav = $_POST["stav"];
  $mesic = $_POST["mesic"];
  $den = $_POST["den"];
  $rok = $_POST["rok"];
  
  $datum = mktime(0,0,0,$mesic,$den,$rok);
  
  $sql = "update clanky set id_autor = '$id_autor', id_rubrika = '$id_rubrika', datum = '$datum', nadpis = '$nadpis', perex = '$perex', obsah = '$obsah', stav = '$stav' where id = $id";
  } else {    
  $sql = "update clanky set id_autor = '$id_autor', id_rubrika = '$id_rubrika', nadpis = '$nadpis', perex = '$perex', obsah = '$obsah' where id = $id";
  }
  
  $result = mysql_query($sql);
  if (!$result) {
  alert("Èlánek nebyl upraven!");
  }
  alert("Èlánek byl úspìšnì opraven.");
}
else 
{
  $result = mysql_query("select c.*, a.jmeno from clanky c, autori a where c.id = $id and c.id_autor = a.id",$db);
  $myrow2 = mysql_fetch_array($result);
?>
  <form method="post" action="cl_edit.php">

  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>   
        <input type="hidden" name="id_autor" value="<?php echo $myrow2["id_autor"]?>"/>   
        Autor: 
      </td>
      <td>
        <?php
        echo $myrow2["jmeno"];            
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow2["id"]?>"/>
        Název: 
      </td>
      <td>
        <input type="text" name="nadpis" size="70" value="<?php echo $myrow2["nadpis"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Sekce:
      </td>
      <td>
    <?
    echo "<select name=\"id_rubrika\">\n";
    
    $res2 = mysql_query("select id, rubrika from rubriky order by rubrika",$db);
    
    while ($row = mysql_fetch_array($res2)) {
    $section = $myrow2["id_rubrika"];
    $id2 = $row["id"];
    $jmeno = $row["rubrika"];    

    echo "<option value=\"$id2\"";
    if ($section == $id2)
      echo " selected=\"selected\"";
    echo ">$jmeno</option>\n";
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
        <textarea name="perex" rows="5" cols="70"><?php echo $myrow2["perex"]?></textarea>
      </td>
    </tr>
    <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="obsah" rows="20" cols="70"><?php echo $myrow2["obsah"]?></textarea>
      </td>
    </tr>
  </table>

  <?php
  if ($_data["prava"] == "1") {
  ?>
  
  <br/>
  <div class="link">
    <span style="font-weight: bold">Admin menu</span>
  </div>
  
  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Vydat:
      </td>
      <td>
        <select name="stav">
          <option value="v">Ano</option>
          <option value="n">Ne</option>
        </select>
      </td>
    </tr>
        <tr>
      <td>
        Datum: 
      </td>
      <td>
        <select name="den">
          <?
          for ($i=1; $i<=31; $i++)
          {
            echo "<option value=$i";
            $_den = date("d",$myrow2["datum"]);
            if ($_den == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>
        .
        <select name="mesic">
          <?
          for ($i=1; $i<= 12; $i++)
          {
            echo "<option value=$i";
            $_mesic = date("m",$myrow2["datum"]);
            if ($_mesic == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>
        .
        <select name="rok">
          <?
          for ($i=5; $i<= 7; $i++)
          {
            echo "<option value=200$i";
            $_rok = date("Y",$myrow2["datum"]);
            if ($_rok == $i) {
            echo " selected=\"selected\"";
            }
            echo ">200$i</option>\n";
          }
          ?>
        </select>
      </td>
    </tr>
  </table>
  
  <div class="link">
    &nbsp;
  </div>
  
  <?php
  } else {
  echo "<br/>";
  }
  ?>

    <input type="submit" name="update" value="Upravit"/>
  </form>
<?php
}

} else {
  alert("Neoprávnìný pøístup!<br/>Mùžete upravovat pouze své vlastní èlánky!");
}

include "include/footer.php";
?>