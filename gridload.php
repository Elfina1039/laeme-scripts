<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:600px; height:600px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;}

</style>

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

$vsl = $_POST["vsl"];

if(empty($vsl))
{
echo("<form name=vysledek method=post action=gridload.php>
          <textarea name=vsl></textarea>
          <input type=submit value=load>
          </form>");
          
          
          break;

}

 

$vyskyty = explode("]",$vsl);




$corp = file("txt/lalmegrid.txt");

$hash=array();

for($i=0;$i<count($corp);$i++)
{
  $pole = explode(",",$corp[$i]);
   $pole2 = explode("+",$pole[2]);
   
   $hash[$pole[1]]["x"]=$pole2[0];
   $hash[$pole[1]]["y"]=$pole2[1];
   
  
}
                                 
 echo("<img class=mapka src=txt/mapka.png>");                                
echo("<div class=mapka>");

foreach($vyskyty as $v)
{
$casti = explode("[",$v);

preg_match_all('!\d+!', $casti[0], $matches);


$text = implode("",$matches[0]);
$f=$casti[1];

$x = $hash[$text]["x"]-50;
$y = $hash[$text]["y"]-50;

$alpha = $f/30;


echo("<p class=vyskyt style='left:".$x."px; bottom:".$y."px'>$f</p>");


}

echo("</div>");

?>


</body>
</html>