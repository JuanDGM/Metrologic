<?php

$imagen=$_POST['riesgoSeleccionado'];

if($imagen=="Riesgo de atrapamiento"){
    
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png";
    
}else if($imagen=="Riesgo electrico"){
    
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Electrico.png";
}else if($imagen=="Precaucion riesgo especifico"){
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Especifico.png";
    
}else if($imagen=="Riesgo de radiaciones laser"){
    $respuesta1="./images/Senalizacion_Riesgos/Radiaciones_Laser.png";
    
}else if($imagen=="Riesgo bajas temperaturas"){
    $respuesta1="./images/Senalizacion_Riesgos/Bajas_Temperaturas.png";
    
}else if($imagen=="Riesgo puncion"){
    $respuesta1="./images/Senalizacion_Riesgos/Riesgo_Puncion.png";
}

echo json_encode($respuesta1);

?>