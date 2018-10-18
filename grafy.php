
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>MyLAEME</title>

  </head>
  
  <body>
  


<div id="hlavni">

<div id=vyvoj class=kontejner></div>
<div id=cviky class=kontejner></div>
<?php
	  

	header("Content-Type: text/html; charset=UTF-8");

 $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);
if(!$pg) 
{
echo "Nepovedlo se připojit!";
}

   include("datings.php");  

$vyvoj=pg_prepare($pg,"vyvoj","SELECT form, text FROM new_laeme WHERE lexel IN ('each','which','such','evereach')");


	$avt=pg_execute($pg,"vyvoj",array());
  $av=pg_fetch_array($avt);

  
  $cisla=array();
   $cisla["C12b1"]["c"]="C12b1";
  $cisla["C12b1"]["b"]=0;
  $cisla["C12b1"]["a"]=0;
  
    $cisla["C12b2"]["c"]="C12b2";
  $cisla["C12b2"]["b"]=0;
  $cisla["C12b2"]["a"]=0;
  
    $cisla["C13a1"]["c"]="C13a1";
  $cisla["C13a1"]["b"]=0;
  $cisla["C13a1"]["a"]=0;
  
    $cisla["C13a2"]["c"]="C13a2";
   $cisla["C13a2"]["b"]=0;
  $cisla["C13a2"]["a"]=0;
  
    $cisla["C13b1"]["c"]="C13b1";
   $cisla["C13b1"]["b"]=0;
  $cisla["C13b1"]["a"]=0;
 
  $cisla["C13b2"]["c"]="C13b2"; 
  $cisla["C13b2"]["b"]=0;
  $cisla["C13b2"]["a"]=0;
  
    $cisla["C14a1"]["c"]="C14a1";
  $cisla["C14a1"]["b"]=0;
  $cisla["C14a1"]["a"]=0;
  
    $cisla["C14a2"]["c"]="C14a2";
  $cisla["C14a2"]["b"]=0;
  $cisla["C14a2"]["a"]=0;

  
while(is_array($av))
{


if(fnmatch("*L*",$av["form"]))
{
 
 $cisla[$dhash[$av["text"]]]["a"]++;
}
else
{  

$cisla[$dhash[$av["text"]]]["b"]++;
}


  $av=pg_fetch_array($avt);	
}	
	
foreach($cisla as $obd)
{
	echo($obd["c"].":".procenta($obd["a"],$obd["b"])."<br>");
}
	
	
	//echo("udaje.push([new Date(".$dt[0].",".$dt[1].",".$dt[2]."),".$av["pocet"]."]);");	
	
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


<script src="js/jquery.js"></script>
<script src="js/skripty.js"></script>


 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
	var udaje=new Array(["Period","percent"]);

	
	
	
	
	
      google.charts.load('current', {'packages':['corechart','bar']});
      google.charts.setOnLoadCallback(function(){
	
	//drawChart("BarChart",cviky,{title:"Exercises statistics"},"cviky");
	//	drawChart("LineChart",udaje,{title: 'My workouts',curveType: 'function',legend: { position: 'bottom' }, pointSize:10},"vyvoj");
			
	  });

      function drawChart(graf,pole,options,misto) {
	
        var data = google.visualization.arrayToDataTable(pole);

        var chart = new google.visualization[graf](document.getElementById(misto));

        chart.draw(data, options);
      }






function zkontrolovat(str)
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
xmlhttp.open("GET","ajaxl.php?q="+str,true);
xmlhttp.send();
}




</script>


</div>
  </body>
</html>
