<?php
include('./conexion.php');
$con=  conectar();

$valores=$_POST['valoresFormulario'];

$encode=json_encode($valores);
$decode=json_decode($encode);


$area=$decode[0]->value;
$codHV=$decode[1]->value;
$Nombre_Equipo=$decode[2]->value;
$TipoIntervencion=$decode[3]->value;
$NoOrden=$decode[4]->value;
$numeroFila=$decode[5]->value;

$queryCodigoRegistroEliminar="SELECT Id FROM programacion_intervencion WHERE Cod_Servicio='$NoOrden' && HV_Equipo='$codHV' && Tipo_Intervencion='$TipoIntervencion'";
$conexionCodigoRegistroEliminar=mysql_query($queryCodigoRegistroEliminar, $con);
while($arrayCodigoRegistroEliminar=mysql_fetch_array($conexionCodigoRegistroEliminar)){
    $idEliminar=$arrayCodigoRegistroEliminar['Id'];
    }

$queryEliminarRegistro="DELETE FROM programacion_intervencion WHERE Id='$idEliminar'";    
$conexionEliminarRegistro=mysql_query($queryEliminarRegistro, $con);    

if(isset($conexionEliminarRegistro)){

echo json_encode($numeroFila);

}else{
    
echo json_encode("Fallas en la conexion");
}

?>