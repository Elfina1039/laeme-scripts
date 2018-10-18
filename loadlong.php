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
   $od=$_GET["od"];
   
   
    echo($ms);
  
   
   load($ms); 
   
 

function load($ms)
{  
 
global $les,$fez,$pg,$od;
$zapis=pg_prepare($pg,"zapis", "INSERT INTO new_laeme (text, lexel, grammel, form) VALUES ($1,$2,$3,$4)");

$texts=array(); 
include ("dicfiles.php");

$corp = file_get_contents("http://archive.ling.ed.ac.uk/ihd/laeme2_scripts/display_tagdataZ.php?fn=".$texts[$ms]);

$corp =strip_tags($corp);



$radky=explode("$",$corp);

//echo(count($radky)."<br>");

$radky=array_slice($radky,$od);
//echo(count($radky)."<br>");


foreach($radky as $r)
{
     
$tri=preg_split("/[_\/\s]/",$r);
//echo($tri[0]."----".$tri[1]." ----- ".$tri[2]."<br>");


//$form=str_replace(array("+","_"),"",strstr($r,"_")) ;
//$lexel=strstr($r,"/",TRUE);
//$grammel=str_replace("/","",strstr(strstr($r,"/"),"_",TRUE));


$doit=pg_execute($pg,"zapis",array($ms,$tri[0],$tri[1],str_replace("+","",$tri[2])));

}

echo("<br>finished");
 
 }
  




?>
