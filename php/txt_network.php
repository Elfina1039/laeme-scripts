

<?php

header("Content-Type: text/html; charset=utf-8");


    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$txt=$_GET["t"];


$forms=pg_prepare($pg,"loadNtw","
SELECT sq.lits, array_agg((sq.strid,sq.pos)) AS slots, sum(sq.cnt) AS freq FROM
(SELECT c.text, p.strid, p.pos, array_agg(DISTINCT char) AS lits, count(char) AS cnt FROM positions p
INNER JOIN pm_corpus c ON p.tag=c.olid
WHERE text=$1
GROUP BY c.text, p.strid, p.pos 

ORDER BY  lits, text) AS sq

GROUP BY sq.lits

");
 
 //HAVING  'o'=ANY(array_agg(DISTINCT char)) 
 

	$result=array();
	$pole=array();


$snt=pg_execute($pg,"loadNtw",array($txt));

//echo("not loaded");	

$arr=pg_fetch_array($snt);



while(is_array($arr))
{

$lst=array();

$lits=explode(",",trim($arr["lits"],"{}"));



$slots=explode("\",\"",trim($arr["slots"],"{}\""));

//echo($slots[0]."-");

foreach($slots as $s)
{
	$spl=explode(",",trim($s,"()"));
	
	array_push($lst,array($spl[0],$spl[1]));
	
	//echo($spl[0]."-".$spl[1]."<br>");
	
}


array_push($result,array("lits"=>$lits,"lst"=>$lst,"cd"=>implode("-",$lits)));

	
$arr=pg_fetch_array($snt);
	
}

echo(json_encode($result));
	

	

?>
