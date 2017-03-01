<?php


//$Posicion=$_POST['position'];

$archivo=$_POST['archivo'];

$file=file($archivo);
$file2=  implode("", $file);

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment;filename=$archivo");

echo $file2;

?>