<?php

include('./conexion.php');
$con=  conectar();
// Esta clase se ejecuta desde el archivo editarHV.js
$DatosEditar=$_POST['datosformulario'];
$nohv=$_POST['CodHV']; 

echo $encode=json_encode($DatosEditar);
$decode=  json_decode($encode);

// SELECCIONAR LA MAXIMA VERSION DE PUESTA EN MARCHA PARA ASOCIAR A INTERVENCIONES Y EDITAR UBICACION
$queryVersionUbicacion="SELECT MAX(Version) FROM puesta_marcha WHERE No_HV='$nohv'";
$queryVersionIntervencion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='$nohv'";
$conexionVersionUbicacion=mysql_query($queryVersionUbicacion, $con);
$conexionVersionIntervencion=mysql_query($queryVersionIntervencion, $con);
while($ArrayVersionUbicacion= mysql_fetch_array($conexionVersionUbicacion)){
    $maxVersionUbicacion=$ArrayVersionUbicacion['MAX(Version)'];
}
while($ArrayVersionIntervencion= mysql_fetch_array($conexionVersionIntervencion)){
    $maxVersionIntervencion=$ArrayVersionIntervencion['MAX(Version_Intervencion)'];
}

//NUEVOS NUMEROS DE VERSION A INGRESAR

$NuevaVersionUbicacion=$maxVersionUbicacion+1;
$NuevaVersionInvervencion=$maxVersionIntervencion+1;

// ASIGNAR VARIABLES DEL FORMULARIO PASADAS POR JSON


$tipoequipo= $decode[3]->value;
$nombreequipo= $decode[4]->value;
$nombreproveedor= $decode[5]->value;
$nombremodelo= $decode[6]->value;
$serie = $decode[7]->value;
$marca= $decode[8]->value;
$voltaje = $decode[9]->value;
$amperaje = $decode[10]->value;
$potencia = $decode[11]->value;
$caracteristicas= $decode[12]->value;

$RazonSocialProveedor= $decode[13]->value;
$nitProveedor= $decode[14]->value;
$CiudadProveedor= $decode[15]->value;
$DireccionProveedor= $decode[16]->value;
$telefonoProveedor= $decode[17]->value;
$CelularProveedor= $decode[18]->value;
$registroInvima= $decode[19]->value;
$inversion= $decode[20]->value;
$edadEquipo= $decode[21]->value;
$VidaContable= $decode[22]->value;
$dispSoporteRepuestos= $decode[23]->value;
$DispoSoporteConsumibles= $decode[24]->value;
$DispoSoporteTecnicoRepuestos= $decode[25]->value;

$Sede= $decode[26]->value;
$Area= $decode[27]->value;
$SubArea= $decode[28]->value;
$Fecha_Marcha= $decode[29]->value;
$Fecha_Descarte= $decode[30]->value;


$mantenimiento= $decode[31]->value;
$InicioManto=$decode[32]->value;
$verificacion= $decode[33]->value;
$InicionVerificacion=$decode[34]->value;
$calibracion= $decode[35]->value;
$InicioCalibracion=$decode[36]->value;
$calificacion= $decode[37]->value;
$InicionCalificacion=$decode[38]->value;
$intervencionOtro= $decode[39]->value;
$frecuenciaOtro= $decode[40]->value;
$InicionOtro=$decode[41]->value;
// Reemplaza en la base de datos, los nuevos valores sin realizar ningun ajuste en la version.
// --Esto para no recargar esta tabla de datos.

$queryEdicion="UPDATE 
	hoja_vida 
SET 
	Tipo_Equipo = '$tipoequipo', 
	Nombre_Equipo = '$nombreequipo', 
	Nombre_Proveedor = '$nombreproveedor', 
	Modelo = '$nombremodelo', 
	No_Serie = '$serie', 
	Marca = '$marca', 
	Voltaje = '$voltaje', 
	Amperaje = '$amperaje', 
	Potencia = '$potencia', 
	Caracteristicas = '$caracteristicas',
        Razon_SocialProveedor='$RazonSocialProveedor',
        Nit_Proveedor='$nitProveedor',
        Ciudad_Proveedor='$CiudadProveedor',
        Direccion_Proveedor='$DireccionProveedor',
        Telefono_Proveedor='$telefonoProveedor',
        Celular_Proveedor='$CelularProveedor',
        Registro_Invima='$registroInvima',
        Inversion='$inversion',
        Edad_Equipo='$edadEquipo',
        Vida_Contable='$VidaContable',
        Disp_Soporte_Repuestos='$dispSoporteRepuestos',
        Disp_Soporte_Consumibles='$DispoSoporteConsumibles',
        Soporte_Tecnico_Respuestos='$DispoSoporteTecnicoRepuestos'
