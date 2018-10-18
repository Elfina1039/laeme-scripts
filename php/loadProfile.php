

<?php

header("Content-Type: text/html; charset=utf-8");


$postdata = file_get_contents("php://input");

//$postdata='{"t":4}';

$request = json_decode($postdata);

$t = $request->t;

$t=$_GET["t"];


//$t=4;
//echo("fce:".$fce);
//echo($t);
   
    $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);


if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");



//$dict=pg_prepare($pg,"loadLits","SELECT char, array_agg(p.strid||'-'||pos) AS lst FROM positions p
//INNER JOIN pm_corpus c ON p.tag=c.olid
//WHERE text=$1
//GROUP BY char 
//");

$dict=pg_prepare($pg,"loadLits","SELECT  char,count(DISTINCT p.strid) AS tps, count(*) AS cnt FROM positions p
INNER JOIN pm_corpus c ON p.tag=c.oid
WHERE text=$1
GROUP BY char ORDER BY cnt 
");

//$dict=pg_prepare($pg,"loadSlots","SELECT p.strid,lexel,grammel, pos, array_agg(char) AS lst FROM positions p
//INNER JOIN pm_corpus c ON p.tag=c.olid
//WHERE text=$1
//GROUP BY p.strid, lexel, grammel, pos ORDER BY lexel, grammel");

$dict=pg_prepare($pg,"loadSlots","SELECT  text, pos, strid, 
'[' || regexp_replace(regexp_replace(lst, '[\(]','[','g'),'\)',']','g') || ']' as lst
FROM slots WHERE text=$1
");






	$chars=array();
	$slots=array();
	$result=array();
	

//load litterae
	
$snt=pg_execute($pg,"loadLits",array($t));	

$arr=pg_fetch_array($snt);


while(is_array($arr))
{




array_push($chars,array("lit"=>$arr["char"],"total"=>$arr["cnt"], "poss"=>$arr["tps"]));
	
$arr=pg_fetch_array($snt);
	
}

//$combs=array();
//$slots2=array();

//foreach($slots as $s)
//{	
//	if(in_array($s,$combs)==false)
//	{
//		array_push($combs,$s);
//		
//		array_push($slots2,array("slots"=>[key($s)],"lits"=>$s));
//			}
//	}


//load slots

$snt=pg_execute($pg,"loadSlots",array($t));	

$arr=pg_fetch_array($snt);


while(is_array($arr))
{

$slot=$arr["strid"]."-".$arr["pos"];
//$lst=trim($arr["lst"],"{}");

//$lst=explode(",",$lst);

$lst=json_decode($arr["lst"]);





//array_push($slots,array("slot"=>$slot,"l"=>$arr["lexel"],"g"=>$arr["grammel"],"lst"=>$lst));

array_push($slots,array("slot"=>$slot,"lst"=>$lst));

	
$arr=pg_fetch_array($snt);
	
}

$result=array("tid"=>$t,"lits"=>$chars,"slots"=>$slots);

echo(json_encode($result,JSON_UNESCAPED_UNICODE));
	

	

?>
