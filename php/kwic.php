<style>
td{vertical-align:top}
</style>

<?php


 header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");

$id = $_GET["id"]; 



   
  $hledej=pg_prepare($pg,"hledej", "SELECT form, grammel, lexel  FROM new_laeme WHERE id<($1+10) AND id>($1-10) ORDER BY id");


  
  $dotaz = pg_execute($pg,"hledej",array($id));
    
   vycet($dotaz);



function vycet($dotaz)
{

  $d = pg_fetch_array($dotaz);   
  
  
  
  while(is_array($d))
  {
  echo($d["form"]." ");
  $d = pg_fetch_array($dotaz);
  
 
  }
  
  }
  



?>
