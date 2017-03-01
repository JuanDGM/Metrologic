<?php

include('./conexion.php');
$con=  conectar();

//$datos=$_POST['Intervencion'];
//$datos=$_POST['Intervencion'];
$HojaVida=$_POST['h'];
$Intervencion=$_POST['i'];

//$encode=json_encode($datos);
//$decode=json_decode($encode);
//
//$HV=$decode[0]->value;
//$TI=$decode[1]->value;

$querymaxVersionIntervencion="SELECT MAX(Version_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$HojaVida' && Tipo_Intervencion='$Intervencion'";

$conexionMaxVersion=  mysql_query($querymaxVersionIntervencion, $con);

while($VersionMax=mysql_fetch_array($conexionMaxVersion)){
    
    $v=$VersionMax[0];
}


$queryBuscarUltimoProveedor="SELECT Nombre_Proveedor FROM reportes_intervencion WHERE HV_Equipo='$HojaVida' && Tipo_Intervencion='$Intervencion' && Version_Intervencion='$v'";

$conexionBuscarProveedor=mysql_query($queryBuscarUltimoProveedor, $con);

while($arrayBuscarProveedor=mysql_fetch_array($conexionBuscarProveedor)){
    if($conexionBuscarProveedor ==true && isset($arrayBuscarProveedor) ){
        echo json_encode($arrayBuscarProveedor['Nombre_Proveedor']);
    }else{
        echo json_encode("Fallas en la conexion");
    }
}

//echo json_encode($datos);

?>