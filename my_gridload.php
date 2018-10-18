<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:900px; height:900px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:10px; height:10px; background-color:black; color:white;font-size:8pt;overflow:hidden;
        border-width:3px; border-style:solid; text-shadow:0px 0px 3px}
.kryti{position:absolute; width:8px; height:8px; background-color:red; color:white;font-size:8pt;overflow:hidden;}

.vyskyt:hover{width:25px; height:25px;z-index:100}
.kryti:hover{width:25px; height:25px;z-index:100}

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
 
 $search=pg_prepare($pg,"stary", "SELECT text AS text,count(text) AS freq FROM new_laeme WHERE lexel SIMILAR TO $1 AND form SIMILAR TO $2 AND grammel SIMILAR TO $3 GROUP BY text");
  $pokryti=pg_prepare($pg,"search", "SELECT * FROM
                                       (SELECT text AS text,count(text) AS kryti FROM new_laeme
                                           WHERE lexel SIMILAR TO $1 AND grammel SIMILAR TO $3 GROUP BY text)as kr
                                    LEFT JOIN (SELECT text AS txt,count(text) AS freq FROM new_laeme 
                                    WHERE lexel SIMILAR TO $1 AND form SIMILAR TO $2 AND grammel SIMILAR TO $3 GROUP BY text) AS vkt
                                         ON kr.text=vkt.txt");
    
     $pokryti=pg_prepare($pg,"searchStrids", "SELECT * FROM
                                       (SELECT text AS text,count(text) AS kryti FROM new_laeme nl
                                          INNER JOIN pm_vocab pm ON nl.lexel=pm.lexel AND nl.grammel=pm.grammel WHERE pm.id IN (905,2032,1861,2131,2246,1396,2471,2460,792,941,733,610,2601,2492,193,332,2300,363,606,201)  GROUP BY text)as kr
                                    LEFT JOIN (SELECT text AS txt,count(text) AS freq FROM new_laeme nl INNER JOIN pm_vocab pm ON nl.lexel=pm.lexel AND nl.grammel=pm.grammel WHERE pm.id IN (905,2032,1861,2131,2246,1396,2471,2460,792,941,733,610,2601,2492,193,332,2300,363,606,201) AND form SIMILAR TO '%CH%'  GROUP BY text) AS vkt
                                         ON kr.text=vkt.txt");
                                         
   $vzorec=pg_prepare($pg,"vzorec", "SELECT text AS text,count(text) AS freq FROM new_laeme WHERE pattern=$1 GROUP BY text");
    $pokryti_v=pg_prepare($pg,"vkryt", "SELECT text AS text,count(text) AS freq FROM new_laeme WHERE lexel IN (SELECT lexel FROM zaznamy_m WHERE pattern=$1 GROUP BY lexel) GROUP BY text");
  
  $l=$_GET["l"];
  $g=$_GET["g"];
  $f=$_GET["f"];
  $v=$_GET["v"];
    
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
  else
  {
  $f="\*?".$f;
  }
  
  
  staramapa($l,$g,$f);
 
 function staramapa($l,$g,$f)
 {
   
 global $pg,$search; 
    include("grid.php");
    include("wcounts.php"); 
     include("datings_simple.php"); 
 
 if(!empty($v))
 {
  $u=pg_execute($pg, "vzorec", array($v));
 }
 else
 {
  $u=pg_execute($pg, "search", array($l,$f,$g));
 }

    
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
 $barvy[142]="green"; 
 $barvy[291]="green"; 
 $barvy[158]="orange";
 $barvy[65]="purple"; 
 $barvy[1200]="teal"; 
 $barvy[184]="red";  

 while(is_array($ms))
 {

 $ipm = round(($ms["freq"]/($whash[$ms["text"]]/4000)),1);
 


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
$barva="transparent";
}



 if(!empty($ms["freq"]))
 {
 $sila=alpha($ms["freq"],$ms["kryti"]);
  $rgb=seda($ms["freq"],$ms["kryti"]);
  
  $rgb="rgb($rgb,$rgb,$rgb)";
 
 echo("<a href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$ms["text"].">
<p class=vyskyt style='border-color:$barva; left:".$x."px; bottom:".$y."px; background-color:".$rgb."'
onMouseover='allf(\"$l\",\"$g\",\"&t[]=".$ms["text"]."\");' title=".$dhash[$ms["text"]].">".$ipm."<br>".$ms["freq"]."</p></a>");
 }
 else
 {
 echo("<a href=http://archive.lel.ed.ac.uk/ihd/laeme2_scripts/find_msdescriptor.php?idno=".$ms["text"].">
<p class=kryti style='left:".$x."px; bottom:".$y."px; '
onMouseover='allf(\"$l\",\"$g\",\"&t[]=".$ms["text"]."\");' title=".$dhash[$ms["text"]].">".$ms["kryti"]."</p></a>");
 }

  $ms = pg_fetch_array($u);
 }
 
 echo("</div>");

 $data=array_unique($dhash);

echo("<div style='position:absolute; left:0;bottom:0px; background-color:orange'>"); 
 foreach($data as $d)
 {
 echo("<input type=checkbox checked  value=$d class=stoleti id=cb$d>".$d."  ");
 }
 echo("</div>");
 }


 
 
 function alpha($l, $d)
{

$sila=round($l/($d/0.7),2)+0.3;
return $sila;

}

function seda($l, $d)
{
$bila=$l/($d/100);

$rgb=round(2.55*$bila);
return $rgb;

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