<?php
include ('./conexion.php');
$con=  conectar();

$hv=$_POST['codigoHV'];
$FechaManto=$_POST['FechaMantoEspecifica'];

$queryInsertarMantoProgramado="INSERT INTO Programacion_Especifica(
                                        No_HV, Tipo_Intervenciones, Fecha_Programada
                                ) 
                                VALUES 
                                        ('$hv', 'Manto preventivo','$FechaManto')";


$conexion=mysql_query($queryInsertarMantoProgramado, $con);



echo json_encode($FechaManto);

?>