<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$lexel = $_GET["l"]; 
$version = $_GET["v"];

   
  $hledej=pg_prepare($pg,"hledej", "SELECT form, grammel, lexel, verze, count(*) FROM laeme_corpfiles  WHERE lexel=$1 AND verze=$2 GROUP BY form, grammel, lexel, verze");
    
   
  $dotaz = pg_execute($pg,"hledej",array($lexel,$version));
  
  $d = pg_fetch_array($dotaz);   
  
  while(is_array($d))
  {
  echo($d["form"]."(".$d["grammel"]."): ".$d["count"]."<br>");
  
  $d = pg_fetch_array($dotaz);
  
  } 
  



?>
