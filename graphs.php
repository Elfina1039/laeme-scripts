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

$trid=$_POST["trid"];

$xml1A;
$xml1B;
$xml2A;
$xml2B;

$cisla=Array();
$popisky=Array();

loadfiles($query1, $query2);

loadblock($trid);

table($popisky, $cisla);

function loadfiles($q1,$q2)
{
global $xml1A, $xml1B, $xml2A, $xml2B;


$xml1A = simplexml_load_file("xml/corpa_".$q1.".xml");
$xml1B=simplexml_load_file("xml/corpb_".$q1.".xml");
$xml2A=simplexml_load_file("xml/corpa_".$q2.".xml");
$xml2B=simplexml_load_file("xml/corpb_".$q2.".xml");

echo ("XML files loaded.<br>");

}

function loadblock($trid)
{
global $xml1A, $xml1B, $xml2A, $xml2B, $cisla, $popisky;

echo("criterion1: ".$trid."<br>");
$block1A=$xml1A->xpath("/frequency/block[name='$trid']/items");
$block1B=$xml1B->xpath("/frequency/block[name='$trid']/items");
$block2A=$xml2A->xpath("/frequency/block[name='$trid']/items");
$block2B=$xml2B->xpath("/frequency/block[name='$trid']/items");

$i=0;

echo($block1A[0]->item[0]->str);

foreach($block2A[0]->item as $kat)
{
$popisky[$i]=$kat->str;
$i++;

}

foreach($popisky as $p)
{

$freq1 = $block1A[0]->xpath("item[str='".$p."']");
$freq2 = $block2A[0]->xpath("item[str='".$p."']");

$f1=$freq1[0]->freq;
$f2=$freq2[0]->freq;

echo("<b>cat:".$p."</b><br>");
echo("f1:".$f1."<br>");
echo("f2:".$f2."<br>");

$cisla["sk1"]["c"]["$p"] = $f1/($f1+$f2);

$cisla["sk1"]["f1"]["$p"] = $f1;
$cisla["sk1"]["f2"]["$p"] = $f2;

echo($cisla["sk1"]["$p"] ."<br>");

}

foreach($popisky as $p)
{

$freq1 = $block1B[0]->xpath("item[str='".$p."']");
$freq2 = $block2B[0]->xpath("item[str='".$p."']");
echo("<b>cat:".$p."</b><br>");
$f1=$freq1[0]->freq;
$f2=$freq2[0]->freq;

echo("f1:".$f1."<br>");
echo("f2:".$f2."<br>");

$cisla["sk2"]["c"]["$p"] = $f1/($f1+$f2);

$cisla["sk2"]["f1"]["$p"] = $f1;
$cisla["sk2"]["f2"]["$p"] = $f2;

echo($cisla["sk2"]["$p"] ."<br>");

}


}

function table($ps,$cs)
{

echo("<table border=1>");
echo("<tr><th>Category<th>subcorpus 1<th>subcorpus 2");
foreach($ps as $p)
{
echo("<tr><th>$p<td>".$cs["sk1"]["c"]["$p"]."<td>".$cs["sk2"]["c"]["$p"]);
}

echo("</table>");

echo("<table border=1>");
echo("<tr><th>Category<th colspan=2>subcorpus 1<th colspan=2>subcorpus 2");
foreach($ps as $p)
{
echo("<tr><th>$p<td>".$cs["sk1"]["f1"]["$p"]."<td>".
                $cs["sk1"]["f2"]["$p"]."<td>".
                $cs["sk2"]["f1"]["$p"]."<td>".
                $cs["sk2"]["f2"]["$p"]);
}

echo("</table>");

}


?>



  </body>
</html>
