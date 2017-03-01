<?php
include('./conexion.php');
$con=  conectar();

$ciudadSeleccionada=$_POST['ciudad'];

$querySeleccionCiudad="SELECT 
	Sede 
FROM 
	ubicaciones 
WHERE 
	1
GROUP BY Sede";

$conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);



?>