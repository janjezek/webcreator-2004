<?php
include "include/header.php";
?>

<h1>Administrace &gt; Rubriky</h1>

<?php
if ($_data["prava"] == "1") {

if(isset($_GET["delete"]))
{
  $id = $_GET["id"];
  
  $sql = "delete from rubriky where id = $id";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Rubrika nebyla smaz�na z datab�ze!");
  }
  alert("Rubrika byla �sp�n� smaz�na z datab�ze.");
}

if(isset($_POST["change"]))
{
  $id = $_POST["id"];

  $sql = "update rubriky set rubrika = '$rubrika' where id = $id";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Rubrika nebyla upravena v datab�zi!");
  }
  alert("Rubrika byla �sp�n� upravena v datab�zi.");
}

if(isset($_POST["submit"]))
{
  $rubrika = $_POST["rubrika"];

  $sql = "insert into rubriky (rubrika) values ('$rubrika')";
  $result = mysql_query($sql);
  if (!$result) {
  alert("Rubrika nebyla ulo�ena v datab�zi!");
  }
  alert("Rubrika byla �sp�n� ulo�ena v datab�zi.");
}

?>

<form method="post" action="cl_sekce.php">

  <table cellspacing="0" cellpadding="0">
    <tr>
      <td style="width: 50px">
        N�zev:
      </td>
      <td>
      <?
      if (isset($_GET["op"])) {
          $id = $_GET["id"];
 
          $result = mysql_query("select * from rubriky where id = $id",$db);
          $row = mysql_fetch_array($result);
          
          $id = $row["id"];
          $rubrika = $row["rubrika"];
          
          echo "<input type=\"text\" name=\"rubrika\" size=\"35\" value=\"$rubrika\"/>\n<input type=\"hidden\" name=\"id\" value=\"$id\"/>\n</td>\n</tr>\n</table>\n<input type=\"submit\" name=\"change\" value=\"Upravit\"/>\n</form>";
    
      } else {
          echo "<input type=\"text\" name=\"rubrika\" size=\"35\"/>\n</td>\n</tr>\n</table>\n<input type=\"submit\" name=\"submit\" value=\"P�idat\"/>\n</form>";
      }

$res = mysql_query("select id, rubrika from rubriky order by rubrika",$db);

echo "<br/><table>";

while ($row2 = mysql_fetch_array($res)) {
  $id2 = $row2["id"];
  $jmeno = $row2["rubrika"];
  
  echo "<tr><td style=\"width: 200px\">$jmeno</td><td><a href=\"cl_sekce.php?op=edit&amp;id=$id2\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"cl_sekce.php?id=$id2&amp;delete\" onclick=\"return confirm('Opravdu chcete smazat tuto rubriku?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td></tr>\n";
}

echo "</table>";

} else {
  alert("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>