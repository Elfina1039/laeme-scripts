

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



$sent=pg_prepare($pg,"saveAnalysis","UPDATE pm_corpus SET analysis=$1 WHERE lexel=$2 AND grammel=$3 AND form=$4");
 
	$result=array();
	

$count=0;

foreach($itms as $i)
{
$snt=pg_execute($pg,$fce,array($i->suggs->ok[0],$i->l,$i->g,$i->f));	

if($snt)
{
	$count++;
}

}


echo(json_encode(array("rsl"=>$count. " rows updated")));
	

	

?>
