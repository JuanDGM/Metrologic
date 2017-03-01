

<?php
include('./conexion.php');
$con=  conectar();

$codHV=$_POST['codigoEquipo'];

$querySeleccionarImagen="SELECT Ruta FROM imagenes_equipos WHERE No_HV='$codHV'";
$datosSeleccionarImagen=mysql_query($querySeleccionarImagen, $con);

while($arraySeleccionarImagen=mysql_fetch_array($datosSeleccionarImagen)){
    
    $Ruta=$arraySeleccionarImagen['Ruta'];
}

echo json_encode($Ruta);

?>