<?php

 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$q=$_GET["q"];

$dotaz=pg_prepare($pg, "formy", "SELECT form, count(form) AS freq FROM new_laeme WHERE lexel=$1 GROUP BY form ORDER BY freq desc");

$proved = pg_execute($pg, "formy", array($q));

$vsl=pg_fetch_array($proved);

  while(is_array($vsl))
   {
   echo($vsl["form"]." (".$vsl["freq"].")<br>");

       
  $vsl=pg_fetch_array($proved);
   }




?>
