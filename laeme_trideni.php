<?php

 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=pgsql port=5432 dbname=hry.delfiin.net user=hry.delfiin.net password=Jiriste.1039";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$vysledky=pg_prepare($pg,"mapy", "SELECT * FROM laeme_searches  ORDER BY nazev, verze ");
      $hs=pg_execute($pg,"mapy", array());
      
$ms = pg_fetch_array($hs);

echo("<form name=trideni method=POST action=skupiny.php><table>");

while(is_array($ms))
{
if($ms["id"]<=26)
{
$prip = ".png";
}
else
{
$prip = ".PNG";
}
echo("<tr><td>".$ms["nazev"]."<br><img src=mapy/".$ms["verze"]."_".$ms["forma"].$prip.">
        <input type=text name=skupina[]><input type=hidden value name=cislo[]=".$ms["id"].">");
  $ms = pg_fetch_array($hs);
echo("<td><img src=mapy/".$ms["verze"]."_".$ms["forma"].$prip."><input type=text name=skupina[]><input type=hidden value name=cislo[]=".$ms["id"].">");
  $ms = pg_fetch_array($hs);
}      
  
  echo("</form>");    

?>