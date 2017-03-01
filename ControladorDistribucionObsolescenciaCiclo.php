<?php
include ('./conexion.php');
$con=  conectar();
        
$ciclo=$_POST['ciclo'];


$queryDistribucionCicloVerde="SELECT 
	Indice_Cualitativo, 
	COUNT(Cod_Equipo) AS cantidad 
FROM 
	obsolescencia 
WHERE 
	Ciclo_Obsolescencia = '$ciclo' && Indice_Cualitativo = 'Tecnología NO requiere evaluación ni renovación'";

$queryDistribucionCicloAzul="SELECT 
	Indice_Cualitativo, 
	COUNT(Cod_Equipo) AS cantidad
FROM 
	obsolescencia 
WHERE 
	Ciclo_Obsolescencia = '$ciclo' && Indice_Cualitativo = 'Evaluar tecnología en un año'";

$queryDistribucionCicloAmarillo="SELECT 
	Indice_Cualitativo, 
	COUNT(Cod_Equipo) AS cantidad
FROM 
	obsolescencia 
WHERE 
	Ciclo_Obsolescencia = '$ciclo' && Indice_Cualitativo = 'Renovación de tecnología a la brevedad (Plazo inferior a un año)'";

$queryDistribucionCicloRojo="SELECT 
	Indice_Cualitativo, 
	COUNT(Cod_Equipo) AS cantidad
FROM 
	obsolescencia 
WHERE 
	Ciclo_Obsolescencia = '$ciclo' && Indice_Cualitativo = 'Reposición de tecnología (Inmediato)'";



$conexionVerde=mysql_query($queryDistribucionCicloVerde, $con);
$conexionAzul=mysql_query($queryDistribucionCicloAzul, $con);
$conexionAmarillo=mysql_query($queryDistribucionCicloAmarillo, $con);
$conexionRojo=mysql_query($queryDistribucionCicloRojo, $con);

while($arrayVerde=mysql_fetch_array($conexionVerde)){
    $CantidadVerde=$arrayVerde['cantidad'];
}
while($arrayAzul=mysql_fetch_array($conexionAzul)){
    $CantidadAzul=$arrayAzul['cantidad'];
}
while($arrayAmarillo=mysql_fetch_array($conexionAmarillo)){
    $CantidadAmarillo=$arrayAmarillo['cantidad'];
}
while($arrayRojo=mysql_fetch_array($conexionRojo)){
    $CantidadRojo=$arrayRojo['cantidad'];
}
    

$array=array('Verde'=>$CantidadVerde,'Azul'=>$CantidadAzul,'Amarillo'=>$CantidadAmarillo,'Rojo'=>$CantidadRojo);

echo json_encode($array);

?>

