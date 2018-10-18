<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$ta=$_GET["ta"];
$tb=$_GET["tb"];

shared($ta,$tb);
//shared("D","G");

 function shared($d,$a)
 {
  global $pg;
  $lexely=pg_prepare($pg,"lexely", "SELECT lexel FROM laeme_corpfiles WHERE verze=$1 GROUP BY lexel");
  $formy=pg_prepare($pg,"formy", "SELECT form FROM laeme_corpfiles WHERE verze=$1 AND lexel=$2 GROUP BY form");



   $Alex=array();
  $Dlex=array();



 $lx=pg_execute($pg,"lexely", array($a));  
 $l=pg_fetch_array($lx);
 
 while(is_array($l))
 {
    array_push($Alex,$l["lexel"]);
     $l=pg_fetch_array($lx);
 }
  
  
   $lx=pg_execute($pg,"lexely", array($d));  
 $l=pg_fetch_array($lx);
 
 while(is_array($l))
 {
    array_push($Dlex,$l["lexel"]);
     $l=pg_fetch_array($lx);
 }
  
  $lex=array_intersect($Alex,$Dlex);
  
 $hash=array(); 

echo("<table border=1>");

$shared=0;
  
  
 foreach($lex as $l)
 {
 $Dforms=array();
  $Aforms=array();
 
 $hash[$l]["both"]=array(); 
 $hash[$l]["Donly"]=array();  
   
$fsa=pg_execute($pg,"formy", array($a,$l));  
 $fa=pg_fetch_array($fsa);
 
       while(is_array($fa))
 {
    array_push($Aforms,$fa["form"]);
   
   
      $fa=pg_fetch_array($fsa);
 }
 
 $dsa=pg_execute($pg,"formy", array($d,$l));  
 $da=pg_fetch_array($dsa);
 
       while(is_array($da))
 {
    array_push($Dforms,$da["form"]);
     $da=pg_fetch_array($dsa);
 }
 
 
  $hash[$l]["both"]=array_intersect($Dforms,$Aforms);
   $hash[$l]["Donly"]=array_diff($Dforms,$Aforms);
   $hash[$l]["Aonly"]=array_diff($Aforms,$Dforms);

   if(!empty($hash[$l]["both"]))
   {
   $shared++;
 echo("<tr><td style='background-color:yellow;' colspan=3>".$l."<tr><td style='background-color:green; color:white;'>"
 .vypis($hash[$l]["both"])."<td>".vypis($hash[$l]["Donly"])."<td style='background-color:cyan'>".vypis($hash[$l]["Aonly"]));
   
   }




 }
 
 echo("</table>Shared lexels: ".count($lex)."<br>");
 echo("Shared forms: ".$shared."<br>");
  }

 function vypis($pole)
 {
 $v="F: ";
 foreach($pole as $p)
    {
    $v=$v.", ".$p;
    
    }
 return $v;
 
 }
 
 function nahradit($slovo)
 {
$stare = array("Y", "Z","SS");
$nove   = array("I", "S", "S");
$new = str_replace($stare, $nove, $slovo);

return($new); 
 }



?>
