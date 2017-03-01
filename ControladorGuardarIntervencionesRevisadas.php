<?php
session_start();
$Usuario_Reporta=$_SESSION['usuario'];
require_once ('./conexion.php');
$con=  conectar();
$time=  time();
$fecharegistro=date("Y-m-d", $time);
$valores=$_POST['valores'];

$encode= json_encode($valores);

$deco=json_decode($encode);

$FactorCorrección=$deco[0]->value;
$Estado=$deco[1]->value;
$codigoReporte=$deco[2]->value;
$codigoHV=$deco[3]->value;
$TipoIntervencion=$deco[4]->value;


if($Estado=="Aprobado"){

    
    $queryInsertar="UPDATE 
                            reportes_intervencion 
                    SET 
                            Estado_Intervencion ='$Estado' 
                    WHERE 
                            No_Intervencion='$codigoReporte'";
    

    if(isset($TipoIntervencion) && $TipoIntervencion=="Calibracion"){
    $queryInsertarFactorCorreccion="INSERT INTO Factor_Correccion(
                                            Cod_Equipo, Cod_Reporte_Calibracion, 
                                            Factor_Correccion, Nombre_Registra, 
                                            Fecha_Sistema
                                    ) 
                                    VALUES 
                                            (
                                                    '$codigoHV', '$codigoReporte', '$FactorCorrección', 
                                                    '$Usuario_Reporta', '$fecharegistro'
                                            )";
    
    $conexionInsertarFactorCorreccion=mysql_query($queryInsertarFactorCorreccion, $con);
    }
    $guardado=mysql_query($queryInsertar, $con);

    
    
}else if($Estado=="Retener"){
    $queryInsertar="UPDATE 
                            reportes_intervencion 
                    SET 
                            Estado_Intervencion ='$Estado' 
                    WHERE 
                            No_Intervencion='$codigoReporte'";
    $guardado=mysql_query($queryInsertar, $con);
    if(isset($TipoIntervencion) && $TipoIntervencion=="Calibracion"){
    $queryInsertarFactorCorreccion="INSERT INTO Factor_Correccion(
                                            Cod_Equipo, Cod_Reporte_Calibracion, 
                                            Factor_Correccion, Nombre_Registra, 
                                            Fecha_Sistema
                                    ) 
                                    VALUES 
                                            (
                                                    '$codigoHV', '$codigoReporte', '$FactorCorrección', 
                                                    '$Usuario_Reporta', '$fecharegistro'
                                            )";
    
    $conexionInsertarFactorCorreccion=mysql_query($queryInsertarFactorCorreccion, $con);
    }
}

echo json_encode("Reporte Guardado");

?>