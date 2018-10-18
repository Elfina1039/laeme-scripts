
<html>
<head>
<meta charset="utf-8">
<style>

*{box-sizing:border-box}
body,html{
	display:flex; flex-flow:row wrap; height:100%;width:100%;
}

table{
	border:2px solid black; border-collapse:collapse
	
}

td, th{
	padding:0.3em;
	border:1px solid black;
}

tr.blue:nth-of-type(odd){
	background:rgba(0,0,255,0.3);
}

tr.red:nth-of-type(odd){
	background:rgba(255,0,0,0.3);
}
div.manuscript{font-size:12pt; }


.zelena{background-color:green; color:white}
.modra{background-color:blue; color:white}
.cervena{background-color:red;color:white}
.zluta{background-color:yellow; color:black;}

.lc{
	margin-left:0.5em; margin-right:0.5em; color:yellow;
}

#navrhy{
	 background:rgba(255,0,0,0.3);padding:1em;font-size:15pt; width:20%; height:10%;
	 position:fixed; right:0; top:10%;
}

div.pergamen{width:25%;padding:1em; background:rgba(0,0,255,0.3); color:black;  border:2px solid blue;
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

  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.8/angular-filter.min.js"></script>
   <script>
  angular.module("spellingy",['angular.filter']);
  </script>
  
  <script src="js/jquery.js"></script>
  <script src="graphonemes.js" charset="utf-8"></script>
    <script src="spellingy_data.js" charset="utf-8"></script>
	 <script src="splController.js" charset="utf-8"></script>


  
  
</head>
<body ng-app="spellingy" ng-controller="methinker">

 
  
<div id=vsl style='position:fixed; right:0;top:0; background-color:rgba(0,0,0,0.5); color:white;'>

<p id=napoveda></p>

<div class="cpick zelena" title=zelena>G</div>
<div class="cpick modra" title=modra>B</div>
<div class="cpick cervena" title=cervena>R</div>
<select id=field>
<option value=l>Lexel
	  <option  value=g>Grammel
	   <option  value=f>Form
</select>
	{{grphs[0].ph}}
       <input type=text name=hledat id=hledat><input type=button value=OK onClick='zvyraznit2()'>
	

 
    </div>
	
	<table id=lsc>
	<tr class=blue ng-repeat="ls in lsc | orderBy:'c'">
	<th ng-click='prirad(ls)' ng-mouseenter="navrhni(ls.l)">{{ls.l}}<td>{{ls.c}}<th>{{gpole(ls.l).rps}}
	
	</table>
	
 <table id=phlist ><tr class=red ng-repeat="g in grphs" >
 <th ng-click="pripis(g)">{{g.ph}}<td>{{g.RPS}}<td>{{g.rps}}</table>
 
  <table id=olist ><tr class=blue ng-repeat="o in vskt | orderBy: 'l' | unique: 'l'" >
 <th ng-click="jineTexty(o.l)">{{o.l}}<td>{{dalsiMoznosti(o.l)}}</table>
 
 
 <div id=navrhy ng-bind=navrzene>
 </div><br>
 
 <div id=ovladac>
 <input type=button name=ulozit id=ulozit value=SAVE ng-click="uloz()"></input>;
 </div>

 
<script>
var texty=new Object();
var vyskyty=new Array();
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
 
echo("var txt=".$t[0].";");

//vypis lexelu

                                          
  $vzcng=pg_prepare($pg,"manuscript", "SELECT form, grammel, lexel, text FROM new_laeme WHERE text=$1 ORDER BY id ");

  
     foreach($t as $ms)
     {
       $vypsat=pg_execute($pg,"manuscript", array($ms));
     
     nacist_texty($vypsat);
     }
    
       

//vypsat texty a jejich delku 
 function nacist_texty($vypsat)
 {
 global $pg;
   
 
   $pl=pg_fetch_array($vypsat);
    echo("texty[".$pl["text"]."]=new Array();
	     texty[".$pl["text"]."][0]=new Object();
		 texty[".$pl["text"]."][0].sh=0;
		 texty[".$pl["text"]."][0].sl=new Array();
		 ");

	$lc=0;
	$wc=0;
	
    while(is_array($pl))
   {

   echo("slovo={l:'".$pl["lexel"]."',g:'".$pl["grammel"]."',f:'".$pl["form"]."'};");

     echo("texty[".$pl["text"]."][$lc].sl.push(slovo);");
	 
       if(fnmatch("*\{rh\}*", $pl["grammel"]) || fmod($wc,10)==0)
     {
	   $lc++;
	    echo(   " texty[".$pl["text"]."][$lc]=new Object();
		 texty[".$pl["text"]."][$lc].sh=0;
		 texty[".$pl["text"]."][$lc].sl=new Array();");
	    
     }
   
$wc++;
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

var yogh=new RegExp("z","g");
var thorn=new RegExp("y","g");
var wynn=new RegExp("w","g");
var edh=new RegExp("d","g");
var ig=new RegExp("g","g");
var ash=new RegExp("ae","g");

var barva;
var pracovni=new Array();
var njv;
var vit;
var vitez;


for(i in texty)
{

	$("body").prepend("<div class=pergamen id=t"+i+" title=TEXT:"+i+"><h2>TEXT:"+i+"</h2></div>");

for(r=0;r<texty[i].length;r++)
{



$("#t"+i).append("<p class=radek id=t"+i+"r"+r+" title="+r+" data-t="+i+" ></p>");

if(r%5==0)
{
$("#t"+i+"r"+r).append("<span class=cr>"+r+"  </span>");	
}

for(s=0;s<texty[i][r]["sl"].length;s++)
{

	$("#t"+i+"r"+r).append("<span id=t"+i+"r"+r+"s"+s+" class=slovo data-gr="+texty[i][r]["sl"][s].g+" data-lx="+texty[i][r]["sl"][s].l+">"+nahradit(texty[i][r]["sl"][s].f)+"</span> ");
	}
	
	//znaky("t"+i+"r"+r);
}

	
}

//$(".radek").click(function(){
//	vyhledat(this.getAttribute("title"),this.getAttribute("data-t"));
//});

$(".slovo").mouseenter(function(){
	$("#napoveda").html(this.getAttribute("data-lx")+"("+this.getAttribute("data-gr")+")");
});


$(".cpick").click(function(){
	barva=this.title;
	$("#hledat").attr("class",this.title);
});

function vyhledat(rd,mt)
{

$(".radek").css({"background-color":"transparent"});

	pracovni=[];
	
	for(x=0;x<texty[mt][rd].sl.length;x++)
	{
		pracovni.push(texty[mt][rd].sl[x].l);
		pracovni.push(texty[mt][rd].sl[x].g);
	}
	
	
		for(i in texty)
	{
	for(r=1;r<texty[i].length;r++)
{

texty[i][r].sh=0;

for(s=0;s<texty[i][r].sl.length;s++)
	{
	
	if(texty[i][r].sl[s].l!="")
	{
		if($.inArray(texty[i][r].sl[s].l,pracovni)!=-1)
	{
		texty[i][r].sh++;
	}
	}
	else
	{
		if($.inArray(texty[i][r].sl[s].g,pracovni)!=-1)
	{
		texty[i][r].sh++;
	}	
	}
	
	
	
	}


}
	

	 vitez=nejvyssi(texty[i]);	
	
		$("#t"+i+"r"+vitez).css({"background-color":"rgba(255,0,0,0.5)"});
		//alert(vitez);
		if(i!=mt)
		{
		 document.getElementById("t"+i).scrollTop=$("#t"+i+"r"+vitez).offset().top-100;
 
		}
		
		
	}

}

function nejvyssi(pole)
{
 njv=0;
 vit=0;
for(p=0;p<pole.length;p++)
{
if(pole[p].sh>njv)
{
    njv=pole[p].sh;
	vit=p;
}
	
}
return vit;	
}




 

function znaky(txt)
{

var ms=document.getElementById(txt).innerHTML;


    
 document.getElementById(txt).innerHTML=nahradit(ms);
}

function nahradit(ms)
{
ms=ms.replace(yogh,"Ȝ");
ms=ms.replace(thorn,"þ");
ms=ms.replace(wynn,"ƿ");
ms=ms.replace(edh,"ð"); 
ms=ms.replace(ig,"ᵹ"); 
ms=ms.replace(ash,"æ"); 

ms=ms.toLowerCase();

return ms;
}



function zvyraznit2(co,kr,jak)
{

//var txt=document.getElementById("hledat"+zdroj).value;

if(co=="undefined"||co==null)
{
zdroj=new RegExp($("#hledat").val());
krit=document.getElementById("field").value;
jak=barva;	
}
else
{
	zdroj=new RegExp(co.toUpperCase());
	krit=kr;
	
}

for(i in texty)
{

for(r=0;r<texty[i].length;r++)
{

var rtz="";
nhr=0;

for(s=0;s<texty[i][r]["sl"].length;s++)
	{

	//nove=nahradit(texty[i][r]["sl"][s].f);
	
	if(texty[i][r]["sl"][s][krit].match(zdroj)==texty[i][r]["sl"][s][krit])
	{
vyskyty.push(texty[i][r]["sl"][s]);
	
	$("#t"+i+"r"+r+"s"+s).addClass(jak);
		//rtz+="<span class="+barva+">"+nove+"</span> ";
		//nhr=1;
	}
	//else
	//{
	//rtz+=nove+" ";	
	//}
	
	}
	
	//if(nhr==1)
	//{
	//$("#t"+i+"r"+r).html(rtz);	
	//}

}

	
}

}

function bublina(napis)
{

$("#vybran").remove();
$("body").append("<span id='vybran'  style='position:absolute; left:0; top:0;background-color:rgba(44,130,205,0.8); font-weight:bold; border-radius:0.2em; padding:0.2em;'>"+napis+"</span>");

	
}



 //&t[]=9&t[]=7&t[]=5&t[]=6&t[]=4&t[]=8

 
var lsc=spellingy();
 
 //$("body").append("<table id=lsc></table>");
 
// for(s=0;s<lsc.length;s++)
// {
//	$("#lsc").append("<tr class=blue><th ng-click='prirad("+lsc[s]+")'>"+lsc[s].l+" <td>"+lsc[s].c+"<th>{{phgrs["+s+"].rps}}");	
 //}
 
 //ph_list(grphs);
 
 function ph_list(szn)
 {
	$("body").append("<table id=phlist><tr><td colspan=51>----<tr><td colspan=51>ME PHONEMES<tr id=fonemy><tr id=grafemy></table>");
 
 for(s=0;s<szn.length;s++)
 {
	$("#fonemy").append("<th>"+szn[s].ph);	
	
 }
 
  for(s=0;s<51;s++)
 {
	$("#grafemy").append("<td>");	
 }
 }
 
 //  for(g in phgrs)
 //{
	
//	$("#phlist").after("{gr:'"+g+"',ph:["+zretezit(phgrs[g].ph)+"]},<br></br>");
// }
 
 function zretezit(pol)
 {
 var zretezeno="";
	for(p=0;p<pol.length;p++)
	{
	zretezeno+="'"+pol[p]+"',";	
	}
	
	return zretezeno;
 }
 
 
</script>

</body>
</html>
