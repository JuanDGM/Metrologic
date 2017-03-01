<?php
require_once ('./conexion.php');
$con=  conectar();
session_start();
//$_SESSION['usuario']=$_POST['usuario'];
$CuentaUsuario=$_SESSION['usuario'];
$time=  time();
$fecharegistro=date("Y-m-d", $time);

if(isset($_POST['resultadoA'])){
    $respuesta=$_POST['resultadoA'];
    $pregunta="Oportunidad en la reparacion";
    $ProveedorEncuesta=$_POST['proveedor'];
    $tecnico=$_POST['tecnico'];
    $TipoIntervencion=$_POST['intervencion'];
    
}else if(isset($_POST['resultadoB'])){
    $respuesta=$_POST['resultadoB'];
    $pregunta="Reparacion resuelta eficaz";
    $ProveedorEncuesta=$_POST['proveedor'];
    $tecnico=$_POST['tecnico'];
    $TipoIntervencion=$_POST['intervencion'];
}else if(isset($_POST['resultadoC'])){
    $respuesta=$_POST['resultadoC'];
    $pregunta="Actitud del tecnico";
    $ProveedorEncuesta=$_POST['proveedor'];
    $tecnico=$_POST['tecnico'];
    $TipoIntervencion=$_POST['intervencion'];
}else if(isset($_POST['resultadoD'])){
    $respuesta=$_POST['resultadoD'];
    $pregunta="Competencia del tecnico";
    $ProveedorEncuesta=$_POST['proveedor'];
    $tecnico=$_POST['tecnico'];
    $TipoIntervencion=$_POST['intervencion'];
}
$codReporte=$_POST['codReporte'];


if($TipoIntervencion=="Falla equipo"){
    
$queryInsertarPregunta="INSERT INTO encuestasatisfaccionfallareportada(
                Cod_Reporte,
                Tipo_Reporte,
                Nombre_Proveedor,
                Nombre_Tecnico,
                Pregunta, 
                Calificacion,
                Evaluado_Por, 
                Fecha_Evaluacion
                ) 
                VALUES 
                (
		'$codReporte',
                '$TipoIntervencion',
                '$ProveedorEncuesta',
                '$tecnico',    
		'$pregunta',
                '$respuesta',
                '$CuentaUsuario', 
		'$fecharegistro'
                )";



$queryCantidadPreguntas="SELECT 
                                    COUNT(Cod_Reporte) AS Cuenta 
                            FROM 
                                    encuestasatisfaccionfallareportada
                            WHERE 
                                    Cod_Reporte='$codReporte' && Tipo_Reporte='$TipoIntervencion'";    
    
}else{

$queryInsertarPregunta="INSERT INTO satisfaccion_usuarion(
                Cod_Reporte,
                Tipo_Reporte,
                Nombre_Proveedor,
                Nombre_Tecnico,
                Pregunta, 
                Calificacion,
                Evaluado_Por, 
                Fecha_Evaluacion
                ) 
                VALUES 
                (
		'$codReporte',
                '$TipoIntervencion',
                '$ProveedorEncuesta',
                '$tecnico',    
		'$pregunta',
                '$respuesta',
                '$CuentaUsuario', 
		'$fecharegistro'
                )";



$queryCantidadPreguntas="SELECT 
                                    COUNT(Cod_Reporte) AS Cuenta 
                            FROM 
                                    satisfaccion_usuarion
                            WHERE 
                                    Cod_Reporte='$codReporte' && Tipo_Reporte='$TipoIntervencion'";

}


mysql_query($queryInsertarPregunta, $con);
$conexionCantidadPReguntas=mysql_query($queryCantidadPreguntas, $con);
while($arrayCantidadPReguntas=mysql_fetch_array($conexionCantidadPReguntas)){
    $cantidadPreguntas=$arrayCantidadPReguntas['Cuenta'];
    }

    if($cantidadPreguntas==4){
        echo json_encode(4);
    }
?>