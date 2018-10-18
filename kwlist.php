


<?php


$moff=file("txt/kw_davies_s.txt");

echo("<table border=1><tr>");

$x=1;

foreach ($moff as $m)
{

if($x>4)
{
echo("<tr>");
$x=1;
}



$kr = explode("\t",$m);

if($kr[2]>=20 && $kr[4]==3)
{
 echo("<td style='padding:5px'><h2>".$kr[3]."</h2><br>".$kr[2]." (".$kr[1].")");
 $x++;
}



}


?>