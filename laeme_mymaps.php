<html>
<head>


<link rel=stylesheet href=atlas.css type=text/css media=screen>

</head>

<body>

<h1>Related texts</h1>
<div id=leva>
<h4>text id : number of identical forms/word count (ratio f/wc)</h4>
<p>
Hover over the number of the text to show it on the map. <br>
Click it to get information on the manuscript.
</p>


<?php
 header("Content-Type: text/html; charset=UTF-8");

   $c="host=pgsql port=5432 dbname=hry.delfiin.net user=hry.delfiin.net password=Jiriste.1039";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

include("wcounts.php");

$akce = $_GET["a"];
$version = $_GET["v"];  
$flimit = $_GET["f"];
$plimit = $_GET["p"];

if(empty($flimit))
{
$flimit=0;
}

if(empty($plimit))
{
$plimit=0;
}

 
$tab=pg_prepare($pg,"shoda", "SELECT text, count(text) FROM laeme_searches s
 LEFT OUTER JOIN laeme_mymaps m ON s.id=m.radek  WHERE s.verze=$1 AND m.freq>=$2  GROUP BY text ORDER BY count(*) desc");
 
 $vycet=pg_prepare($pg,"vycet", "SELECT s.forma, m.text FROM laeme_searches s
 LEFT OUTER JOIN laeme_mymaps m ON s.id=m.radek  WHERE m.text=$1 AND s.verze=$2  GROUP BY m.text, s.forma ORDER BY s.forma");

$lexely=pg_prepare($pg,"lexely", "SELECT lexel FROM laeme_corpfiles WHERE verze=$1  GROUP BY lexel");
$formy=pg_prepare($pg,"formy", "SELECT form FROM laeme_corpfiles WHERE verze=$1  ");

 $dotaz1 = pg_execute($pg,"lexely",array($version));
   $d1 = pg_fetch_array($dotaz1);
   
    $dotaz2 = pg_execute($pg,"formy",array($version));
   $d2 = pg_fetch_array($dotaz2);
   
   $Ls=spocitej($d1,$dotaz1);
   $Fs=spocitej($d2,$dotaz2);
   
   $pomer = $Fs/$Ls;
   
 
   
   

 $dotaz = pg_execute($pg,"shoda",array($version,$flimit));
  
  $d = pg_fetch_array($dotaz);
  
   while(is_array($d))
  {
  
  $prunik =  round(($d["count"]/$whash[$d["text"]])*1000,2)   ;
  
  $alpha = round($d["count"]/20,2)  ;

 if ($d["text"]>=4 && $d["text"]<=10)
 {
 $barva = "rgba(0,0,255,$alpha)";
 }
 elseif($d["text"]==2001)
 {
 $barva="rgba(255,0,0,$alpha)";
 }
  elseif($d["text"]==2000)
 {
 $barva="rgba(0,255,0,$alpha)";
 }
 else
 {
$barva= "rgba(0,0,0,$alpha)" ;
 }
  
  if($prunik>$plimit)
  {
  echo("<a style='color:white; background-color:$barva' onMouseover='ukaz(".$d["text"].")' href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$d["text"].">".$d["text"]."</a> : ".$d["count"]."/".$whash[$d["text"]]." ($prunik)<br>");
   
   $vyc = pg_execute($pg,"vycet",array($d["text"], $version));
   $vc = pg_fetch_array($vyc);
   
   while(is_array($vc))
   {
   echo ($vc["forma"].", ");
   
   $vc = pg_fetch_array($vyc);
   }
    echo("<hr>");
   
   }
  $d = pg_fetch_array($dotaz);
  
  } 
  
  
  function spocitej($pole, $source)
  {
     $x=0;
  while(is_array($pole))
  {
   $x++;
   
   $pole = pg_fetch_array($source);
  
  
  }
   return $x;
  
  }

?>

<script>

function ukaz(id)
{
    
document.getElementById('iframe').src="http://corpus.delfiin.net/gridload.php?z=1&m="+id;
}

</script>
</div>

<iframe resizeable=true id=iframe src="laeme_cmaps.php?v=<?php  echo($version); ?>" style="position:absolute; top:0; right:0; width:900px; height:900px;">

</iframe>

 </body>
 </html>