<?php

echo("funguju");

$wlds = file("txt/wl_dstar.txt");
$wlt = file("txt/wl_telegraph.txt");




$wlds=array_map("strtolower",$wlds);
$wlt=array_map("strtolower",$wlt);

$wlds =array_unique($wlds);
$wlt=array_unique($wlt);

$unik = array_diff($wlt, $wlds);

foreach($unik as $u)
{
echo ($u."<br>");

}

?>
