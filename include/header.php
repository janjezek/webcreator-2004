<?php
echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";
include "include/connect.php";

/* --- definice funkcí --- */

function cr_head($sitename, $title) {
include "include/connect.php";
?>
<!doctype html public "-//w3c//dtd xhtml 1.1//en"
                      "http://www.w3.org/tr/xhtml11/dtd/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>  
    <meta http-equiv="content-type" content="text/html; charset=windows-1250"/>
    <meta http-equiv="content-language" content="cs"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="expires" content="-1"/>

    <meta name="robots" content="index,follow"/>
    <meta name="googlebot" content="index,follow,snippet,archive"/>
    <meta name="description" content="<?php echo $desc;?>"/>
    <meta name="keywords" content="<?php echo "$keyw";?>"/>

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="home" href="<?php echo $linkh;?>"/>
    <link rel="search" href="<?php echo $linkh;?>/search.php"/>
    <link rel="stylesheet" href="include/style.css" media="screen,projection" type="text/css"/>

    <title><?php echo "$sitename - $title";?></title>
  </head>

  <body>
    <div id="palma">
      <div id="padding">
        <h1 id="header"></h1>
        <div id="bottom">
          <div id="bottom1"></div>
          <div id="bottom2"></div>
          <div id="bottom3">
            <div id="search">
              <form action="search.php" method="get">
                <input type="text" name="id" size="20"/>
                <input type="submit" value="Ok"/>    
              </form>
            </div>
          </div>
        </div>
      
        <div id="content">
<?php
include "include/connect.php";

?>
 
  <div id="obsah">
    <!-- prostřední sloupec -->   
<?php
}

function clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx) {

  echo "<p class=\"clanek-title\"><a href=\"article.php?id=$id2\" class=\"link-title\">$nadpis</a></p>";
  echo "<p class=\"perex\">$perex</p>";
  echo "<div class=\"clanek-paticka\"><img src=\"./images/komentaru.gif\" /> <a href=\"comment.php?id=$id2\" class=\"link-komentaru\">$comx</a> | <img src=\"./images/vydano.gif\" /> $datum | Rubrika: <a href=\"section.php?id=$r_id\" class=\"link-rubrika\">$rubrika</a></div>";// | <a href=\"author.php?id=$a_id\">$jmeno</a>";
}

function box($head, $body) {
  echo "<h2 class=\"title\">$head</h2>\n";
	echo "<div class=\"box\">\n";
	echo $body;
  echo "</div>\n";
}
?>
