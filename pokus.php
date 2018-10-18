<?php

header("Content-Type: text/html; charset=UTF-8");
     
     $c="host=localhost port=5432 dbname=postgres user=postgres password=postgrass";

$pg=pg_connect($c);

if(!$pg) 
{
echo "Nepovedlo se pripojit!";
}

pg_set_client_encoding($pg, "UNICODE");


$zapis=pg_prepare($pg,"vloz", "INSERT INTO zaznamy (lexel,grammel,form,skup) VALUES ($1,$2,$3,$4)");

$doit=pg_execute($pg,"vloz",array("lex","gram","form","G"));


?>