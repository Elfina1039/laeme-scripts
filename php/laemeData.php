

<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

//$request = json_decode('{"fce":"stridForms","ps":[5,11]}');

$fce = $request->fce;
$ps = $request->ps;

//echo("ps: ".$ps."<br>");


$vsl=call_user_func($fce,$ps);


   

 // $hledejg=pg_prepare($pg,"hledejg", "SELECT form, grammel, text,  count(*) FROM new_laeme  WHERE grammel=$1 AND text=$2 GROUP BY form, grammel, text");
 
   function stridForms($ps)
  {
global $pg;
	
	//echo("function called<br>");
	
  $hledej=pg_prepare($pg,"stridForms", "SELECT form, count(form) AS cnt FROM pm_corpus WHERE text=$1 AND strid=$2 GROUP BY form");

  $dotaz = pg_execute($pg,"stridForms",$ps);
  
   $d = pg_fetch_array($dotaz);
  
  $result=array();
  
   while(is_array($d))
  {
  array_push($result,array("f"=>$d["form"],"cnt"=>$d["cnt"]));
  $d = pg_fetch_array($dotaz);
  
  } 
  
  

 
   echo(json_encode($result));
  }

  
  
  
  function lexelForms($params)
  {
global $pg;
	
	//echo("function called<br>");
	
$grammel=$params->gr;
$lexel=$params->lx;	
$txts=$params->txts;		
	
	

  if(empty($grammel))
  {
  $grammel="%";
  }
  
   if(empty($lexel))
  {
  $lexel="%";
  }
  
$vsechny=pg_prepare($pg,"vsechny", "SELECT form, grammel, lexel, count(*) AS count FROM new_laeme  WHERE lexel SIMILAR TO $1 AND grammel SIMILAR TO $2 GROUP BY form, grammel, lexel ORDER BY count DESC");

  $hledej=pg_prepare($pg,"hledej", "SELECT form, grammel, lexel, text,  count(*) AS count FROM new_laeme  WHERE lexel SIMILAR TO $1 AND grammel SIMILAR TO $2 AND text=$3  GROUP BY form, grammel, lexel, text ORDER BY count DESC");

	  if(empty($txts))
  {
  
  $dotaz = pg_execute($pg,"vsechny",array($lexel,$grammel));
    
   $forms=vycet($dotaz);
   
   $result=array("t"=>"all","hits"=>$forms);
   
   echo(json_encode($result));
   
  }
  else
  {
  $result=array();
  
  foreach($txts as $t)
  {
     $dotaz = pg_execute($pg,"hledej",array($lexel,$grammel,$t));
  
  $forms=vycet($dotaz);
  
  array_push($result,array("tid"=>$t,"hits"=>$forms)) ;
  
 
  
  }
   echo(json_encode($result));
  }

  }
  



function vycet($dotaz)
{
//echo("VYCET:<br>");
  $d = pg_fetch_array($dotaz);   
  $result=array();  
	
  while(is_array($d))
  {
  array_push($result,array("l"=>$d["lexel"],"g"=>$d["grammel"],"f"=>$d["form"]));
  $d = pg_fetch_array($dotaz);
  
  } 
  
 // echo(json_encode($result));
  
  return $result;
}

?>
