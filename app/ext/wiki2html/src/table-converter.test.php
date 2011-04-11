<?php

//include("table-converter.inc.php");
include("parseRaw.inc.php");
if(empty($_GET['n'])) $_GET['n']=1;
$text = file_get_contents("table-example-".$_GET['n'].".txt");

echo convertTables($text);
?>
