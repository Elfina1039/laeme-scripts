<?php


//stare
    $xmla = simplexml_load_file('msindex.xml');
    
   echo($xmla->ms[0]->grid);
    $d=count($xmla->laeme[0]->ms);
  
    
    for($i=0;$i<=$d;$i++)
    {
     echo("MS: ". $xmla->laeme[0]->ms[i]->msname."<br>");
    
    }
    


?>

