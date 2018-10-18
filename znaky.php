<html>
<head>
<meta charset="utf-8">
<style>

*{box-sizing:border-box}
body,html{
	display:flex; flex-flow:row nowrap; height:100%;width:100%;
}

table{
	border:2px solid black;
}

td, th{
	padding:0.3em;
	border:1px solid black;
}

tr:nth-of-type(odd){
	background:rgba(0,0,255,0.3);
}

div.manuscript{font-size:12pt; }


.zelena{background-color:green; color:white}
.modra{background-color:blue; color:white}
.cervena{background-color:red;color:white}
.zluta{background-color:yellow; color:black;}

.lc{
	margin-left:0.5em; margin-right:0.5em; color:yellow;
}

div.pergamen{width:25%; border:2px solid orange; padding:1em; background:rgba(0,0,255,0.3); color:black; 
 height:100%; overflow:scroll}

.cr{
	color:blue; font-weight:bold; display:inline;
} 
p.radek{
	font-size:15pt;border-radius:1em;margin:0;
}  

div.cpick{
	width:15px; height:15px; display:inline;
}
</style>


</head>
<body>

<script src="js/jquery.js"></script>
<script src="graphonemes.js"></script>


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

                                          
  $vzcng=pg_prepare($pg,"manuscript", "SELECT form FROM new_laeme WHERE text=$1 ORDER BY id ");
  $zapis=pg_prepare($pg,"zapis", "INSERT INTO litterae (littera, count,text) VALUES ($1,$2,$3)");

  
     foreach($t as $ms)
     {
	 echo("Loading ".$ms."<br></br>");
       $vypsat=pg_execute($pg,"manuscript", array($ms));
     
     spocitat($vypsat,$ms);
     }
    
       

//vypsat texty a jejich delku 
 function spocitat($vypsat,$mid)
 {
 global $pg;
   $vysledek;
   
    echo("Looping... ".$ms."<br></br>");
 
   $pl=pg_fetch_array($vypsat);

    while(is_array($pl))
   {
$znaky=str_split($pl["form"]);

 //echo("WORD: ".$pl["form"]."<br></br>");

foreach($znaky as $z)
{
	if(!isset($vysledek[$z]))
	{
		$vysledek[$z]=1;
		//echo("New graph: ".$z."<br>");
	}
	else
	{
		$vysledek[$z]++;
		//echo("Count increased: ".$z ."=".$vysledek[$z]."<br>");
	}
}

     $pl=pg_fetch_array($vypsat);
    
    }
    
	
	foreach($vysledek as $znk=>$cnt)
	{
	
	  $zapsat=pg_execute($pg,"zapis", array($znk,$cnt,$mid));
		echo($znk."=".$cnt."<br>");
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


</body>
</html>
