

<?php

header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");

//$postdata='{"fce":"loadDict","ps":[0,20]}';

$request = json_decode($postdata);

$fce = $request->fce;
$itms = $request->itms;

echo("fce:".$fce);

   
    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");



$sent=pg_prepare($pg,"saveFix","UPDATE pm_vocab SET structure=$1, posb=$2, chng=TRUE WHERE id=$3");
 
	$result=array();
	

$count=0;

foreach($itms as $i)
{
$snt=pg_execute($pg,$fce,array($i->s,$i->posb,$i->strid));	

if($snt)
{
	$count++;
}

}


echo(json_encode(array("rsl"=>$count. " rows updated")));
	

	

?>
