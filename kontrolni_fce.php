<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


include("fcounts.php");
 
 
$maz= $_GET["m"];
$t= $_GET["t"];
 
  if(!empty($t))
 {
 echo("Rare foorms in text ".$t);
    vzacne($t);
 
 }
 
 
 if(!empty($maz))
 {
    smaztext($maz);
 
 }

 //vypsat();
 
//smazat text z tabulky
function smaztext($id)
{
global $pg;
  $vsmaz=pg_prepare($pg,"smaztext", "DELETE FROM new_laeme WHERE text=$1");

    $maz=pg_execute($pg,"smaztext", array($id));
    
    echo("Text No." .$id." deleted.<br>");


}


//hledni vzacnych forem

function vzacne($id)
{
global $pg;

echo("<div id=vsl style='position:fixed; right:0;top:0'></div>");
  $vzcn=pg_prepare($pg,"vzacne", "SELECT  t.form AS fr, t.lexel AS lx, t.tfreq AS tfreq, l.lexf AS lexf, f.formf AS formf, l.lexf/f.formf AS rat
                                    FROM (SELECT form, lexel, count(*) AS tfreq FROM new_laeme WHERE text=$1 GROUP BY form,lexel) as t
                                            LEFT OUTER JOIN
                                          (SELECT lexel, count(lexel) AS lexf FROM new_laeme GROUP BY lexel) AS l
                                        ON t.lexel=l.lexel
                                           LEFT OUTER JOIN
                                          (SELECT form, count(*) AS formf FROM new_laeme GROUP BY form) AS f
                                        ON t.form=f.form  
                                         WHERE formf>5 AND tfreq=2 AND formf!=tfreq AND t.lexel!=''
                                          ORDER BY rat DESC ");
                                          
  $vzcng=pg_prepare($pg,"vzacneg", "SELECT  t.form AS fr, t.grammel AS lx, t.tfreq AS tfreq, l.lexf AS lexf, f.formf AS formf, l.lexf/f.formf AS rat
                                    FROM (SELECT form, grammel, count(*) AS tfreq FROM new_laeme WHERE text=$1 AND lexel='' GROUP BY form,grammel) as t
                                            LEFT OUTER JOIN
                                          (SELECT grammel, count(grammel) AS lexf FROM new_laeme GROUP BY grammel) AS l
                                        ON t.grammel=l.grammel
                                           LEFT OUTER JOIN
                                          (SELECT form, count(*) AS formf, grammel FROM new_laeme GROUP BY form,grammel) AS f
                                        ON t.form=f.form AND t.grammel=f.grammel 
                                         WHERE formf>5 AND tfreq>2 AND formf!=tfreq 
                                          ORDER BY rat DESC ");

     $vypsat=pg_execute($pg,"vzacne", array($id));
   
   $pl=pg_fetch_array($vypsat);
   
   echo("<table><trstyle='position:fixed; left:0;top:0'><th>lexel<th>form<th>Text frequency<th>Corpus frequency<th>Lexel frequency<th>ratio");
    
    while(is_array($pl))
   {
      $rat=round($pl["lexf"]/$pl["formf"],2);
   //echo($rat);
   
   echo("<tr><th onMouseover='formy(\"".$pl["lx"]."\",".$id.");'>".$pl["lx"]."<th>".$pl["fr"]."<td>".$pl["tfreq"]." <td> ".$pl["formf"]."<td>".$pl["lexf"]."<td>$rat");
    
     $pl=pg_fetch_array($vypsat);
    
    }


}

//vypsat texty a jejich delku 
 function vypsat()
 {
 global $pg,$fhash;
 
  $vypis=pg_prepare($pg,"vypsat", "SELECT text,count(text) as tokeny FROM new_laeme GROUP BY text");
   
  
   $vypsat=pg_execute($pg,"vypsat", array());
   
   $pl=pg_fetch_array($vypsat);
   
   while(is_array($pl))
   {
   $diff= $pl["tokeny"]-$fhash[$pl["text"]];
   
   if($diff<0)
   {
   $barva="red";
   }
   else
   {
   $barva="blue";
   }
   
   
   echo($pl["text"]." : ".$pl["tokeny"]. ",<span style='color:$barva'> diff=" .$diff. "</span><br>");
   
    $pl=pg_fetch_array($vypsat);
   }
 }
 

 //D,L
 //K=Laud Misc
 //A=Arundel
 //T=Trinity
 //V=Vitellius 184
 //O=Ox Bod Additional
 // H=Trinity homilies 1200
 //G= bodley 86, 2002 

?>

<script>

function formy(str,txt)
{


if (str=="")
  {
  document.getElementById("vsl").innerHTML="";
 
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("vsl").innerHTML=xmlhttp.responseText;
   
    }
  }
xmlhttp.open("GET","sharedlex.php?lex="+str+"&t[]="+txt+"&t[]=9",true);
xmlhttp.send();
}



</script>
