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
     
    



$corp = file("txt/laeme_wcounts.txt");

$str = implode("",$corp);


 $corp = explode("#",$str);

$whash=array();

for($i=0;$i<count($corp);$i++)
{
  $pole = explode(":",$corp[$i]);
   
   $whash[trim($pole[0])]=trim($pole[1]);
 
 echo("\$whash[".trim($pole[0])."]=".trim($pole[1]).";<br>");
   
  }

 

?>


</body>
</html>