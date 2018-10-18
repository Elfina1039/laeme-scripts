

<?php


header("Content-Type: text/html; charset=utf-8");


$txt=$_GET["t"];

 
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$ins=pg_prepare($pg,"loadCorrs","SELECT * FROM demig WHERE text=$1");

$ex=pg_execute($pg,"loadCorrs",array($txt));

  $pl=pg_fetch_array($ex);
   echo('[{"ph":"'.$pl["potestas"].'","gr":"'.$pl["litera"].'"}');
	  $pl=pg_fetch_array($ex);
	
    while(is_array($pl))
   {

   echo(',{"ph":"'.$pl["potestas"].'","gr":"'.$pl["litera"].'"}');

     $pl=pg_fetch_array($ex);
    
    }
	
	echo("]");


?>
