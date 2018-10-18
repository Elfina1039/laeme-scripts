<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:9px; height:9px; background-color:black; color:white;font-size:8pt;overflow:hidden;
       border-width:2px; border-color:transparent; border-style:solid;}

.vyskyt:hover{width:25px; height:25px;z-index:100}

</style>

</head>

<body>



<?php


 header("Content-Type: text/html; charset=UTF-8");
     
$c="host=pgsql port=5432 dbname=hry.delfiin.net user=hry.delfiin.net password=Jiriste.1039";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$nactic=pg_prepare($pg,"nactic", "SELECT  D.cd as dfreq, D.text as dtext, L.cl as lfreq,  L.text as ltext
                          FROM (SELECT count(m.text) as cd, m.text FROM laeme_mymaps m LEFT OUTER JOIN
                                      laeme_searches s ON m.radek=s.id WHERE s.verze='D' AND s.rozdil=$1 GROUP BY m.text) D
                              FULL JOIN (SELECT count(m.text) as cl, m.text FROM laeme_mymaps m LEFT OUTER JOIN
                                      laeme_searches s ON m.radek=s.id WHERE s.verze='L' AND s.rozdil=$1 GROUP BY m.text) L
                                       ON D.text=L.text");


 
  $nacti=pg_prepare($pg,"nacti", "SELECT  D.text as dtext, D.freq as dfreq,  L.text as ltext, L.freq as lfreq
                          FROM (SELECT m.text, m.freq FROM laeme_mymaps m LEFT OUTER JOIN
                                      laeme_searches s ON m.radek=s.id WHERE s.verze='D' AND s.nazev=$1) D
                              FULL JOIN (SELECT m.text, m.freq FROM laeme_mymaps m LEFT OUTER JOIN
                                      laeme_searches s ON m.radek=s.id WHERE s.verze='L' AND s.nazev=$1) L
                                       ON D.text=L.text");
  

  

$lexel = $_GET["lexel"];
$rozdil = $_GET["rozdil"];


     include("grid.php");
      include("wcounts.php"); 
      
       echo("<img class=mapka src=mapy/mapka.png>"); 
   echo("<div class=mapka>");
   
   if(!empty($lexel))
   {
    $u=pg_execute($pg, "nacti", array($lexel));
   }
   elseif(!empty($rozdil))
   {
    $u=pg_execute($pg, "nactic", array($rozdil));
   }
   else
   {
   echo("No map has been selected.");
   break;
   }

    
$ms = pg_fetch_array($u);

while(is_array($ms))
  {
  
  $rgb=seda($ms["lfreq"],$ms["dfreq"]);
  
 
  
  $rgb = "rgb(".$rgb.",".$rgb.",".$rgb.")";
  
  if(!empty($ms["dtext"]))
  {
  $cislo = $ms["dtext"];
  }
  else
  {
  $cislo = $ms["ltext"];
  }
  
  
  $x = ($hash[$cislo]["x"]*1.5)-75;
$y = ($hash[$cislo]["y"]*1.5)-75;

if($cislo==5 || $cislo==65)
{
$x=$x-12;
}

if($cislo==2000 || $cislo==303)
{
$y=$y-12;
}


 if (($cislo>=4 && $cislo<=10 ) ||  $cislo==1100 )
 {
 $barva = "blue";
 }
 elseif($cislo==2001)
 {
 $barva="red";
 }
  elseif($cislo==2000)
 {
 $barva="green";
 }
 else
 {
 $barva = "transparent";
 }


echo("<a href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$cislo.">
<p class=vyskyt style='left:".$x."px; bottom:".$y."px; border-color:".$barva.";background-color:".$rgb."'>".$ipm."<br>".$ms["freq"]."</p></a>");

  $ms = pg_fetch_array($u);
  }
 

 
 echo("</div>");
 

 
   echo("</div>");
   
function seda($l, $d)
{
$t=$l+$d;
$bila=$l/($t/100);

$rgb=round(2.55*$bila);
return $rgb;

}

?>


</body>
</html>