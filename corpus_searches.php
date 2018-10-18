<html>
<head>

<link rel=stylesheet href=css/atlas.css type=text/css media=screen>
  
</head>
<body>
 

<div id=leva>


<iframe id=iframe name=iframe>

</iframe>

<form name=nsearch method=GET action=my_gridload.php target=iframe>
 <h4>Enter new search</h4>
<label>lexel:<input type=text name=l></label><br>
<label>grammel:<input type=text name=g></label><br>
<label>form:<input type=text name=f></label><br>
<hr>
<label>group<input type=text name=skup></label><br>

<label>
<input type=button value=search onClick="vyhledej();">
<input type=button value=save onClick="uloz();">
</label>

</form>

<div style="overflow:scroll; height:400px">

<?php


 header("Content-Type: text/html; charset=UTF-8");
 
     
       $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

    // $r = $_GET["r"];
 
 // $vypiskat=pg_prepare($pg,"vypisk", "SELECT * FROM laeme_searches WHERE rozdil=$1  ORDER BY nazev , verze");
 $vypis=pg_prepare($pg,"vypis", "SELECT * FROM zaznamy_m WHERE skup!='U' ORDER BY lexel");
 
// $prepis=pg_prepare($pg,"prepis", "UPDATE laeme_searches  SET lexel=nazev WHERE lexel IS NULL");

$szn=pg_execute($pg,"vypis",array());

$sz=pg_fetch_array($szn);



echo("<table><tr><th>No<th>lexel<th>grammel<th>form<th>MAP");

$i=1;
while(is_array($sz))
{
echo("<tr><th>$i<th>".$sz["lexel"]."<td>".$sz["grammel"]."<td>".$sz["form"]."<td><input type=button value=MAP onClick='document.getElementById(\"iframe\").src=\"my_gridload.php?l=".$sz["lexel"]."&g=".$sz["grammel"]."&f=".$sz["form"]."\"'>");

$i++;
$sz=pg_fetch_array($szn);
}

   
 echo("</table>");  


?>
</div>  

<script>
  
function vyhledej()
{
     document.forms['nsearch'].action='my_corpus.php';
     document.forms['nsearch'].target='iframe';
     document.forms['nsearch'].submit();
     
      return true;
} 
 
 function uloz()
{
     document.forms['nsearch'].action='save_search.php';
     document.forms['nsearch'].target='iframe';
     document.forms['nsearch'].submit();
     return true;
}



function zobraz(id)
{

document.getElementById('iframe').src="http://corpus.delfiin.net/gridload.php?z=1&radek="+id;
}

function zobrazD(r)
{

document.getElementById('iframe').src="http://corpus.delfiin.net/laeme_cmaps.php?v=D&r="+r;
}

function zobrazL(r)
{
document.getElementById('iframe').src="http://corpus.delfiin.net/laeme_cmaps.php?v=L&r="+r;
}

function zobraz_double(n)
{

document.getElementById('iframe').src="http://corpus.delfiin.net/laeme_doublemap.php?lexel="+n;
}

function zobraz_doubles(n)
{

document.getElementById('iframe').src="http://corpus.delfiin.net/laeme_doublemap.php?rozdil="+n;
}


</script>
</div>



 </body>
 </html>