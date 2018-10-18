<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$ta=$_GET["ta"];
$tb=$_GET["tb"];
$tc=$_GET["tc"];


//shared("D","G");


echo("<div id=vsl style='position:fixed; right:0%; top:o; background-color:yellow;'></div>");

  //$lexely=pg_prepare($pg,"lexely", "SELECT lexel FROM new_laeme WHERE text=$1 GROUP BY lexel");
  //$formy=pg_prepare($pg,"formy", "SELECT form FROM new_laeme WHERE text=$1 AND lexel=$2 GROUP BY form");

  $prunik=pg_prepare($pg,"prunik", "SELECT a.form AS af, b.form AS bf, a.lexel AS l, count(*) AS freq
                                       FROM (SELECT lexel,form FROM new_laeme WHERE text=$1) AS a
                                       INNER JOIN
                                             (SELECT lexel,form FROM new_laeme WHERE text=$2) AS b
                                                 ON a.lexel=b.lexel AND a.form=b.form 
                                                  GROUP BY a.lexel, a.form, b.form ORDER BY freq desc"); 
                                                  
   $prunik3=pg_prepare($pg,"prunik3", "SELECT a.form AS af, b.form AS bf, c.form AS cf, a.lexel AS l, count(*) AS freq
                                       FROM (SELECT lexel,form FROM new_laeme WHERE text=$1) AS a
                                       INNER JOIN
                                             (SELECT lexel,form FROM new_laeme WHERE text=$2) AS b
                                                 ON a.lexel=b.lexel AND a.form=b.form 
                                        INNER JOIN
                                             (SELECT lexel,form FROM new_laeme WHERE text=$3) AS c
                                                 ON a.lexel=c.lexel AND a.form=c.form 
                                                  GROUP BY a.lexel, a.form, b.form, c.form ORDER BY freq desc");                                                
                                                  

if(!empty($ta)&&!empty($tb)&&!empty($tc))
{
 
     $u=pg_execute($pg, "prunik3", array($ta,$tb,$tc));
    
   $ms = pg_fetch_array($u);
   
   $psh=count($u);
   
  
   
   while(is_array($ms))
   {
   echo("<a href=sharedlex.php?lex=".$ms["l"]."&ta=$ta&tb=$tb>");
    echo($ms["l"]." </a>: ".$ms["af"]."-".$ms["bf"]."-".$ms["cf"]." (".$ms["freq"].")<br>");
     $ms = pg_fetch_array($u);
   }
   
}
elseif(!empty($ta)&&!empty($tb))
{
 
     $u=pg_execute($pg, "prunik", array($ta,$tb));
    
   $ms = pg_fetch_array($u);
   
    echo("NUmber of shared forms: ".$psh."<br>");
   
   while(is_array($ms))
   {
   echo("<a href=sharedlex.php?lex=".$ms["l"]."&ta=$ta&tb=$tb>");
    echo($ms["l"]." </a><span onClick='vyskyty(\"".$ms["l"]."\");' onDblClick='formy(\"".$ms["l"]."\")'>: ".$ms["af"]."-".$ms["bf"]." (".$ms["freq"].")</span><br>");
     $ms = pg_fetch_array($u);
   }
} 
else
{
echo("No texts have been selected.");
}                                                 

   
   
        
?>

<script>

function vyskyty(str)
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
xmlhttp.open("GET","sharedlex.php?lex="+str+"&t[]=8&t[]=142&t[]=291&t[]=4&t[]=1200&t[]=65",true);
xmlhttp.send();
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
xmlhttp.open("GET","php/ajx_formy.php?q="+str,true);
xmlhttp.send();
}


</script>