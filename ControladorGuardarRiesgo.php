<?php
include ('./conexion.php');
$con=  conectar();

//$valores=$_POST['valoresRiesgos'];
$Invasividad=$_POST['invasividad'];
$EquipoXTipoRiesgo=$_POST['equipoPorTipoRiesgo'];
$codHV=$_POST['CodHV'];
$Riesgo=$_POST['Riesgo'];

if($Riesgo!="--Seleccione riesgo que aplica--"){

    if($Riesgo=="Riesgo de atrapamiento"){
    
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png";
    
}else if($Riesgo=="Riesgo electrico"){
    
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Electrico.png";
}else if($Riesgo=="Precaucion riesgo especifico"){
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Especifico.png";
    
}else if($Riesgo=="Riesgo de radiaciones laser"){
    $respuesta1="./images/Senalizacion_Riesgos/Radiaciones_Laser.png";
    
}else if($Riesgo=="Riesgo bajas temperaturas"){
    $respuesta1="./images/Senalizacion_Riesgos/Bajas_Temperaturas.png";
    
}else if($Riesgo=="Riesgo puncion"){
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Puncion.png";
}
    
    

$queryInsertarRiesgo="INSERT INTO riesgos_equipos
    (No_HV, Invasividad, TipoRiesgo_Equipo, 
	Riesgo, Icono
) 
VALUES 
	(
		'$codHV', '$Invasividad', '$EquipoXTipoRiesgo', 
		'$Riesgo', '$respuesta1'
	)";


$conexion=mysql_query($queryInsertarRiesgo, $con);


$queryCantidadRiesgoEquipo="SELECT 
                                    COUNT(No_HV) AS Cant_Riesgos
                            FROM 
                                    riesgos_equipos 
                            WHERE 
                                    No_HV='$codHV'";

$conexionCantRiesgos=mysql_query($queryCantidadRiesgoEquipo, $con);

while($arrayCantRiesgos=mysql_fetch_assoc($conexionCantRiesgos)){
    $NumRiesgos=$arrayCantRiesgos['Cant_Riesgos'];
}
if($NumRiesgos>0){
    $NumRiesgos;
}else if($NumRiesgos==0){
    $NumRiesgos=1;
}

$proximoIdentificados=$NumRiesgos+1;

$array=array('NombreRiesgo'=>$Riesgo,'Icono'=>$respuesta1,'numeroRiesgo'=>$proximoIdentificados);

echo json_encode($array);
}
?>