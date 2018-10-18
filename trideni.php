
<style>

body{
	display:flex; flex-flow:row nowrap;
}

p.manuscript{font-size:12pt}
.zelena{background-color:green; color:white}
.modra{background-color:blue; color:white}
.cervena{background-color:red;color:white}
.zluta{background-color:yellow; color:black;}

.lc{
	margin-left:0.5em; margin-right:0.5em; color:yellow;
}

div.pergamen{width:120px; border:2px solid orange; padding:1em; background-color:black; color:white; font-weight:bold}
div.pergamen:hover{width:400px
}
                                             
</style>

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


$t= $_GET["t"];
 

//vypis lexelu
$sigla=array();

 $sigla[4]="T"; 
 $sigla[5]="L"; 
 $sigla[6]="e"; 
 $sigla[7]="E"; 
 $sigla[8]="D"; 
 $sigla[9]="J"; 
 $sigla[10]="M"; 
 $sigla[142]="K"; 
 $sigla[291]="A"; 
 $sigla[158]="G";
 $sigla[65]="X"; 
  $sigla[64]="S"; 
 $sigla[1200]="t"; 
 $sigla[184]="V"; 

                                          
  //$vzcng=pg_prepare($pg,"vypocet", "SELECT z.id AS ajdy, array_agg(t.text) AS texty FROM zaznamy z 
//INNER JOIN texty_dp t ON t.lexel SIMILAR TO z.lexel  AND t.form SIMILAR TO z.form  WHERE z.lexel!=''
 // GROUP BY z.id ");
  
    $vzcng=pg_prepare($pg,"vypocet", "SELECT z.id AS ajdy, array_agg(t.text) AS texty FROM zaznamy z 
INNER JOIN texty_dp t ON  t.lexel SIMILAR TO z.lexel AND t.form SIMILAR TO z.form AND t.grammel SIMILAR TO z.grammel  WHERE z.lexel!='' AND z.grammel!=''
  GROUP BY z.id ");
  
    $zrd=pg_prepare($pg,"zaradit", "UPDATE zaznamy SET skup=$1 WHERE id=$2 ");


       $vypsat=pg_execute($pg,"vypocet", array());

   $pl=pg_fetch_array($vypsat);
 
    while(is_array($pl))
   {

 $seznam=preg_replace("/(\{)|(\})/","",$pl["texty"]);
 $szn=explode(",",$seznam);
 
 
 $seznam=array_unique($szn);
 sort($seznam);
 
 $kod="";
 $csg=$sigla;
 
 foreach($seznam as $s)
 {
$kod.=$sigla[$s];	
 }
 
$zarad=pg_execute($pg,"zaradit", array($kod,$pl["ajdy"]));
 echo("<br>".$kod);
 

     $pl=pg_fetch_array($vypsat);
    
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
var txts=new Array();

<?php
$x=0;

foreach($t as $t)
{
echo("txts[$x]=$t;");
$x++;	
}

?>

var yogh=new RegExp("z","g");
var thorn=new RegExp("y","g");
var wynn=new RegExp("w","g");
var edh=new RegExp("e","g");
var ig=new RegExp("g","g");


 

function znaky(txt)
{

var ms=document.getElementById(txt).innerHTML;



ms=ms.replace(yogh,"Ȝ");
ms=ms.replace(thorn,"þ");
ms=ms.replace(wynn,"Ƿ");
ms=ms.replace(edh,"ð"); 
ms=ms.replace(ig,"ᵹ"); 

//ms=ms.toLowerCase();
    
 document.getElementById(txt).innerHTML=ms;
}


function zvyraznit(zdroj,barva)
{
var txt=document.getElementById("hledat"+zdroj).value;

for(i=0;i<txts.length;i++)
{

var msa=document.getElementById("m"+txts[i]).innerHTML;

var najit=new RegExp(txt,"g");

var novya=msa.replace(najit,"<span class="+barva+">"+txt+"</span>");

 document.getElementById("m"+txts[i]).innerHTML=novya;
}



}


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
xmlhttp.open("GET","sharedlex.php?lex="+str+"&t[]=9&t[]=1100&t[]=10",true);
xmlhttp.send();
}

 //&t[]=9&t[]=7&t[]=5&t[]=6&t[]=4&t[]=8

</script>
