<?php
include ('./conexion.php');
$con= conectar();
$datos=$_POST['datosFormularioGuardarPlaneacion'];

$encode=json_encode($datos);
$decode=  json_decode($encode);

$hv=$decode[0]->value;
$Version_Intervencion=$decode[1]->value;
$tipoIntervencion=$decode[2]->value;
$FechaProgramada=$decode[3]->value;
$ProveedorProgramado=$decode[4]->value;
//$EstadoPogramadoposicion=$decode[5]->value;

$arrayNoProgramado=array(
                "color"=>"background: #d9534f;width:80%;height:auto;text-align:center",
                "icono"=>"glyphicon glyphicon-remove",
                "fechaProgramada"=>"",
                "ProveedorProgramado"=>""
                );
    
    $arrayProgramado=array(
                "color"=>"background: #5cb85c;width:80%;height:auto;text-align:center",
                "icono"=>"glyphicon glyphicon-ok",
                "fechaProgramada"=>$FechaProgramada,
                "ProveedorProgramado"=>$ProveedorProgramado
                );
    $arrayNoProgramadoConProveedor=array(
                "color"=>"background: #F7DC6F;width:80%;height:auto;text-align:center",
                "icono"=>"glyphicon glyphicon-minus",
                "fechaProgramada"=>$FechaProgramada,
                "ProveedorProgramado"=>$ProveedorProgramado
                );
// Verificar que contenga todos los campos de programacion de la intervencion para establecer color e icono
if($FechaProgramada!="" && $FechaProgramada!="0000-00-00" && $ProveedorProgramado==""){
    echo json_encode($arrayNoProgramadoConProveedor);    
}else if($FechaProgramada=="" || $FechaProgramada=="0000-00-00" && $ProveedorProgramado!=""){ 
    echo json_encode($arrayNoProgramadoConProveedor);    
}else if($FechaProgramada!="" && $FechaProgramada!="0000-00-00" && $ProveedorProgramado!=""){
    echo json_encode($arrayProgramado);
}else{
    echo json_encode($arrayNoProgramado);
}   
    
// Verificar que exista el equipo para definir si incertar o actualizar datos
$queryExisteEquipo="SELECT HV_Equipo FROM programacion_intervencion WHERE HV_Equipo='$hv' && Tipo_Intervencion='$tipoIntervencion'";
$conexionQueryExisteEquipo=mysql_query($queryExisteEquipo, $con);

if(isset($conexionQueryExisteEquipo)){
while($arrayExisteEquipo=  mysql_fetch_array($conexionQueryExisteEquipo)){
    $ExisteEquipoActual=$arrayExisteEquipo['HV_Equipo'];
}
if($FechaProgramada=="" && $ProveedorProgramado=="" && $ExisteEquipoActual==""){
    
    //echo json_encode($arrayNoProgramado);
    
}else if($FechaProgramada=="" && $ProveedorProgramado=="" && $ExisteEquipoActual!=""){
    $queryEliminarPlaneacion="DELETE FROM programacion_intervencion WHERE HV_Equipo='$hv' && Tipo_Intervencion='$tipoIntervencion'";
    $conexionqueryEliminarPlaneacion=  mysql_query($queryEliminarPlaneacion, $con);
 
}else if($ExisteEquipoActual!=""){

    $queryReemplazar="UPDATE programacion_intervencion SET Fecha_Programada='$FechaProgramada',Nombre_Proveedor='$ProveedorProgramado' WHERE HV_Equipo='$hv' && Tipo_Intervencion='$tipoIntervencion'";
    $conexionReemplazar=  mysql_query($queryReemplazar, $con);
    
}else if($ExisteEquipoActual==""){
    $queryPlanificar="INSERT INTO programacion_intervencion VALUES('','$hv','0','$Version_Intervencion','$tipoIntervencion','$FechaProgramada','$ProveedorProgramado')";
    $conexionPlanificar=mysql_query($queryPlanificar, $con);
}

if(isset($conexionReemplazar) || isset($conexionPlanificar)){
    $querySeleccionActual="SELECT Fecha_Programada, Nombre_Proveedor FROM programacion_intervencion WHERE HV_Equipo='$hv' && Tipo_Intervencion='$tipoIntervencion'";
    $conexionActual=  mysql_query($querySeleccionActual, $con);    
    
if(isset($conexionActual)){
    while($arrayActual=mysql_fetch_array($conexionActual)){
    $FechaProgramadaActual=$arrayActual['Fecha_Programada'];
    $ProveedorProgramadoActual=$arrayActual['Nombre_Proveedor'];
    }
}
}
}
?>