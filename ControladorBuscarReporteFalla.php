<?php
include_once('./conexion.php');
$con=  conectar();
        
$CodigoReporte=$_POST['valor'];

//$deco=json_decode($CodigoReporte);

//$codReporte=$deco[0]->value;

$querySeleccionReporte="SELECT 
	Id,
        Cod_Reporte,
	HV_Equipo, 
	Estado_Equipo, 
	Descripcion, 
	Fecha_Fallo_Equipo, 
	Nombre_Reporta, 
	Prioridad 
FROM 
	reporte_fallas_equipos 
WHERE 
	Cod_Reporte = '$CodigoReporte'";


$conexionSeleccionReporte=mysql_query($querySeleccionReporte, $con);

while($arraySeleccionReporte=mysql_fetch_array($conexionSeleccionReporte)){
    
    $CodReportesql=$arraySeleccionReporte['Cod_Reporte'];
    $CodHV=$arraySeleccionReporte['HV_Equipo'];
    $EstadoEquipo=$arraySeleccionReporte['Estado_Equipo'];
    $descripcion=$arraySeleccionReporte['Descripcion'];
    $fechaFalla=$arraySeleccionReporte['Fecha_Fallo_Equipo'];
    $nombreRporta=$arraySeleccionReporte['Nombre_Reporta'];
    $prioridad=$arraySeleccionReporte['Prioridad'];
    
}

$arrayReporte=array('codhv'=>$CodHV,'EstadoEquipo'=>$EstadoEquipo,'descripcionjson'=>$descripcion,'fechaFalla'=>$fechaFalla,'nombreRporta'=>$nombreRporta,'prioridad'=>$prioridad,'codReporte'=>$CodReportesql);

echo json_encode($arrayReporte);


?>