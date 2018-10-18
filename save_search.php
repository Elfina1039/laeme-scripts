<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;overflow:hidden;}

.vyskyt:hover{width:25px; height:25px;z-index:100}

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
else
{
echo ("Connected<br>");
}

pg_set_client_encoding($pg, "UNICODE");

$zapis=pg_prepare($pg,"vloz", "INSERT INTO zaznamy_m (lexel,grammel,form,kat,pattern) VALUES ($1,$2,$3,$4,$5)");
 
 if(!$zapis) 
{
echo ("PS does not exist:<br>".$zapis);
}
 
  $l=$_GET["l"];
  $g=$_GET["g"];
  $f=$_GET["f"];
  $s=$_GET["skup"];
  $p=$_GET["patt"];
    


$u=pg_execute($pg, "vloz", array($l,$g,$f,$s,$p));

if(!$u) 
{
echo "An unknown error occured.";
}

echo("<h4>Search saved:</h4>lexel=$l <br> grammel=$g<br>form=$f<br>group=$s");



 
  

?>


</body>
</html>