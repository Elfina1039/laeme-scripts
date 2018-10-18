<?php

srovnej_fd("freq_totally.xml",'freq_absolutely.xml','freq_completely.xml', "TOTALLY",50);
srovnej_fd('freq_absolutely.xml',"freq_totally.xml",'freq_completely.xml', "ABSOLUTELY",50);
srovnej_fd('freq_completely.xml',"freq_totally.xml",'freq_absolutely.xml', "COMPLETELY",50);

srovnej_coll("coll_totally.xml",'coll_absolutely.xml','coll_completely.xml', "TOTALLY",7);
srovnej_coll('coll_absolutely.xml',"coll_totally.xml",'coll_completely.xml', "ABSOLUTELY",7);
srovnej_coll('coll_completely.xml',"coll_totally.xml",'coll_absolutely.xml', "COMPLETELY",7);

function srovnej_fd($xml1,$xml2,$xml3,$slovo,$minf)
{
//stare
    $xmla = simplexml_load_file('xml/'.$xml1);
    
    $poleA=Array();
    
    $d=count($xmla->block[0]->items[0]->item);
    
  
    
    for($i=0;$i<=$d;$i++)
    {
    if(($xmla->block[0]->items[0]->item[$i]->freq)>$minf)
    {
    $poleA[$i]=strtolower($xmla->block[0]->items[0]->item[$i]->str);
    }
    
   
    }
    


//poleB
$xmlb = simplexml_load_file('xml/'.$xml2);
    
    $poleB=Array();
    
    $d=count($xmlb->block[0]->items[0]->item);
   
    
    for($i=0;$i<=$d;$i++)
    {
    if(($xmlb->block[0]->items[0]->item[$i]->freq)>$minf)
    {
    $poleB[$i]=strtolower($xmlb->block[0]->items[0]->item[$i]->str);
    }
    }
    
    //poleC
$xmlc = simplexml_load_file('xml/'.$xml3);
    
    $poleC=Array();
    
    $d=count($xmlb->block[0]->items[0]->item);
   
    
    
    for($i=0;$i<=$d;$i++)
    {
    if(($xmlc->block[0]->items[0]->item[$i]->freq)>$minf)
    {
    $poleC[$i]=strtolower($xmlc->block[0]->items[0]->item[$i]->str);
   }
    }
    
      $poleB=array_merge($poleB,$poleC);

echo("<h1>Results for:" . $slovo. "</h1>");

$unik = array_diff($poleA, $poleB);


echo("Unique:".count($unik)."<br>");
    
foreach($unik as $u)
{
echo($u.", ");
}
}

function srovnej_coll($xml1,$xml2,$xml3,$slovo,$mins)
{
//stare
    $xmla = simplexml_load_file('xml/'.$xml1);
    
    $poleA=Array();
    
   
    $d=count($xmla->items[0]->item);
  
    
    for($i=0;$i<=$d;$i++)
    {
      if(($xmla->items[0]->item[$i]->score)>$mins)
       {
       $poleA[$i]=strtolower($xmla->items[0]->item[$i]->str);
       }
    
    }
    


//pole 2
$xmlb = simplexml_load_file('xml/'.$xml2);
    
    $poleB=Array();
    
   
    $d=count($xmlb->items[0]->item);
    
    
    for($i=0;$i<=$d;$i++)
    {
   if(($xmlb->items[0]->item[$i]->score)>$mins)
       {
    $poleB[$i]=strtolower($xmlb->items[0]->item[$i]->str);
    
    }
    }
    
    //pole 3
$xmlc = simplexml_load_file('xml/'.$xml3);
    
    $poleC=Array();
    
   
    $d=count($xmlc->items[0]->item);
    
    
    for($i=0;$i<=$d;$i++)
    {
   if(($xmlc->items[0]->item[$i]->score)>$mins)
       {
    $poleC[$i]=strtolower($xmlc->items[0]->item[$i]->str);
    
    }
    }
    
    $poleB=array_merge($poleB,$poleC);

echo("<h1>Results for:" . $slovo. "</h1>");

$unik = array_diff($poleA, $poleB);

echo("Unique collocations:".count($unik)."<br>");
    
foreach($unik as $u)
{
echo($u.", ");
}

$spol= array_intersect($poleA, $poleB);

echo("Common collocations:".count($spol)."<br>");
    
foreach($spol as $s)
{
echo($s.", ");
}
}
?>

