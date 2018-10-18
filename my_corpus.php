<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;overflow:hidden;}

.vyskyt:hover{width:25px; height:25px;z-index:100}

#allf{position:absolute; left:0; top:0; width:900px;min-height:40px; background-color:orange; }
#vsl{position:absolute; left:0; top:40px; width:900px;min-height:0px; background-color:orange; }

</style>

<script src="js/jquery.js"></script>
</head>

<body>

  

<?php


 header("Content-Type: text/html; charset=UTF-8");
 
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

 // $uloz=pg_prepare($pg,"uloz", "INSERT INTO laeme_mymaps (radek,text,freq) VALUES ($1,$2,$3)");
  //$nacti=pg_prepare($pg,"nacti", "SELECT * FROM laeme_mymaps WHERE radek=$1");
  
 // $skup=pg_prepare($pg,"skupina", "SELECT skupina FROM laeme_searches WHERE id=$1");
 
 $search=pg_prepare($pg,"search", "SELECT text,grammel, lexel, form,id FROM new_laeme WHERE lexel SIMILAR TO $1 AND form SIMILAR TO $2 AND grammel SIMILAR TO $3 ORDER BY text");
  
  $l=$_GET["l"];
  $g=$_GET["g"];
  $f=$_GET["f"];
    
  if(empty($g))
  {
  $g="%";
  }
  
   if(empty($l))
  {
  $l="%";
  }
  
   if(empty($f))
  {
  $f="%";
  }
  
  
  korpus($l,$g,$f);
 
 function korpus($l,$g,$f)
 {
   
 global $pg,$search,$hity; 
    include("grid.php");
    include("wcounts.php"); 
     include("datings.php"); 
 
$u=pg_execute($pg, "search", array($l,$f,$g));
    
$ms = pg_fetch_array($u);

   echo("<table><tr><th colspan=4>Search for: $l ($g) : $f 
                <tr><th>TEXT<th>LEXEL<th>GRAMMEL<th>FORM"); 

   
 $klicove=array(4,5,6,7,8,9,10,142,158,291,65,1200,184,1100); 
 
 $barvy[4]="blue"; 
 $barvy[5]="blue"; 
 $barvy[6]="blue"; 
 $barvy[7]="blue"; 
 $barvy[8]="blue"; 
 $barvy[9]="blue"; 
 $barvy[10]="orange"; 
 $barvy[1100]="blue"; 
 $barvy[142]="green"; 
 $barvy[291]="green"; 
 $barvy[158]="orange";
 $barvy[65]="purple"; 
 $barvy[1200]="teal"; 
 $barvy[184]="red";  

  $hity=0;

 while(is_array($ms))
 {
 $hity++;

$x = ($hash[$ms["text"]]["x"]*1.5)-75;
$y = ($hash[$ms["text"]]["y"]*1.5)-75;


if(in_array($ms["text"],$klicove))
{
$barva=$barvy[$ms["text"]];
}  
else
{
$barva="white";
}


echo("<tr  onClick='kwic(".$ms["id"].")'><th style='background-color: $barva'>".$ms["text"]."<th>".$ms["lexel"]."<td>".$ms["grammel"]."<td>".$ms["form"]."<th id=kwic".$ms["id"].">");




  $ms = pg_fetch_array($u);
 }
 
 echo("</div>");

 
 }

$data=array_unique($dhash);

echo("<div style='position:absolute; left:0;bottom:0'>"); 
 foreach($data as $d)
 {
 echo("<input type=checkbox checked  value=$d class=stoleti id=cb$d>".$d."  ");
 }
 echo("</div>");
 
 

 
  

?>


<div id=allf>
<li>TOTAL HITS: <?php echo($hity) ?>
<li onClick=allf(<?php echo("'".$l."','".$g."'");  ?>,"&t[]=8&t[]=291&t[]=142&t[]=65&t[]=4&t[]=1200&t[]=10");>Show forms in examined texts

</div>
<div id=vsl></div>


<script>

$(".stoleti").click(function(){

$("[title="+$(this).val()+"]").toggle();

});

function kwic(id)
{



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
    var ms=xmlhttp.responseText;
    ms=ms.replace(yogh,"Ȝ");
ms=ms.replace(thorn,"þ");
ms=ms.replace(wynn,"Ƿ");
ms=ms.replace(edh,"ð"); 
ms=ms.replace(ig,"ᵹ");
ms=ms.toLowerCase(); 

    document.getElementById("kwic"+id).innerHTML=xmlhttp.responseText;
   
    }
  }
xmlhttp.open("GET","php/kwic.php?id="+id,true);
xmlhttp.send();

}

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

ms=ms.toLowerCase();
    
 document.getElementById(txt).innerHTML=ms;
}



</script>

</body>
</html>