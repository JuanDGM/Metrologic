<?php
include ('./conexion.php');
$con=  conectar();

$codigoHV=$_POST['codigoHVequipo'];

//Seleccionar datos del equipo

$querySeleccionDatos="SELECT 
                            Nombre_Equipo, 
                            Marca, 
                            Modelo 
                    FROM 
                            hoja_vida 
                    WHERE 
                            No_HV = '$codigoHV'";

$conexionSeleccionDatos=mysql_query($querySeleccionDatos, $con);

while($arraySeleccionDatos=  mysql_fetch_array($conexionSeleccionDatos)){
    
    $nombreEquipo=$arraySeleccionDatos['Nombre_Equipo'];
    $marca=$arraySeleccionDatos['Marca'];
    $modelo=$arraySeleccionDatos['Modelo'];
}

// Cantidad de fallas reportadas

    $queryCantidadFallas="SELECT 
                                 COUNT(HV_Equipo) 
                         FROM 
                                 reporte_fallas_equipos 
                         WHERE 
                                 HV_Equipo = '$codigoHV' && Fecha_Reporte >= '2016-11-27'";

         $conexionCantFallas=mysql_query($queryCantidadFallas, $con);                                       
         while($arrayCantFallas=mysql_fetch_array($conexionCantFallas)){
             $cantFallas=$arrayCantFallas['COUNT(HV_Equipo)'];
         }

         
//         if($cantFallas<=2){
//             $ClasificacionCantFallas="Hasta 2";
//         }else if($cantFallas>2 && $cantFallas<=7){
//             $ClasificacionCantFallas="Entre 3 y 7";
//         }else{
//             $ClasificacionCantFallas="Mas de 8";
//         }
         
         
$array_json=array('nombre'=>$nombreEquipo,'marca'=>$marca,'modelo'=>$modelo,'CantFallas'=>$cantFallas);

echo json_encode($array_json);

?>