WHERE 
	No_HV='$nohv'";

$conexionEditar=mysql_query($queryEdicion,$con);

// VERIFICAR SI EXISTEN CAMBIOS EN LA TABLA DE puesta_marcha

$queryEquipoUbicado="SELECT DISTINCT No_HV FROM puesta_marcha WHERE No_HV='$nohv'";
$conexionExisteHv=mysql_query($queryEquipoUbicado, $con);
while($ArrayExisteHV=  mysql_fetch_array($conexionExisteHv)){
    $codigoHV=$ArrayExisteHV['No_HV'];
}
if(isset($codigoHV)==$nohv){
    
$querycambiosUbicacion="SELECT Sede,Area,SubArea, Fecha_Marcha,Fecha_Descarte FROM puesta_marcha WHERE No_HV='$nohv' && Version='$maxVersionUbicacion'";
$conexionCambiosUbicacion=mysql_query($querycambiosUbicacion, $con);

// Identificar los ultimos valores de ubicacion y fecha
    
    while($arrayCambiosUbicacion=mysql_fetch_array($conexionCambiosUbicacion)){
    $SedeActual=$arrayCambiosUbicacion['Sede'];
    $AreaActual=$arrayCambiosUbicacion['Area'];
    $SubAreaActual=$arrayCambiosUbicacion['SubArea'];
    $FechaActual=$arrayCambiosUbicacion['Fecha_Marcha'];
    $FechaDescarte=$arrayCambiosUbicacion['Fecha_Descarte'];
}
// Verificar cambios e incertar datos

if($SedeActual!=$Sede || $AreaActual!=$Area || $SubAreaActual!=$SubArea || $FechaActual!=$Fecha_Marcha || $Fecha_Descarte!=$FechaDescarte){

//$ConfirmarEdicionUbicacion=1;
    $queryEdicionUbicacion="INSERT INTO puesta_marcha (No_HV,Version,Sede,Area,SubArea,Fecha_Marcha,Fecha_Descarte) VALUES ('$nohv','$NuevaVersionUbicacion','$Sede','$Area','$SubArea','$Fecha_Marcha','$Fecha_Descarte')";
$conexionUbicacion=mysql_query($queryEdicionUbicacion, $con);        
}
    
}else if ($Sede!="" || $Area!="" || $SubArea!="" || $Fecha_Marcha!=""){
    $queryEdicionUbicacion="INSERT INTO puesta_marcha (No_HV,Version,Sede,Area,SubArea,Fecha_Marcha,Fecha_Descarte) VALUES ('$nohv','$NuevaVersionUbicacion','$Sede','$Area','$SubArea','$Fecha_Marcha','$Fecha_Descarte')";
$conexionUbicacion=mysql_query($queryEdicionUbicacion, $con);
}
// ---fin validador de cambios puesta_marcha


// VERIFICAR SI EXISTEN CAMBIOS EN LA TABLA DE intervenciones

