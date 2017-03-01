<?php
include('./conexion.php');
$con=  conectar();
$valor=$_POST['valorIngresado'];
if($valor==""){
 
    echo json_encode($array);
    
}else{


$HV=$_POST['valorIngresado'];




$queryBuscarHV="SELECT No_HV,Nombre_Equipo FROM hoja_vida WHERE No_HV='$HV'";
$queryBuscarUbicacion="SELECT Area,MAX(Version) FROM puesta_marcha WHERE No_HV='$HV'";
$queryBuscarIntervencion="SELECT Tipo_Intervencion, MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='$HV' GROUP BY Tipo_Intervencion";
$querySeleccionarImagen="SELECT Ruta FROM imagenes_equipos WHERE No_HV='$HV'";


$conexionBuscarHV=mysql_query($queryBuscarHV, $con);
$conexionBuscarUbicacion=mysql_query($queryBuscarUbicacion, $con);
$conexionBuscarIntervencion=mysql_query($queryBuscarIntervencion, $con);
$conexionBuscarImagen=mysql_query($querySeleccionarImagen, $con);

$array=array();
$arrayEquipo="";
$arrayUbicacion="";
//$arrayIntervencion="";

while($arrayBuscarHV=  mysql_fetch_array($conexionBuscarHV)){
    $arrayHV=$arrayBuscarHV['No_HV'];
    $arrayEquipo=$arrayBuscarHV['Nombre_Equipo'];
}

while($arrayBuscarUbicacion=  mysql_fetch_array($conexionBuscarUbicacion)){
    $arrayArea=$arrayBuscarUbicacion['Area'];
}

$array_Intervencion=array();
while($arrayBuscarIntervencion=  mysql_fetch_array($conexionBuscarIntervencion)){
    $array_Intervencion[]=$arrayBuscarIntervencion['Tipo_Intervencion'];
}

while($arrayBuscarImagen= mysql_fetch_array($conexionBuscarImagen)){
    $array_ImagenEquipo=$arrayBuscarImagen['Ruta'];
}

$array=array("nombreEquipo"=>$arrayEquipo,"Area"=>$arrayArea,"Intervencion"=>$array_Intervencion,"RutaImagen"=>$array_ImagenEquipo,"HV"=>$arrayHV);


if(isset($array)){
   echo json_encode($array);
}
}
?>