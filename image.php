

<?php
header("Content-Type: text/html; charset=UTF-8");

$uploaddir = 'xml/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$name = $_POST['name'];

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
{   // echo "File is valid, and was successfully uploaded.\n";
echo ("ok");
}
else   {   echo "File size greater than 300kb!\n\n";   }

echo ($uploadfile);

$xmla = simplexml_load_file($uploadfile);
    
    $poleA=Array();
    
    $d=count($xmla->block[0]->items[0]->item);
    
  
    
    for($i=0;$i<=$d;$i++)
    {
    if(($xmla->block[0]->items[0]->item[$i]->freq)>$minf)
    {
    $poleA[$i]=strtolower($xmla->block[0]->items[0]->item[$i]->str);
    echo($poleA[$i]);
    }
    }
  


?>