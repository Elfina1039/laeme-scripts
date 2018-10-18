<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  </head>
  <body>
  
  
  <?php
header("Content-Type: text/html; charset=UTF-8");

$query1=$_POST["query1"];
$query2=$_POST["query2"];

$xml1A;
$xml1B;
$xml2A;
$xml2B;

loadfiles($query1, $query2);

function loadfiles($q1,$q2)
{
global $xml1A, $xml1B, $xml2A, $xml2B;

$xml1A = simplexml_load_file("xml/corpa_".$q1.".xml");
$xml1B=simplexml_load_file("xml/corpb_".$q1.".xml");
$xml2A=simplexml_load_file("xml/corpa_".$q2.".xml");
$xml2B=simplexml_load_file("xml/corpb_".$q2.".xml");

echo ("XML files loaded.<br>");

$kriteria = $xml1A->xpath("/frequency/block");

echo("<form name=trideni action=graphs.php method=post>Sort by:<br>");

foreach($kriteria as $k)
{
echo ("<input type=radio name=trid value=".$k->name.">".$k->name."<br>");

}
echo("<input type=hidden name=query1 value=$q1>");
echo("<input type=hidden name=query2 value=$q2>");



echo("<input type=submit value=Sort></form>");




}


?>



  </body>
</html>
