

<?php


header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");
$radky= json_decode($postdata);

$txt=$radky->data->txt;

 echo($postdata."<br>");

 
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$ins=pg_prepare($pg,"newCorrs","INSERT INTO demig(text,litera,potestas) VALUES ($1,$2,$3)");

foreach($radky->data->corrs as $r)
{

$ph=$r->ph;

	foreach($r->rps as $rp)
	{
	echo($txt.":".$ph." = ".$rp."///");
	
		$ex=pg_execute($pg,"newCorrs",array($txt,$rp,$ph));
	}

	
}



?>
