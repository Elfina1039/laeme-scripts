<style>
td{vertical-align:top}
</style>

<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$grammel = $_GET["gram"]; 
$lexel = $_GET["lex"]; 
$txts = $_GET["t"];




   
  $hledej=pg_prepare($pg,"hledej", "SELECT form, grammel, lexel, text,  count(*) AS count FROM new_laeme  WHERE lexel SIMILAR TO $1 AND grammel SIMILAR TO $2 AND text=$3  GROUP BY form, grammel, lexel, text ORDER BY count DESC");
 // $hledejg=pg_prepare($pg,"hledejg", "SELECT form, grammel, text,  count(*) FROM new_laeme  WHERE grammel=$1 AND text=$2 GROUP BY form, grammel, text");
  
   $vsechny=pg_prepare($pg,"vsechny", "SELECT form, grammel, lexel, count(*) AS count FROM new_laeme  WHERE lexel SIMILAR TO $1 AND grammel SIMILAR TO $2 GROUP BY form, grammel, lexel ORDER BY count DESC");
 
  if(empty($grammel))
  {
  $grammel="%";
  }
  
   if(empty($lexel))
  {
  $lexel="%";
  }
  

echo("<table><tr>");


  if(empty($txts))
  {
  
  $dotaz = pg_execute($pg,"vsechny",array($lexel,$grammel));
    
   vycet($dotaz);
  }
  else
  {
  foreach($txts as $t)
  {
     $dotaz = pg_execute($pg,"hledej",array($lexel,$grammel,$t));
  
   vycet($dotaz);
  
  }
  
  }
  

echo("</table>");

function vycet($dotaz)
{
global $lexel,$grammel;

$rws=0;
  $d = pg_fetch_array($dotaz);   
  
  echo("<td>".$d["text"]."<hr>");
  
  while(is_array($d))
  {
  echo("<li style='list-style-type:none' onClick='location.href=\"my_gridload.php?l=$lexel&g=$grammel&f=".$d["form"]."\"'>".$d["form"]."(".$d["grammel"]."): ".$d["count"]."<br>");
  
  $d = pg_fetch_array($dotaz);
  
  $rws++;
  if($rws>15)
  {
  echo("<td>");
  $rws=0;
  }
  
  } 
}

?>
