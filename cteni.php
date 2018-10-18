
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

div.pergamen{width:400px; border:2px solid orange; padding:1em; background-color:black; color:white; font-weight:bold}
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
 
 echo("<div id=vsl style='position:fixed; right:0;top:0'>
       <input type=text name=hledat1 id=hledat1 class=zelena><input type=button value=OK onClick='zvyraznit(1,\"zelena\")'>
       <input type=text name=hledat2 id=hledat2 class=modra> <input type=button value=OK onClick='zvyraznit(2,\"modra\")'> 
       <input type=text name=hledat3 id=hledat3 class=cervena> <input type=button value=OK onClick='zvyraznit(3,\"cervena\")'>
	   <input type=text name=hledat4 id=hledat4 class=zluta> <input type=button value=OK onClick='zvyraznit(4,\"zluta\")'>
 
    </div>"); 

//vypis lexelu

                                          
  $vzcng=pg_prepare($pg,"manuscript", "SELECT form, grammel, lexel, text FROM new_laeme WHERE text=$1 ORDER BY id ");

     
     foreach($t as $ms)
     {
       $vypsat=pg_execute($pg,"manuscript", array($ms));
     
     vypsat($vypsat);
     }
    
       

//vypsat texty a jejich delku 
 function vypsat($vypsat)
 {
 global $pg;
   
 
   $pl=pg_fetch_array($vypsat);
    echo("<div class=pergamen>".$pl["text"]."<hr><p class=manuscript id=m".$pl["text"].">");

	$lc=1;
	
    while(is_array($pl))
   {

      if(fnmatch("x[ps]*", $pl["grammel"])==false)
     {
     echo($pl["form"]. " ");
     }
     
       if(fnmatch("*\{rh\}*", $pl["grammel"]))
     {
	   $lc++;
	    echo("<br><span class=lc>$lc</span>"); 
     }
   

     $pl=pg_fetch_array($vypsat);
    
    }
    
    echo("</p></div>");
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
var edh=new RegExp("d","g");
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
