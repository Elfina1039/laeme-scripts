<?php



$adr="http://www.google.cz/search?" . $_SERVER['QUERY_STRING'];

   $url = $adr;
    $html_select = file_get_contents($url);

$html_select = substr($html_select, 3000);

    echo $html_select;
?>

