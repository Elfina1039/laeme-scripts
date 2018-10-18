

<?php

header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");

//$postdata='{"t":4}';

$request = json_decode($postdata);

$t = $request->t;
$lit = $request->lit;

$t=8;
$lit="ᵹ";


//echo("fce:".$fce);

   
    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");



//$dict=pg_prepare($pg,"loadLits","SELECT char, array_agg(p.strid||'-'||pos) AS lst FROM positions p
//INNER JOIN pm_corpus c ON p.tag=c.oid
//WHERE text=$1
//GROUP BY char 
//");

$dict=pg_prepare($pg,"loadAlts","SELECT strid::text||'-'||pos::text AS slot,  '[' || regexp_replace(regexp_replace(lst, '[\(]','[','g'),'\)',']','g') || ']' as lst, text FROM slots WHERE text!=$1 AND strid::text||'-'||pos::text IN
(SELECT strid::text||'-'||pos::text FROM slots WHERE text=$1 AND lst SIMILAR TO $2)");

$experiment=pg_prepare($pg,"loadExp","SELECT strid::text||'-'||pos::text AS slot,  '[' || regexp_replace(regexp_replace(lst, '[\(]','[','g'),'\)',']','g') || ']' as lst, text FROM slots WHERE  strid::text||'-'||pos::text IN
(SELECT strid::text||'-'||pos::text FROM slots WHERE  lst SIMILAR TO $1)
GROUP BY slot, lst, text");





$result=array();
$rgx='\("'.$lit.'",[0-9]{1,4}\)';

	
$snt=pg_execute($pg,"loadAlts",array($t,$rgx));	
//$snt=pg_execute($pg,"loadExp",array($rgx));	

$arr=pg_fetch_array($snt);




while(is_array($arr))
{
    
  $lst=json_decode($arr["lst"]);
$rps="";
foreach($lst as $l)
{
    $rps.="-".$l[0];
}
  
array_push($result,array("slot"=>$arr["slot"],"text"=>$arr["text"], "lst"=>$lst, "rps"=>$rps));
	
$arr=pg_fetch_array($snt);
	
}


echo(json_encode($result));
	

	

?>
