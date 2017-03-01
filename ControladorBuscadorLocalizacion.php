<?php
include_once ('./conexion.php');
$con=  conectar();

$ciudad=$_POST['ciudad'];
//$sede=$_POST['sede'];
//$area=$_POST['area'];

$c=json_encode($ciudad);
//$s=json_encode($sede);
//$a=json_encode($area);

$ciudadDeco=json_decode($c);
//$sedeDeco=json_decode($s);
//$areaDeco=json_decode($a);

$ciudadSeleccionado=$ciudadDeco[0]->value;
//$sedeSeleccionado=$sedeDeco[0]->value;
//$areaSeleccionado=$areaDeco[0]->value;

if($ciudadSeleccionado!=""){
    $filtroCiudad="Sede='$ciudadSeleccionado'";
}else{
    $filtroCiudad=1;
}

//if($sedeSeleccionado!=""){
//    $filtroSede="Area='$sedeSeleccionado'";
//}else{
//    $filtroSede=1;
//}
//
//if($areaSeleccionado!=""){
//    $filtroArea="Sub_Area='$ciudadSeleccionado'";
//}else{
//    $filtroArea=1;
//}

$queryLocalizacion="SELECT Sede,Area,Sub_Area FROM ubicaciones WHERE $filtroCiudad GROUP BY Sede";
$conexion=mysql_query($queryLocalizacion, $con);

while($array=mysql_fetch_array($conexion)){
    $Ciudad[]=$array['Sede'];
    }
//while($array=mysql_fetch_array($conexion)){
//    $Sede[]=$array['Area'];
//    }
//while($array=mysql_fetch_array($conexion)){
//    $Area[]=$array['Sub_Area'];
//    }

$arrayLocalizacion=array("ciudad"=>$Ciudad);
echo json_encode($arrayLocalizacion);
?>