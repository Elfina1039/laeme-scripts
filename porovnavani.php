<?php

  //other SURROUNDING TEXTS: 138,11,64 , 67
 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$maz= $_GET["m"];
$t= $_GET["t"];
 
 echo("<div id=vsl style='position:fixed; right:0;top:0'></div>"); 

//vypis lexelu

                                          
  $vzcng=pg_prepare($pg,"lexels", "SELECT array_agg(text) as texty,lexel FROM new_laeme WHERE lexel NOT IN (SELECT lexel FROM zaznamy) GROUP BY lexel");

     $vypsat=pg_execute($pg,"lexels", array());
    
   
   $pl=pg_fetch_array($vypsat);
   
   echo("<table><tr><th>lexel<th>corpus frequency");
     $celkem=0;
    while(is_array($pl))
   {
   
     $rozdelit= explode(",",$pl["texty"]);
     $seznam=array_unique($rozdelit);
     $pocet=count($seznam);
     
                    //echo("<tr><td>".$pocet);
     
     $okolni=array(291,4,142,64,8);
     
     $prunik=count(array_intersect($seznam,$okolni));
     
     if($prunik>=4 && $pocet>=40 && $pocet<45)
     {
        echo("<tr><th onClick='formy(\"".$pl["lexel"]."\");'>".$pl["lexel"]."<td>$pocet");
           $celkem++;
     }
     
   
     $pl=pg_fetch_array($vypsat);
    
    }
    
    echo("</table>total items: ".$celkem);




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
 
 //1487442 - 1492447

?>

<script>

function formy(str)
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
xmlhttp.open("GET","sharedlex.php?lex="+str+"&t[]=8&t[]=4&t[]=291&t[]=142&t[]=64",true);
xmlhttp.send();
}

 //&t[]=9&t[]=7&t[]=5&t[]=6&t[]=4&t[]=8

</script>
