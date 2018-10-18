<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;overflow:hidden;}

.vyskyt:hover{width:25px; height:25px;z-index:100}

#allf{position:absolute; left:0; top:0; width:900px;min-height:40px; background-color:orange; }
#vsl{position:absolute; left:0; top:40px; width:900px;min-height:0px; background-color:orange; }
#vysledky{position:absolute; left:0; top:900px; font-size:6 px }



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
 
 $search=pg_prepare($pg,"search", "SELECT array_agg(form) AS forma, array_agg(lexel) AS lx, text FROM new_laeme WHERE lexel IN 
               (SELECT lexel FROM new_laeme WHERE form SIMILAR TO '%EA%' GROUP BY lexel) GROUP BY text");
  
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
  
  
  staramapa($l,$g,$f);
 
 function staramapa($l,$g,$f)
 {
    echo("fce");
 global $pg,$search,$vysledky; 
    include("grid.php");
    include("wcounts.php");
    include("datings.php");  
 
$u=pg_execute($pg, "search", array());
    
$ms = pg_fetch_array($u);

   echo("<img class=mapka src=mapy/mapka.png>"); 
   echo("<div class=mapka>");
   
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
 
 $lx["for"]="[VU]*"; 
 $lx["friend"]="[VU]*"; 
 $lx["feel"]="[VU]*"; 
 $lx["sing"]="Z*"; 
 $lx["say"]="Z*"; 
 $lx["forth"]="[VU]*"; 
 $lx["fair"]="[VU]*"; 
 $lx["fall"]="[VU]*"; 
 $lx["faran"]="[VU]*"; 
 $lx["fast"]="[VU]*"; 
 $lx["father"]="[VU]*";
 $lx["fela"]="[VU]*"; 
 $lx["find"]="[VU]*"; 
 $lx["fire"]="[VU]*"; 
 $lx["follow"]="[VU]*"; 
 $lx["from"]="[VU]*";  

 $vysledky=array();

 while(is_array($ms))
 {

 $a=0;
 $b=0;

 $formy=explode(",",substr($ms["forma"],1,-1));
$lexely=explode(",",substr($ms["lx"],1,-1));



for($i=0;$i<count($formy);$i++)
{

if(fnmatch("*EA*",$formy[$i]))
{
 $a++;
 zapis($lexely[$i],$dhash[$ms["text"]],1,0);
}
else
{  
 $b++;
 zapis($lexely[$i],$dhash[$ms["text"]],0,1);
}

}

$rgb=seda($a,$b);
$rgb = "rgb(".$rgb.",".$rgb.",".$rgb.")";


    $x = ($hash[$ms["text"]]["x"]*1.5)-75;
$y = ($hash[$ms["text"]]["y"]*1.5)-75;

if($ms["text"]==5 || $ms["text"]==65)
{
$x=$x-12;
}

if($ms["text"]==2000 || $ms["text"]==303)
{
$y=$y-12;
}

if(in_array($ms["text"],$klicove))
{
$barva=$barvy[$ms["text"]];
}  
else
{
$barva="black";
}





echo("<a href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$ms["text"].">
<p class=vyskyt style='left:".$x."px; bottom:".$y."px; background-color:".$rgb."; color:white;'
onClick='allf(\"$l\",\"$g\",\"&t[]=".$ms["text"]."\");' title=".$dhash[$ms["text"]].">$a<br>/$b</p></a>");
  $ms = pg_fetch_array($u);
 }
 
 echo("</div>");


 $data=array_unique($dhash);

echo("<div style='position:absolute; right:0;top:0'>"); 
 foreach($data as $d)
 {
 echo("<li><input type=checkbox checked  value=$d class=stoleti id=cb$d>".$d."<br>");
 }
 echo("</div>");
 
 }
 
function seda($l, $d)
{
$t=$l+$d;
$bila=round(($l/$t),1,PHP_ROUND_HALF_UP);

$rgb=ceil(255*$bila);
return $rgb;

}

function zapis($lx,$dt,$plus,$minus)
{
global $vysledky;
if(!isset($vysledky[$lx]))
{
$vysledky[$lx]["lx"]=$lx;
}

$vysledky[$lx]["freq"]++;

if(!isset($vysledky[$lx][$dt]))
{
 $vysledky[$lx][$dt]["t"]=$plus;
 $vysledky[$lx][$dt]["f"]=$minus; 
}
else
{
  $vysledky[$lx][$dt]["t"]+=$plus;
 $vysledky[$lx][$dt]["f"]+=$minus; 
}

}

tabulka();

function tabulka()
{

global $vysledky;

echo("<table id=vysledky><th>lexel<th>C12b1<th>C12b2<th>C13a1<th>C13a2<th>C13b1<th>C13b2<th>C14a1<th>C14a2");
foreach($vysledky as $rd)
{
if($rd["freq"]>=50)
{
 echo("<tr><th>".$rd["lx"]."<td>".procenta($rd["C12b1"]["t"],$rd["C12b1"]["f"])
                          ."<td>".procenta($rd["C12b2"]["t"],$rd["C12b2"]["f"])
                          ."<td>".procenta($rd["C13a1"]["t"],$rd["C13a1"]["f"])
                          ."<td>".procenta($rd["C13a2"]["t"],$rd["C13a2"]["f"])
                          ."<td>".procenta($rd["C13b1"]["t"],$rd["C13b1"]["f"])
                          ."<td>".procenta($rd["C13b2"]["t"],$rd["C13b2"]["f"])
                          ."<td>".procenta($rd["C14a1"]["t"],$rd["C14a1"]["f"])
                          ."<td>".procenta($rd["C14a2"]["t"],$rd["C14a2"]["f"])
                          
                          
                          );
}

}

echo("</table>");
}

function procenta($a,$b)
{

if(empty($a)&&empty($b))
{
return "-";
}

$hdn=round($a/(($a+$b)/100));
return $hdn;
}
 
  

?>


<div id=allf>
<li onClick=allf(<?php echo("'".$l."','".$g."'");  ?>);>Show all forms
<li onClick=allf(<?php echo("'".$l."','".$g."'");  ?>,"&t[]=8&t[]=291&t[]=142&t[]=65&t[]=4&t[]=1200&t[]=10");>Show forms in examined texts

</div>
<div id=vsl></div>


<script>


$(".stoleti").click(function(){

$("[title="+$(this).val()+"]").toggle();

});


function allf(l,g,t)
{

if(t==null || t=="undefined")
{
t="";
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
xmlhttp.open("GET","sharedlex.php?lex="+l+"&gram="+g+t,true);
xmlhttp.send();
}



</script>

</body>
</html>