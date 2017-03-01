<?php

include('./conexion.php');
$con=  conectar();

$datosFormulario=$_POST['datosFormulario'];

$encode=json_encode($datosFormulario);
$decode=  json_decode($encode);

$HV=$decode[0]->value;
$codigoReporte=$decode[1]->value;

$queryMaxVersionManto="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='Mantenimiento preventivo'";
$queryMaxVersionVerificacion="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='Verificacion'";
$queryMaxVersionCalibracion="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='Calibracion'";
$queryMaxVersionCalificacion="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='Calificacion'";
$queryMaxVersionIntervencionOtro="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";

$conexionQueryVersionManto=mysql_query($queryMaxVersionManto, $con);
$conexionQueryVersionVerificacion=mysql_query($queryMaxVersionVerificacion, $con);
$conexionQueryVersionCalibracion=mysql_query($queryMaxVersionCalibracion, $con);
$conexionQueryVersionCalificacion=mysql_query($queryMaxVersionCalificacion, $con);
$conexionQueryVersionIntervencionOtro=mysql_query($queryMaxVersionIntervencionOtro, $con);

$Tipo_Intervencion=$decode[2]->value;
$Fecha_intervencion=$decode[3]->value;
$Provedor=$decode[4]->value;
$Tecnico=$decode[5]->value;
$EstadoIntervencion=$decode[6]->value;
$TiempoIntervencion=$decode[7]->value;
$CostoIntervencion=$decode[8]->value;
$NombreRecibe=$decode[9]->value;
$descripcion=$decode[10]->value;

$time=  time();
$fecharegistro=date("Y-m-d", $time);

if($Tipo_Intervencion=='Mantenimiento preventivo'){
    while($array_VersionManto=  mysql_fetch_array($conexionQueryVersionManto)){
    $MaxVersionIntervencion=$array_VersionManto['MAX(Version_Intervencion)'];
    //$MaxVersionManto=$array_VersionManto[0];
    }
} else if ($Tipo_Intervencion=='Verificacion'){
    while($array_VersionVerificacion=  mysql_fetch_array($conexionQueryVersionVerificacion)){
    $MaxVersionIntervencion=$array_VersionVerificacion['MAX(Version_Intervencion)'];
    //$MaxVersionVerificacion=$array_VersionVerificacion[0];
    }
}else if ($Tipo_Intervencion=='Calibracion'){
    while($array_VersionCalibracion=  mysql_fetch_array($conexionQueryVersionCalibracion)){
    $MaxVersionIntervencion=$array_VersionCalibracion['MAX(Version_Intervencion)'];
    //$MaxVersionCalibracion=$array_VersionCalibracion[0];
    }   
}else if ($Tipo_Intervencion=='Calificacion'){
    while($array_VersionCalificacion=  mysql_fetch_array($conexionQueryVersionCalificacion)){
    $MaxVersionIntervencion=$array_VersionCalificacion['MAX(Version_Intervencion)'];
    //$MaxVersionCalificacion=$array_VersionCalificacion[0];
    }
} else {
    while($array_VersionIntervencionOtro=  mysql_fetch_array($conexionQueryVersionIntervencionOtro)){
    $MaxVersionIntervencion=$array_VersionIntervencionOtro['MAX(Version_Intervencion)'];
    //$MaxVersionIntervencionOtro=$array_VersionIntervencionOtro[0];
    }
}


if($Tipo_Intervencion=="Mantenimiento correctivo"){
    
    
    $queryMaxIdReporteFallaEquipo="SELECT 
                                        Id,
                                        Cod_Reporte
                                FROM 
                                        reporte_fallas_equipos 
                                WHERE 
                                        CONCAT('$HV', Fecha_Reporte) IN (
                                                SELECT 
                                                        CONCAT(
                                                                '$HV', 
                                                                MAX(Fecha_Reporte)
                                                        ) 
                                                FROM 
                                                        reporte_fallas_equipos 
                                                GROUP BY 
                                                        HV_Equipo
                                        ) && HV_Equipo = '$HV' && Fecha_Ejecutado = '0000-00-00'";
    
    
    $conexionMaxIdReporteFallaEquipo=mysql_query($queryMaxIdReporteFallaEquipo, $con);
    
    while($arrayMaxIdReporteFallaEquipo=mysql_fetch_array($conexionMaxIdReporteFallaEquipo)){
        $MaxIdReporte=$arrayMaxIdReporteFallaEquipo['Id'];
        $CodReporteFalla=$arrayMaxIdReporteFallaEquipo['Cod_Reporte'];
    }
    
    $queryActualizarFechaIntervencion="UPDATE reporte_fallas_equipos SET Fecha_Ejecutado='$fecharegistro' WHERE Id='$MaxIdReporte'";
    $conexionActualizarFechaIntervencion=mysql_query($queryActualizarFechaIntervencion, $con);
    }

    $NuevaVersion=$MaxVersionIntervencion + 1;

    // INDENTIFICAR LA FECHA ESPERADA DE INTERVENCION AL EQUIPO
    
    $queryFechaPuestaMarcha="SELECT MAX(Fecha_Marcha) FROM puesta_marcha WHERE No_HV='$HV'";
    $conexionFechaPuestaMarcha=mysql_query($queryFechaPuestaMarcha, $con);
    while($arrayFechaMarcha=mysql_fetch_array($conexionFechaPuestaMarcha)){
        $UltimaFechaPuesta_Marcha=$arrayFechaMarcha['MAX(Fecha_Marcha)'];
    
        
    }
    $queryMaxFechaIntervencion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='$Tipo_Intervencion'";
    $conexionQueryMaxFechaIntervencion=  mysql_query($queryMaxFechaIntervencion, $con);
    while($arrayQueryMaxFechaIntervencion=  mysql_fetch_array($conexionQueryMaxFechaIntervencion)){
       echo $UltimaIntervencionRealizada=$arrayQueryMaxFechaIntervencion['MAX(Fecha_Intervencion)'];
      
    }
    
    $queryFrecuenciaIntervencion="SELECT 
	DISTINCT Frecuencia 
