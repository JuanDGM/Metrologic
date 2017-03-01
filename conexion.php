<?php

function conectar (){
    $nombre="root";
    $pass="";
    $server="localhost";
    $db="metrologic"; 
    $con= mysql_connect($server, $nombre, $pass);
    mysql_select_db($db, $con);
    return $con;
}
?>
