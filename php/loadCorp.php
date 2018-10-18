

<?php

header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");

//$postdata='{"fce":"loadDict","ps":[0,20]}';

$request = json_decode($postdata);

$fce = $request->fce;
$ps = $request->ps;

//echo("fce:".$fce);

   
    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");



$dict=pg_prepare($pg,"loadDict","SELECT nl.lexel, nl.grammel,nl.form, str.structure, posb, count(*), str.strid FROM pm_corpus nl 
						INNER JOIN (SELECT lexel, grammel, structure,posb, id AS strid FROM pm_vocab WHERE structure IS NOT NULL AND structure!='' )  AS str
						ON str.strid=nl.strid 
                     WHERE  nl.analysis IS NULL OR nl.analysis=''
                     AND nl.form NOT SIMILAR TO '%[~\[&^/]%'
						
GROUP BY nl.lexel, nl.grammel,nl.form,structure,posb,str.strid ORDER BY grammel,lexel, str.strid DESC OFFSET $1 LIMIT $2");
//WHERE  nl.analysis IS NULL OR nl.analysis=''
// AND nl.form NOT SIMILAR TO '%[~\[&^/]%'

$poss=pg_prepare($pg,"loadPoss","SELECT olid AS oid, analysis, strid FROM pm_corpus 
	WHERE analysis IS NOT NULL AND analysis!='' AND olid NOT IN (SELECT tag FROM positions GROUP BY tag) OFFSET $1 LIMIT $2");


$forms=pg_prepare($pg,"loadForms","SELECT form FROM pm_corpus WHERE lexel=$1 AND grammel=$2 GROUP BY form");
 
	$result=array();
	

	global $pg,$result;


$snt=pg_execute($pg,$fce,$ps);	


$arr=pg_fetch_array($snt);


while(is_array($arr))
{

switch($fce)
{
	case "loadDict": array_push($result,array("strid"=>$arr["strid"],"posb"=>$arr["posb"],"l"=>$arr["lexel"],"g"=>$arr["grammel"],"f"=>$arr["form"],"s"=>$arr["structure"],"suggs"=>array("status"=>"st"))); break;
	
	case "loadForms": array_push($result,array("f"=>$arr["form"])); break;
	
	case "loadPoss": array_push($result,array("id"=>$arr["oid"],"poss"=>$arr["analysis"], "strid"=>$arr["strid"])); break;
}


	
$arr=pg_fetch_array($snt);
	
}

echo(json_encode($result));
	

	

?>
