<?php


 header("Content-Type: text/html; charset=UTF-8");
 
     
       $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

    $r = $_GET["r"];
    
  
 
 // $vypiskat=pg_prepare($pg,"vypisk", "SELECT * FROM laeme_searches WHERE rozdil=$1  ORDER BY nazev , verze");
 $vypis=pg_prepare($pg,"vypis", "SELECT lexel,grammel,form,kat,skup FROM zaznamy WHERE kat!='X' GROUP BY lexel,grammel,form,kat,skup ORDER BY kat,lexel ");
 
// $prepis=pg_prepare($pg,"prepis", "UPDATE laeme_searches  SET lexel=nazev WHERE lexel IS NULL");

$szn=pg_execute($pg,"vypis",array());

$sz=pg_fetch_array($szn);



echo("<table><tr><th>Lexel<th>Grammel<th>Form<th>Texts<th>Category");

$i=1;
$kats=array();
$kats["A"]="dev. of ae";
$kats["V"]="voicing";
$kats["H"]="H dropping";
$kats["L"]="elision of L";
$kats["ó"]="dipth EO";
$kats["é"]="dipth. EA";
$kats["O"]="A to O";
$kats["I"]="dipth. IE";
$kats["ý"]="dev. of Y";
$kats["Z"]="voicing (Z)";
$kats["E"]="I vs E";

$kats["F"]="U vs OU";
$kats["U"]="U vs O";
$kats["N"]="insertion of M/N/S";
$kats["?"]="other";
$kats["+"]="other";

while(is_array($sz))
{


echo("<tr><th>".$sz["lexel"]."<td>".$sz["grammel"]."<td>".$sz["form"]."<td class=forma>".$sz["skup"]."<td>".$sz["kat"]);

$i++;
$sz=pg_fetch_array($szn);
}

   
 echo("</table>");  

 
 if(!empty($r))
 {
  echo("<a href=my_gridload.php?v=$r target=iframe>Combined map</a>");
 }
?>