<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;}
.vyskyt:hover{width:20px; height:20px;z-index:100}

</style>

<script src="js/jquery.js"></script>

</head>

<body>


<?php

 header("Content-Type: text/html; charset=UTF-8");
      $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$v = $_GET["v"];
$r = $_GET["r"];

 echo("<img class=mapka src=mapy/mapka.png>"); 
   echo("<div class=mapka>");

//$tab=pg_prepare($pg,"shoda", "SELECT text, count(text), sum(freq)  FROM laeme_searches s
 //LEFT OUTER JOIN laeme_mymaps m ON s.id=m.radek  WHERE s.verze=$1  GROUP BY text ORDER BY count(*) desc");
 
 //$tabk=pg_prepare($pg,"shodak", "SELECT text, count(text), sum(freq)  FROM laeme_searches s
 //LEFT OUTER JOIN laeme_mymaps m ON s.id=m.radek  WHERE s.verze=$1 AND s.rozdil=$2  GROUP BY text ORDER BY count(*) desc");  
 
 $dtz=pg_prepare($pg,"cmap", "SELECT c.text, count(c.text) AS count FROM
(SELECT lexel,form FROM zaznamy_m WHERE pattern=$1 AND version=$2) AS z
INNER JOIN
(SELECT text,lexel,form FROM new_laeme) AS c
ON c.lexel SIMILAR TO z.lexel AND c.form SIMILAR TO z.form GROUP BY c.text");

$dtz2=pg_prepare($pg,"dlouhy","SELECT c.text, count(c.text), c.kryti FROM
(SELECT lexel,form FROM zaznamy_m WHERE pattern='EvA' AND version='A') AS z
INNER JOIN
(SELECT text AS text,lexel,form,sq.kryti AS kryti FROM new_laeme nl 
    INNER JOIN 
    (SELECT lexel AS l,text AS txt, count(*) AS kryti FROM new_laeme GROUP BY lexel,text) AS sq 
       ON nl.lexel=sq.l) AS c
ON c.lexel SIMILAR TO z.lexel AND c.form SIMILAR TO z.form GROUP BY c.text,c.kryti");


 $dotaz = pg_execute($pg,"cmap",array("EvA","E"));
 $d = pg_fetch_array($dotaz); 

  
  

   include("grid.php");
      include("wcounts.php");
        include("datings_simple.php");

   

while(is_array($d))
{

 $ipm = round(($d["count"]/($whash[$d["text"]]/4000)),1);
 $x = ($hash[$d["text"]]["x"]*1.5)-75;
$y = ($hash[$d["text"]]["y"]*1.5)-75;



if($d["text"]==5 || $d["text"]==65)
{
$x=$x-12;
}

if($d["text"]==2000 || $d["text"]==303)
{
$y=$y-12;
}

$alpha = round($ipm/20,1)  ;

if($alpa>1)
{
$alpha=1;
}

    
 $klicove=array(4,5,6,7,8,9,10,142,158,291,65,1200,184,1100); 
 
 $barvy[4]="blue"; 
 $barvy[5]="blue"; 
 $barvy[6]="blue"; 
 $barvy[7]="blue"; 
 $barvy[8]="blue"; 
 $barvy[9]="blue"; 
 $barvy[10]="orange"; 
 $barvy[9]="yellow"; 
 $barvy[142]="green"; 
 $barvy[291]="green"; 
 $barvy[158]="orange";
 $barvy[65]="purple"; 
 $barvy[1200]="teal"; 
 $barvy[184]="red";  
 
 if(in_array($d["text"],$klicove))
{
$barva=$barvy[$d["text"]];
}  
else
{
$barva="black";
}



echo("<a href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$d["text"].">
<p class=vyskyt style='opacity:$alpha; left:".$x."px; bottom:".$y."px; background-color:".$barva."' title=".$dhash[$d["text"]].">".$ipm."</p></a>");
 $d = pg_fetch_array($dotaz);
 }
  
      

echo("</div>");      

 $data=array_unique($dhash);

echo("<div style='position:absolute; left:0;top:900px; background-color:orange'>"); 
 foreach($data as $d)
 {
 echo("<input type=checkbox checked  value=$d class=stoleti id=cb$d>".$d."  ");
 }
 echo("</div>");
 
?>


<script>
         $(".stoleti").click(function(){

$("[title="+$(this).val()+"]").toggle();

});
</script>
</body>
</html>