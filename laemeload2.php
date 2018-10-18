<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

   $ms=$_GET["ms"];

$corp = file("txt/".$ms.".txt");

$corp =implode($corp);

$list = explode("$",$corp);

$hash=array();

for($i=0;$i<count($list);$i++)
{
$pole = explode("/",$list[$i]);

$hash[$i]["lexel"]=$pole[0];

$pole2 = explode("_",$pole[1]);

$hash[$i]["grammel"]=$pole2[0];

$pole3 = explode("{",$pole2[1]);

$hash[$i]["form"]=$pole3[0];


array_shift($pole3);

$note=implode($pole3,"{");


$hash[$i]["note"]="{".$note;

$hash[$i]["form"]=str_replace("+","",$hash[$i]["form"]);

 
}
 
  $zapis=pg_prepare($pg,"zapis", "INSERT INTO laeme_corpfiles (verze, lexel, grammel, form, note) VALUES ($1,$2,$3,$4,$5)");
  
 for($i=0;$i<count($hash);$i++)
 {

echo("\$hash[$i]['lexel']='".$hash[$i]['lexel']."';"); 
echo("\$hash[$i]['grammel']='".$hash[$i]['grammel']."';"); 

echo("\$hash[$i]['form']='".$hash[$i]['form']."';<br>");  

 }



?>
