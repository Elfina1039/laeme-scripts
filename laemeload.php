<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


include("hashe3.php");
 
  $zapis=pg_prepare($pg,"zapis", "INSERT INTO laeme_corpfiles (verze, lexel, grammel, form, note) VALUES ($1,$2,$3,$4,$5)");
    $smaz=pg_prepare($pg,"smaz", "DELETE FROM laeme_corpfiles");
  
  
  
 foreach($hash as $h)
 {
 
 $l = $h["lexel"];
 $g = $h["grammel"];
 $f = $h["form"];
 $n = "nic";
 
 
    $vloz=pg_execute($pg,"zapis", array("S",$l,$g,$f,$n));
 
 echo($f."<br>");
 
 }


 //D,L
 //K=Laud Misc
 //A=Arundel
 //T=Trinity
 //V=Vitellius 184
 //O=Ox Bod Additional
 // H=Trinity homilies 1200
 //G= bodley 86, 2002 



?>
