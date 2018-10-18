<html>
<head>

<style>

.mapka{position:absolute; left:0; top:0; width:600px; height:600px;background-color:rgba(0,0,0,0)}
.vyskyt{position:absolute; width:12px; height:12px; background-color:black; color:white;font-size:8pt;}

</style>

</head>

<body>



<?php


 header("Content-Type: text/html; charset=UTF-8");
     
    



$corp = file("txt/dating.txt");  


$str = implode("",$corp);


$prevod=array();
$prevod["C12a2"]=1;
$prevod["C12b1"]=2;
$prevod["C12b2"]=3;
$prevod["C13a1"]=4;
$prevod["C13a2"]=5;
$prevod["C13b1"]=6;
$prevod["C13b2"]=7;
$prevod["C14a1"]=8;
$prevod["C14a2"]=9;


$radky=explode("#",$str);



$dhash=array();

foreach($radky as $r)
{
   $pole = explode(":",$r);
   
   $dhash[trim($pole[0])]=trim($pole[1]);
 
 echo("\$dhash[".trim($pole[0])."]='".$dhash[trim($pole[0])]."';<br>");
   
  }

 

?>


</body>
</html>