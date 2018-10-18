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
     
    



$corp = file("txt/fcounts.txt");

$str = implode("",$corp);

$radky=explode(")",$str);



$whash=array();

foreach($radky as $r)
{
   $pole = preg_split("/f|w/",$r);
   
   $whash[trim($pole[0])]=trim($pole[2]);
 
 echo("\$whash[".trim($pole[0])."]=".trim($pole[2]).";<br>");
   
  }

 

?>


</body>
</html>