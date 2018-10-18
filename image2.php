

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
  
$conn = pg_pconnect("dbname=agys user=postgres password=postgres host=localhost port=5432");

if(!$conn)
{
echo ("Nepovedlo se připojit");
}
else 
{
echo ("připojeno");
}



$query = pg_prepare($conn, "vlozit","INSERT INTO soubory (name, image) VALUES ($1,$2)");
$result = pg_execute($conn,"vlozit", array($name, lo_import($uploadfile)));

if($result)
{
    echo "File is valid, and was successfully uploaded.\n";
    unlink($uploadfile);
}
else
{
    echo "Filename already exists. Use another filename. Enter all the values.";
    unlink($uploadfile);
}
pg_close($conn);

?>