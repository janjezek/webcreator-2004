<?php
include "include/header.php";
?>

<h1>Administrace &gt; P˜idat box</h1>

<?php
if ($_data["prava"] == "1") {

  if (isset($_POST["submit"])) {  
    $strana = $_POST["strana"];
    $pozice = $_POST["pozice"];
    $head = $_POST["head"];
    $body = $_POST["body"]; 

    $sql = "insert into boxy (strana, pozice, head, body) values ('$strana','$pozice','$head','$body')";
    $result = mysql_query($sql);
    
    if (!$result) {
      alert2("Box nebyl ulo˜en v datab˜zi!");
    }      
    alert("Box byl ˜sp˜n˜ ulo˜en v datab˜zi.");  
}
?>

<form method="post" action="bo_insert.php">

  <table cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Strana:
      </td>
      <td>
        <select name="strana">
          <option value="0">vlevo</option>
          <option value="1">vpravo</option>
        </select>
      </td>
    </tr>
        <tr>
      <td>
        Pozice:
      </td>
      <td>
        <select name="pozice">
          <?
          for ($i=1; $i<= 10; $i++)
          {
            echo "<option value=\"$i\">$i</option>\n";
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
        <input type="text" name="head" size="70"/>
      </td>
    </tr>
    <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="body" rows="5" cols="70"></textarea>
      </td>
    </tr>
  </table>

<input type="submit" name="submit" value="Ulo˜it"/>
</form>

<?php
} else {
  alert2("Neopr˜vn˜n˜ p˜˜stup! Do t˜to sekce maj˜ p˜˜stup jen administr˜to˜i!");
}

include "include/footer.php";
?>
