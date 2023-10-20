<?php
include "include/header.php";
/* --- zobrazení komentáøù --- */
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $result = mysql_query("select nadpis from clanky where id = $id",$db);
  $myrowx = mysql_fetch_array($result);    
  $nazev_cl = $myrowx["nadpis"];    
  cr_head($sitename, "Komentáøe k èlánku $nazev_cl");
  
  $result = mysql_query("select id from komentare where id_clanek = $id",$db);
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 != "0") {
    echo "<h2>Komentáøe k èlánku $nazev_cl</h2>\n\n";
    echo "<a href=\"article.php?id=$id\">Návrat k èlánku</a><br/><br/>\n\n";
    $vysledek = mysql_query("select datum, jmeno, predmet, email, text from komentare where id_clanek = $id order by id desc",$db);
    while ($row = mysql_fetch_array($vysledek)) {
      $datum = $row["datum"];
      $jmeno = $row["jmeno"];
      $predmet = $row["predmet"];
      $email = $row["email"]; 
      $text = $row["text"];
      echo " 
<div id=\"clanek\">

<a href=\"maito:$email\"><b> $jmeno </b></a></p>\n><p class=\"perex\">$text</p>\n<div class=\"clanek-paticka\"><b>Datum:</b>$datum <b>Pøedmìt:</b> $predmet</div></div>\n";
    }
  }
}
/* --- funkce na cenzuru sprostých slov --- */
function censor($censored) {
  include "include/badwords.php";
  $cmask = "<i>[cenzurováno]</i>";
  if (is_array($profan)) {
    reset($profan);
    while (list(, $sWord) = each($profan)) {
      if (strstr(strtoupper($censored), strtoupper($sWord))) {
        if (strtoupper($censored)==strtoupper($sWord)) {
          $censored=$cmask;
        } else { 
          $censored = eregi_replace("^$sWord([^a-zA-Z])", "$cmask\\1", $censored);
          $censored = eregi_replace("([^a-zA-Z])$sWord$", "\\1$cmask", $censored);
          while(eregi("([^a-zA-Z])($sWord)([^a-zA-Z])", $censored))
            $censored = eregi_replace("([^a-zA-Z])($sWord)([^a-zA-Z])", "\\1$cmask\\3", $censored);
        }
      }
    }
  }
  return($censored);
}
/* --- pøidání komentáøe a zobrazení komentáøù --- */
if (isset($_POST["id_clanek"])) {   
  $id = $_POST["id_clanek"];
  $jmeno = $_POST["jmeno"];
  $email = $_POST["email"];
  $predmet = $_POST["predmet"];
  $komentar = $_POST["komentar"]; 
  
  if((!$jmeno) || (!$email) || (!$predmet) || (!$komentar)) {
    $result = mysql_query("select nadpis from clanky where id = $id",$db);  
    $myrowx = mysql_fetch_array($result);    
    $nazev_cl = $myrowx["nadpis"];     
  
    cr_head($sitename, "Komentáøe k èlánku $nazev_cl");
    
    echo '<p>Nevyplnil jste nìkteré údaje ve formuláøi:</p><ul>';
    
    if(!$jmeno){
      echo "<li>Chybí jméno!</li>";
    }
    if(!$email){
     echo "<li>Chybí email!</li>";
    }
    if(!$predmet){
      echo "<li>Chybí pøedmìt!</li>";
    }
    if(!$komentar){
      echo "<li>Chybí komentáø!</li>";
    }
    
    echo "</ul>";
  }  else {
  $komentar = htmlspecialchars($komentar); 
  $komentar = censor($komentar);
  
/* --- kontrola správnosti parametru ID --- */       
  
  $result = mysql_query("select nadpis from clanky where id = $id",$db);  
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 == "1") {
  
    $myrowx = mysql_fetch_array($result);    
    $nazev_cl = $myrowx["nadpis"];    
    cr_head($sitename, "Komentáøe k èlánku $nazev_cl");      
    
/* --- vlo?ení komentáøe do databáze --- */
    $datum = date("j. m. Y G:i");
    $sql = "insert into komentare (id, id_clanek, datum, jmeno, predmet, email, text) values ('','$id','$datum','$jmeno','$predmet','$email','$komentar')";
    $result2 = mysql_query($sql);
    
    if (!$result2) {
      echo "<p>Váš komentáø nebyl uložen!</p>";
    } else {     
      echo "<p>Váš komentáø byl uložen!</p>";
    }
  } else {
    echo "<p>Špatné ID!</p>";
  } 
  
  $result = mysql_query("select id from komentare where id_clanek = $id",$db);
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 != "0") {
    echo "<h2>Komentáøe k èlánku $nazev_cl</h2>\n\n";    
    echo "<a href=\"article.php?id=$id\">Návrat k èlánku</a><br/><br/>\n\n";
    $vysledek = mysql_query("select datum, jmeno, predmet, email, text from komentare where id_clanek = $id order by id desc",$db);
    while ($row = mysql_fetch_array($vysledek)) {
      $datum = $row["datum"];
      $jmeno = $row["jmeno"];
      $predmet = $row["predmet"];
      $email = $row["email"]; 
      $text = $row["text"];
      echo "<div id=\"clanek\">

<a href=\"maito:$email\"><b> $jmeno </b></a></p>\n><p class=\"perex\">$text</p>\n<div class=\"clanek-paticka\"><b>Datum:</b>$datum <b>Pøedmìt:</b> $predmet</div></div>\n";
    }  
  }
  }
} 
?>
<h4>Pøidat komentáø</h4>
<form method="post" action="comment.php">
  <input type="hidden" name="id_clanek" value="<?php echo $id;?>"/>
  
  <table class="com4">
    <tr>
      <td>
        Jméno:
      </td>
      <td>
        <input type="text" name="jmeno" size="30" maxlength="15"/>
      </td>
    </tr>
    <tr>
      <td>
        Email:
      </td>
      <td>
        <input type="text" name="email" size="30" value="@"/>
      </td>
    </tr>
    <tr>
      <td>
        Pøedmìt:
      </td>
      <td>
        <input type="text" name="predmet" size="30" maxlength="20"/>
      </td>
    </tr>
    <tr>
      <td>
        Komentáø:
      </td>
      <td>
<textarea name="komentar" rows="5" cols="40" maxlength="1000"></textarea>
      </td>
    </tr>
  </table>
  <input type="submit" name="submit" value="Odeslat"/>
</form>
<?php
include "include/footer.php";
?>
