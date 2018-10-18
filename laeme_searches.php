<html>
<head>

<link rel=stylesheet href=css/atlas.css type=text/css media=screen>
  
  <style>
  
  .positive{outline:2px solid green; margin:0;
	}
	
	.negative{outline:2px solid red;margin:0;
	}
  
  </style>
  
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
<label>pattern<input type=text name=patt></label><br>

<label>
<input type=button value=search onClick="vyhledej();">
<input type=button value=save onClick="uloz();">
</label>

</form>

<div style="overflow:scroll; height:400px">
<label>
<input type=checkbox name=pT id=pT value=T class=positive>
<input type=checkbox name=nT id=nT value=T class=negative>PM Trinity
</label>
<label>
<input type=checkbox name=pD id=pD value=D class=positive>
<input type=checkbox name=nD id=nD value=D class=negative>PM Digby 4
</label>
<label>
<input type=checkbox name=pM id=pM value=M class=positive>
<input type=checkbox name=nM id=nM value=M class=negative>PM M
</label>
<label>
<input type=checkbox name=pS id=pS value=S class=positive>
<input type=checkbox name=nS id=nS value=S class=negative>Essex 64
</label>
<label>
<input type=checkbox name=pX id=pX value=X class=positive>
<input type=checkbox name=nX id=nX value=X class=negative>Essex 65
</label>
<label>
<input type=checkbox name=pK id=pK value=K class=positive>
<input type=checkbox name=nK id=nK value=K class=negative>Laud
</label>
<label>
<input type=checkbox name=pG id=pG value=G class=positive>
<input type=checkbox name=nG id=nG value=G class=negative>Bodley
</label>
<label>
<input type=checkbox name=pV id=pV value=V class=positive>
<input type=checkbox name=nV id=nV value=V class=negative>Vitellius
</label>
<label>
<input type=checkbox name=pA id=pA value=A class=positive>
<input type=checkbox name=nA id=nA value=A class=negative>Arundel
</label>
<label>
<input type=checkbox name=pt id=pt value=t class=positive>
<input type=checkbox name=nt id=nt value=t class=negative>Trinity B
</label>





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
	
	if(empty($r))
	{
		$r="%";
	}
    
  
 
 // $vypiskat=pg_prepare($pg,"vypisk", "SELECT * FROM laeme_searches WHERE rozdil=$1  ORDER BY nazev , verze");
 $vypis=pg_prepare($pg,"vypis", "SELECT * FROM zaznamy WHERE (kat!='X' OR kat IS NULL) AND kat= $1   ORDER BY lexel");
 
// $prepis=pg_prepare($pg,"prepis", "UPDATE laeme_searches  SET lexel=nazev WHERE lexel IS NULL");

$szn=pg_execute($pg,"vypis",array($r));

$sz=pg_fetch_array($szn);



echo("<table ><tr><th>No<th>lexel<th>grammel<th>form<th>Cat.");

$i=1;

$skupiny=array();
$skupiny["mixed"]="orange";
$skupiny["J"]="black";
$skupiny["consistent"]="blue";
$skupiny["mixed verb"]="red";
$skupiny["consistent single"]="green";
$skupiny["other"]="silver";

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
$kats["oth"]="other";


while(is_array($sz))
{

echo("<tr class=radek id=r".$sz["id"]." title=".$sz["skup"]."><th style='background-color:".$skupiny[$sz["skup"]]."'>$i<th><a target=_blank href='http://www.oed.com/search?searchType=dictionary&q=".$sz["lexel"]."&_searchBtn=Search'>".$sz["lexel"]."</a><td>".$sz["grammel"]."<td onClick='document.getElementById(\"iframe\").src=\"my_gridload.php?l=".$sz["lexel"]."&g=".$sz["grammel"]."&f=".$sz["form"]."\"'>".$sz["form"]."<td>".$sz["kat"]."</td>");

$i++;
$sz=pg_fetch_array($szn);
}

   
 echo("</table>");  

 
 if(!empty($r))
 {
  echo("<a href=my_gridload.php?v=$r target=iframe>Combined map</a>");
 }
?>
</div>  


<script src="js/jquery.js"></script>
<script>




$("[type=checkbox]").click(function(){

var radky=$(".radek");

var vybrane=$(".positive:checked");
var vzorec=".*";
for(i=0;i<vybrane.length;i++)
{
	vzorec+=vybrane[i].value+".*";
}


var negativni=$(".negative:checked");
var norec=".*[";
for(i=0;i<negativni.length;i++)
{
	norec+=negativni[i].value;
}
norec+="].*";

var shoda=new RegExp(vzorec);
var neshoda=new RegExp(norec);




for(i=0;i<radky.length;i++)
{

if(shoda.test(radky[i].title)==true && neshoda.test(radky[i].title)==false)
{
$("#"+radky[i].id).css({"display":"table-row"});
}
else
{
	$("#"+radky[i].id).css({"display":"none"});
}

}






	});
  
function vyhledej()
{
     document.forms['nsearch'].action='my_gridload.php';
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