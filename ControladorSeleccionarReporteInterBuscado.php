<?php
    require_once ('./conexion.php');
    $con=  conectar();
    
    $codReporte=$_POST['codigoReporte'];
    $encode=json_encode($codReporte);
    $deco=  json_decode($encode);
    
    $codEquipoBuscado=$deco[0]->value;
    
    $querySeleccionReporteBuscado="SELECT 
	HV_Equipo, 
	Tipo_Intervencion, 
	Fecha_Intervencion, 
	Nombre_Proveedor, 
	Nombre_Tecnico, 
	Estado_Equipo, 
	Nombre_Recibe_Trabajo, 
	Descripcion, 
	Tiempo_Intervencion, 
	Costo_Intervencion 
FROM 
	reportes_intervencion 
WHERE 
	No_Intervencion='$codEquipoBuscado'";
    
    $conexionReporteBuscado=mysql_query($querySeleccionReporteBuscado, $con);
    
    while($arrayReporteBuscado=mysql_fetch_array($conexionReporteBuscado)){
        $HVEquipo=$arrayReporteBuscado['HV_Equipo'];
        $TipoIntervencion=$arrayReporteBuscado['Tipo_Intervencion']; 
	$FechaIntervencion=$arrayReporteBuscado['Fecha_Intervencion']; 
	$NombreProveedor=$arrayReporteBuscado['Nombre_Proveedor']; 
	$NombreTecnico=$arrayReporteBuscado['Nombre_Tecnico']; 
	$estadoEquipo=$arrayReporteBuscado['Estado_Equipo']; 
	$NombreRecibe=$arrayReporteBuscado['Nombre_Recibe_Trabajo']; 
	$descripcion=$arrayReporteBuscado['Descripcion']; 
	$TiempoIntervencion=$arrayReporteBuscado['Tiempo_Intervencion']; 
	$CostoIntervencion=$arrayReporteBuscado['Costo_Intervencion'];
    }
    
    $array=array(
            'codigoEquipo'=>$HVEquipo,
            'tipoIntervencion'=>$TipoIntervencion,
            'fechaIntervencion'=>$FechaIntervencion,
            'nombreProveedor'=>$NombreProveedor,
            'nombreTecnico'=>$NombreTecnico,
            'estadoEquipo'=>$estadoEquipo,
            'nombreRecibe'=>$NombreRecibe,
            'descripcion'=>$descripcion,
            'tiempoIntervencion'=>$TiempoIntervencion,
            'costoIntervencion'=>$CostoIntervencion,
                );
    
    echo json_encode($array);
    
?>