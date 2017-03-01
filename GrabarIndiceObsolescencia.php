<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Indice Obsolescencia</title>
        <link rel="stylesheet" href="EstilosCronogramas.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstiloMsjReporteFallaExitosamente.css">
        <!--<link rel="stylesheet" href="estilos.css">-->
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
    </head>
    <body>
<?php
include('./conexion.php');
$con=  conectar();
$time=  time();
$fecha_Registro=date("Y-m-d",$time);

$codigoHV=$_POST['codigoHV'];
$Consumibles=$_POST['consumibles'];
$EventosAdversos=$_POST['eventosAdversos'];
$VidaUtilContable=$_POST['vidaUtilContable'];
$edadEquipo=$_POST['edadEquipo'];
$CantidadFallas=$_POST['CantidadFallas'];
$IncluyeRepuestos=$_POST['ProveedorIncluyeRepuestos'];
$SoporteRepuestos=$_POST['soporteRepuestos'];
$Operabilidad=$_POST['operabilidad'];
$Satisfacción=$_POST['Satisfaccion'];
$Cobertura=$_POST['cobertura'];
$InversionAdquisicion=$_POST['inversionAdquisicion'];
$CostosMantenimiento=$_POST['CostoManto'];
$indice=$_POST['indice'];


if($Consumibles==""){
    $consumiblesIngresar="No requiere consumibles";
}else if($Consumibles==100){
    $consumiblesIngresar="No tiene soporte de consumibles";
}else if($Consumibles==65){
    $consumiblesIngresar="De 1 a 4 años";
}else if($Consumibles==30){
    $consumiblesIngresar="De 5 a 7 años";
}else if($Consumibles==1){
    $consumiblesIngresar="Mayor a 7 años";
}else{
    $consumiblesIngresar="No aplica";
}


if($EventosAdversos==1){
    $EventosAdversosIngresar="No";
}else if($EventosAdversos==50){
    $EventosAdversosIngresar="Menos de 2";
}else if($EventosAdversos==100){
$EventosAdversosIngresar="3 o más";
}else{
    $EventosAdversosIngresar="No aplica";
}

if($IncluyeRepuestos==1){
    $IncluyeRepuestosIngresar="Con fábrica";
}else if($IncluyeRepuestos==50){
    $IncluyeRepuestosIngresar="Otro proveedor";
}else if($IncluyeRepuestos==100){
    $IncluyeRepuestosIngresar="No existe soporte técnico";
}else{
    $IncluyeRepuestosIngresar="No aplica";
}

if($SoporteRepuestos==1){
    $SoporteRepuestosIngresar="Más 7 años";
}else if($SoporteRepuestos==30){
    $SoporteRepuestosIngresar="Entre 5 y 7 años";
}else if($SoporteRepuestos==65){
    $SoporteRepuestosIngresar="Entre 1 y 4 años";
}else if($SoporteRepuestos==100){
    $SoporteRepuestosIngresar="No tiene soporte de respuestos";
}else{
    $SoporteRepuestosIngresar="No aplica";
}


if($Operabilidad==1){
    $OperabilidadIngresar="Mas del 60%";
}else if($Operabilidad==50){
    $OperabilidadIngresar="";
}else if($Operabilidad==100){
    $OperabilidadIngresar="Entre el 30% y 60%";
}else{
    $OperabilidadIngresar="No aplica";
} 

if($Satisfacción==1){
    $SatisfacciónIngresar="Alto: Mas del 75%";
}else if($Satisfacción==50){
    $SatisfacciónIngresar="Medio: Entre el 31% y 75%";
}else if($Satisfacción==100){
    $SatisfacciónIngresar="Menos del 30%";
}else{
    $SatisfacciónIngresar="No aplica";
}


if($Cobertura==1){
    $CoberturaIngresar="Alto: Mas del 75%";
}else if($Cobertura==50){
    $CoberturaIngresar="Medio: Entre el 31% y 75%";
}else if($Cobertura==100){
    $CoberturaIngresar="Menos del 30%";
}else{
    $CoberturaIngresar="No aplica";
}

$queryInsertarEvaluacionIndice="INSERT INTO obsolescencia (
	Disp_Soportes_Consumibles, Eventos_Adversos, 
	Vida_Util_Contable, Edad_Equipo, 
	Cant_Manto_Correctivo, Proveed_SoporT_SinRepuestos, 
	Disp_Soporte_Repuestos, Operabilidad_Equipo, 
	Satisfaccion_Equipo, Cobertura_Necesidades, 
	Inversion_Adquisicion, Gastos_Manto, 
	Indice_Obsolescencia, Fecha_Estimacion
) 
VALUE
	(
		'$consumiblesIngresar', '$EventosAdversosIngresar', '$VidaUtilContable', '$edadEquipo', '$CantidadFallas', '$IncluyeRepuestosIngresar', '$SoporteRepuestosIngresar', '$OperabilidadIngresar', '$SatisfacciónIngresar', '$CoberturaIngresar', 
		'$InversionAdquisicion', '$CostosMantenimiento', '$indice', '$fecha_Registro'
	)";

$ConexionDatos=mysql_query($queryInsertarEvaluacionIndice, $con);

?>

        <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


           
<div id="marco" class="jumbotron">
  <p id="msj">INDICE DE OBSOLESCENCIA GUARDADO EXITOMENTE!<p>
  <p><a id="btnContinuar" class="btn btn-primary btn-lg" href="indiceObsolescencia.php" role="button">Continuar</a></p>
</div>
         
    </body>
</html>
        
        