$queryEquipoIntervencion="SELECT DISTINCT HV_Equipo FROM intervenciones WHERE HV_Equipo='$nohv'";
$conexionExisteHv=mysql_query($queryEquipoIntervencion, $con);
while($ArrayExisteHV=  mysql_fetch_array($conexionExisteHv)){
    $codigoHV=$ArrayExisteHV['HV_Equipo'];
}
if(isset($codigoHV)==$nohv){
    
$queryActualManto="SELECT Tipo_Intervencion, Frecuencia, MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='$nohv' && Version_Intervencion='$maxVersionIntervencion' && Tipo_Intervencion='Mantenimiento preventivo'";
$querycambiosVerificacion="SELECT Tipo_Intervencion, Frecuencia FROM intervenciones WHERE HV_Equipo='$nohv' && Version_Intervencion='$maxVersionIntervencion' && Tipo_Intervencion='Verificacion'";
$querycambiosCalibracion="SELECT Tipo_Intervencion, Frecuencia FROM intervenciones WHERE HV_Equipo='$nohv' && Version_Intervencion='$maxVersionIntervencion' && Tipo_Intervencion='Calibracion'";
$querycambiosCalificacion="SELECT Tipo_Intervencion, Frecuencia FROM intervenciones WHERE HV_Equipo='$nohv' && Version_Intervencion='$maxVersionIntervencion' && Tipo_Intervencion='Calificacion'";
$querycambiosOtro="SELECT Tipo_Intervencion, Frecuencia FROM intervenciones WHERE HV_Equipo='$nohv' && Version_Intervencion='$maxVersionIntervencion' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";


$conexionActualManto=mysql_query($queryActualManto, $con);
$conexionActualVerificacion=mysql_query($querycambiosVerificacion, $con);
$conexionActualCalibracion=mysql_query($querycambiosCalibracion, $con);
$conexionActualCalificacion=mysql_query($querycambiosCalificacion, $con);
$conexionActualOtro=mysql_query($querycambiosOtro, $con);

// Identificar los ultimos valores de intervencion en frecuencia y tipo de intervencion
    
    while($arrayActualManto=mysql_fetch_array($conexionActualManto)){
    $FrecuenciaActualManto=$arrayActualManto['Frecuencia'];
    }
    while($arrayActualVerificacion=mysql_fetch_array($conexionActualVerificacion)){
    $FrecuenciaActualVerificacion=$arrayActualVerificacion['Frecuencia'];
    }
    while($arrayActualCalibracion=mysql_fetch_array($conexionActualCalibracion)){
    $FrecuenciaActualCalibracion=$arrayActualCalibracion['Frecuencia'];
    }
    while($arrayActualCalificacion=mysql_fetch_array($conexionActualCalificacion)){
    $FrecuenciaActualCalificacion=$arrayActualCalificacion['Frecuencia'];
    }
    while($arrayActualOtro=mysql_fetch_array($conexionActualOtro)){
    $TipoIntervencionActualOtro=$arrayActualOtro['Tipo_Intervencion'];
    $FrecuenciaActualOtro=$arrayActualOtro['Frecuencia'];
    }
    
// Verificar cambios e incertar datos

if($FrecuenciaActualManto != $mantenimiento || 
   $FrecuenciaActualVerificacion != $verificacion ||
   $FrecuenciaActualCalibracion != $calibracion ||
   $FrecuenciaActualCalificacion != $calificacion ||
   $FrecuenciaActualOtro != $frecuenciaOtro ||
   $TipoIntervencionActualOtro != $intervencionOtro
    ){
    
//$ConfirmarEdicionUbicacion=1;
    $queryEdicionManto="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion, Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Mantenimiento preventivo','$mantenimiento','$InicioManto')";
    $queryEdicionIntervencionesVerificacion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion, Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Verificacion','$verificacion','$InicionVerificacion')";
    $queryEdicionIntervencionesCalibracion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion, Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Calibracion','$calibracion','$InicioCalibracion')";
    $queryEdicionIntervencionesCalificacion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion, Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Calificacion','$calificacion','$InicionCalificacion')";
    $queryEdicionIntervencionesOtro="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion, Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','$intervencionOtro','$frecuenciaOtro','$InicionOtro')";
    
    $conexionEdicionManto=mysql_query($queryEdicionManto, $con);
    $conexionEdicionVerificacion=mysql_query($queryEdicionIntervencionesVerificacion, $con);        
    $conexionEdicionCalibracion=mysql_query($queryEdicionIntervencionesCalibracion, $con);        
    $conexionEdicionCalificacion=mysql_query($queryEdicionIntervencionesCalificacion, $con);        
    $conexionEdicionOtro=mysql_query($queryEdicionIntervencionesOtro, $con);        
    }
    
}//else if (
//        $mantenimiento!="" || 
//        $verificacion!="" || 
//        $calibracion!="" || 
//        $calificacion!="" || 
//        $frecuenciaOtro !="" || 
//        $intervencionOtro!=""
//        ){
//    $queryEdicionManto="INSERT INTO intervenciones VALUES ('','$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Mantenimiento preventivo','$mantenimiento')";
//    $queryEdicionIntervencionesVerificacion="INSERT INTO intervenciones VALUES ('','$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Verificacion','$verificacion')";
//    $queryEdicionIntervencionesCalibracion="INSERT INTO intervenciones VALUES ('','$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Calibracion','$calibracion')";
//    $queryEdicionIntervencionesCalificacion="INSERT INTO intervenciones VALUES ('','$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','Calificacion','$calificacion')";
//    $queryEdicionIntervencionesOtro="INSERT INTO intervenciones VALUES ('','$nohv','$maxVersionUbicacion','$NuevaVersionInvervencion','$intervencionOtro','$frecuenciaOtro')";
//    
//    
//    $conexionEdicionManto=mysql_query($queryEdicionManto, $con);
//    $conexionEdicionVerificacion=mysql_query($queryEdicionIntervencionesVerificacion, $con);        
//    $conexionEdicionCalibracion=mysql_query($queryEdicionIntervencionesCalibracion, $con);        
//    $conexionEdicionCalificacion=mysql_query($queryEdicionIntervencionesCalificacion, $con);        
//    $conexionEdicionOtro=mysql_query($queryEdicionIntervencionesOtro, $con);
//}
// ---fin validador de cambios intervenciones
        ?>