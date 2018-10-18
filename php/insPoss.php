

<?php

header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");

//$postdata='{"fce":"loadDict","ps":[0,20]}';

$request = json_decode($postdata);

$rw = $request->rw;

   
    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");



$sent=pg_prepare($pg,"savePoss","INSERT INTO positions (tag,strid,pos,char) VALUES ($1,$2,$3,$4)");
 
	$result=array();
	

$count=0;

foreach(array_values($rw->lst) as $i=>$r)
{
$snt=pg_execute($pg,"savePoss",array($rw->id,$rw->strid,$i,$r));	

if($snt)
{
	$count++;
}

}


echo(json_encode(array("rsl"=>$count. " rows inserted")));
	

	

?>
