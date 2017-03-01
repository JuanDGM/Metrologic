<?php
include('./conexion.php');
$con=  conectar();

$codhvvalidando=$_POST['codhvvalidando'];
$array_estandar= array();
$array_sucess= array();
$array_error=array();


$consultavalidacion="SELECT No_HV FROM hoja_vida WHERE No_HV='$codhvvalidando'";
$datos=mysql_query($consultavalidacion, $con);
$respuesta="";

while($validacion=mysql_fetch_array($datos)){
    $respuesta=$validacion['No_HV'];
    }
    
    
        $array_estandar=array("color"=> "form-group",
        "icono"=>"");
    
    
    $array_sucess= array("color" => "form-group has-success has-feedback",
        "icono" => "glyphicon glyphicon-ok form-control-feedback");

    $array_error= array("color"=>"form-group has-error has-feedback",
        "icono"=>"glyphicon glyphicon-remove form-control-feedback");

 

if(strlen($codhvvalidando)==0){
    
   echo json_encode($array_estandar);
    
} else if($respuesta==""){
echo json_encode($array_sucess); 
 
} else {
  echo json_encode($array_error);   
}
 
?>
