<?php
include "include/header.php";
/* --- zobrazen� koment��� --- */
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $result = mysql_query("select nadpis from clanky where id = $id",$db);
  $myrowx = mysql_fetch_array($result);    
  $nazev_cl = $myrowx["nadpis"];    
  cr_head($sitename, "Koment��e k �l�nku $nazev_cl");
  
  $result = mysql_query("select id from komentare where id_clanek = $id",$db);
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 != "0") {
    echo "<h2>Koment��e k �l�nku $nazev_cl</h2>\n\n";
    echo "<a href=\"article.php?id=$id\">N�vrat k �l�nku</a><br/><br/>\n\n";
    $vysledek = mysql_query("select datum, jmeno, predmet, email, text from komentare where id_clanek = $id order by id desc",$db);
    while ($row = mysql_fetch_array($vysledek)) {
      $datum = $row["datum"];
      $jmeno = $row["jmeno"];
      $predmet = $row["predmet"];
      $email = $row["email"]; 
      $text = $row["text"];
      echo " 
<div id=\"clanek\">

<a href=\"maito:$email\"><b> $jmeno </b></a></p>\n><p class=\"perex\">$text</p>\n<div class=\"clanek-paticka\"><b>Datum:</b>$datum <b>P�edm�t:</b> $predmet</div></div>\n";
    }
  }
}
/* --- funkce na cenzuru sprost�ch slov --- */
function censor($censored) {
  include "include/badwords.php";
  $cmask = "<i>[cenzurov�no]</i>";
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
/* --- p�id�n� koment��e a zobrazen� koment��� --- */
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
  
    cr_head($sitename, "Koment��e k �l�nku $nazev_cl");
    
    echo '<p>Nevyplnil jste n�kter� �daje ve formul��i:</p><ul>';
    
    if(!$jmeno){
      echo "<li>Chyb� jm�no!</li>";
    }
    if(!$email){
     echo "<li>Chyb� email!</li>";
    }
    if(!$predmet){
      echo "<li>Chyb� p�edm�t!</li>";
    }
    if(!$komentar){
      echo "<li>Chyb� koment��!</li>";
    }
    
    echo "</ul>";
  }  else {
  $komentar = htmlspecialchars($komentar); 
  $komentar = censor($komentar);
  
/* --- kontrola spr�vnosti parametru ID --- */       
  
  $result = mysql_query("select nadpis from clanky where id = $id",$db);  
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 == "1") {
  
    $myrowx = mysql_fetch_array($result);    
    $nazev_cl = $myrowx["nadpis"];    
    cr_head($sitename, "Koment��e k �l�nku $nazev_cl");      
    
/* --- vlo?en� koment��e do datab�ze --- */
    $datum = date("j. m. Y G:i");
    $sql = "insert into komentare (id, id_clanek, datum, jmeno, predmet, email, text) values ('','$id','$datum','$jmeno','$predmet','$email','$komentar')";
    $result2 = mysql_query($sql);
    
    if (!$result2) {
      echo "<p>V� koment�� nebyl ulo�en!</p>";
    } else {     
      echo "<p>V� koment�� byl ulo�en!</p>";
    }
  } else {
    echo "<p>�patn� ID!</p>";
  } 
  
  $result = mysql_query("select id from komentare where id_clanek = $id",$db);
  $odp_1 = mysql_num_rows($result);
    
  if ($odp_1 != "0") {
    echo "<h2>Koment��e k �l�nku $nazev_cl</h2>\n\n";    
    echo "<a href=\"article.php?id=$id\">N�vrat k �l�nku</a><br/><br/>\n\n";
    $vysledek = mysql_query("select datum, jmeno, predmet, email, text from komentare where id_clanek = $id order by id desc",$db);
    while ($row = mysql_fetch_array($vysledek)) {
      $datum = $row["datum"];
      $jmeno = $row["jmeno"];
      $predmet = $row["predmet"];
      $email = $row["email"]; 
      $text = $row["text"];
      echo "<div id=\"clanek\">

<a href=\"maito:$email\"><b> $jmeno </b></a></p>\n><p class=\"perex\">$text</p>\n<div class=\"clanek-paticka\"><b>Datum:</b>$datum <b>P�edm�t:</b> $predmet</div></div>\n";
    }  
  }
  }
} 
?>
<h4>P�idat koment��</h4>
<form method="post" action="comment.php">
  <input type="hidden" name="id_clanek" value="<?php echo $id;?>"/>
  
  <table class="com4">
    <tr>
      <td>
        Jm�no:
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
        P�edm�t:
      </td>
      <td>
        <input type="text" name="predmet" size="30" maxlength="20"/>
      </td>
    </tr>
    <tr>
      <td>
        Koment��:
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
