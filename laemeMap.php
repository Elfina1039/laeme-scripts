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


<label>
<input type=button value=search onClick="vyhledej();">

</label>

</form>


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