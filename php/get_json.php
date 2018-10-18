

<?php

header("Content-Type: text/html; charset=utf-8");


    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");




//$forms=pg_prepare($pg,"loadStrid","SELECT lexel, grammel, strid FROM pm_corpus WHERE strid>=2676 GROUP BY lexel, grammel, strid ");
 
 

$forms=pg_prepare($pg,"loadStrid","SELECT c.lexel, c.grammel, c.strid, cat, p.pos FROM pm_corpus c
LEFT JOIN palatalisation p ON  c.strid=p.strid
GROUP BY c.lexel, c.grammel, c.strid, cat, p.pos ");
 
 
 
 
$cnames=array("lexel","grammel","strid","cat"); 

	$result=array();
	


$snt=pg_execute($pg,"loadStrid",array());

//echo("not loaded");	

$arr=pg_fetch_array($snt);


$x=0;

while(is_array($arr))
{
$x++;
$nr=array();

foreach($cnames as $cn)
{
	$nr[$cn]=$arr[$cn];
	//echo($cn.":".$nr);
}

$result[$arr["strid"]."_".$arr["pos"]]=$nr;
    
    if(!isset($result[$arr["strid"]."_"]))
    {
        $nr["cat"]="";
     $result[$arr["strid"]."_"]= $nr;  
    }


	
$arr=pg_fetch_array($snt);
	
}
echo($x."<br>");
echo(json_encode($result));
	

	

?>
