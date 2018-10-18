<html>
<head>

<style>

*{box-sizing:border-box}
body,html{
	display:flex; flex-flow:row nowrap; height:100%;width:100%;
}

div.manuscript{font-size:12pt; }


.zelena{background-color:green; color:white}
.modra{background-color:blue; color:white}
.cervena{background-color:red;color:white}
.zluta{background-color:yellow; color:black;}

.lc{
	margin-left:0.5em; margin-right:0.5em; color:yellow;
}

div.pergamen{width:25%; border:2px solid orange; padding:1em; background:linear-gradient(orange,yellow); color:black; 
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
     
       <input type=text name=hledat id=hledat><input type=button value=OK onClick='zvyraznit()'>
	
 
    </div>
<script src="js/jquery.js"></script>
<script src="graphonemes.js"></script>

<script>
var texty=new Object();
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
	
    while(is_array($pl))
   {

   echo("slovo={l:'".$pl["lexel"]."',g:'".$pl["grammel"]."',f:'".$pl["form"]."'};");

     echo("texty[".$pl["text"]."][$lc].sl.push(slovo);");
	 
       if(fnmatch("*\{rh\}*", $pl["grammel"]))
     {
	   $lc++;
	    echo(   " texty[".$pl["text"]."][$lc]=new Object();
		 texty[".$pl["text"]."][$lc].sh=0;
		 texty[".$pl["text"]."][$lc].sl=new Array();");
	    
     }
   

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

$(".radek").click(function(){
	vyhledat(this.getAttribute("title"),this.getAttribute("data-t"));
});

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



function zvyraznit()
{
//var txt=document.getElementById("hledat"+zdroj).value;


zdroj=new RegExp($("#hledat").val());
krit=document.getElementById("field").value;



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

	
	$("#t"+i+"r"+r+"s"+s).addClass(barva);
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

 
 spellingy();
 
</script>

</body>
</html>