FROM 
	intervenciones 
WHERE 
	HV_Equipo = '$HV' && Tipo_Intervencion = '$Tipo_Intervencion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo, 
			Tipo_Intervencion
	)";
    
    $conexionQueryFrecuenciaIntervencion=  mysql_query($queryFrecuenciaIntervencion, $con);
    while($arrayQueryFrecuenciaIntervencion=  mysql_fetch_array($conexionQueryFrecuenciaIntervencion)){
       $frecuenciaIntervencion=$arrayQueryFrecuenciaIntervencion['Frecuencia'];
    }
    
    if($UltimaIntervencionRealizada==""){
        $Fecha_Esperada=$UltimaFechaPuesta_Marcha;
       
       
    }else if($UltimaIntervencionRealizada!="NULL" || $UltimaIntervencionRealizada!="0000-00-00" || $UltimaIntervencionRealizada!="") {
        $Fecha_Esperada=date('Y-m-d',  strtotime("$UltimaIntervencionRealizada + $frecuenciaIntervencion days"));
        
    }
    
 if(isset($Fecha_Esperada) && $Fecha_Esperada!="0000-00-00"){
 
     
     $Cod_Mes_Esperado=date("m",  strtotime($Fecha_Esperada));
     
$queryGuardarReporte="INSERT INTO reportes_intervencion (No_Intervencion,Cod_Reporte_Falla,HV_Equipo,Version_Intervencion,Tipo_Intervencion,Fecha_Esperada,Fecha_Intervencion,Descripcion,Nombre_Proveedor,Nombre_Tecnico,Nombre_Recibe_Trabajo,Estado_Equipo,Fecha_Registro,Estado_Intervencion,Tiempo_Intervencion,Costo_Intervencion,Cod_Mes_Esperado) VALUES ('$codigoReporte','$CodReporteFalla','$HV','$NuevaVersion','$Tipo_Intervencion','$Fecha_Esperada','$Fecha_intervencion','$descripcion','$Provedor','$Tecnico','$NombreRecibe','$EstadoIntervencion','$fecharegistro','','$TiempoIntervencion','$CostoIntervencion','$Cod_Mes_Esperado')";
$conexionqueryReporte=  mysql_query($queryGuardarReporte, $con);
    
if(isset($conexionqueryReporte)){
    if(isset($MaxVersionIntervencion)){
        $v=$MaxVersionIntervencion;
    }else{
        $v=1;
    }
        // Identificar el codigo de registro en tabla de programacion_intervencion a reemplazar
    //$queryIdxReemplazarProgramacion="SELECT * FROM programacion_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='$Tipo_Intervencion' && Version_Intervencion='$MaxVersionIntervencion'";
    $queryIdxReemplazarProgramacion="SELECT * FROM programacion_intervencion WHERE HV_Equipo='$HV' && Tipo_Intervencion='$Tipo_Intervencion' && Version_Intervencion='$v'";
    $conexionIdReemplazarProgramacion=mysql_query($queryIdxReemplazarProgramacion, $con);
    
    while($arrayIdReemplazar=mysql_fetch_array($conexionIdReemplazarProgramacion)){
        $IdReemplazar=$arrayIdReemplazar[0];
        }
        if(isset($IdReemplazar)){
        $queryReportarEjecucionProgramacion="UPDATE programacion_intervencion SET Fecha_Realizacion='$Fecha_intervencion',Estado='Finalizado' WHERE Id='$IdReemplazar'";
        mysql_query($queryReportarEjecucionProgramacion, $con);
        }
        echo json_encode("REPORTE GUARDADO CORRECTAMENTE!");
}else{
        echo json_encode("FALLAS EN LA CONEXION, EL REPORTE NO SE GUARDO");    
    }
    }
?>