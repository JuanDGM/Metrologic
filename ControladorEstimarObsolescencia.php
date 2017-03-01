<?php
$time=  time();
$fecharegistro=date("Y-m-d", $time);

$datosFormulario=$_POST['DatosFormulario'];

$datosEncode=  json_encode($datosFormulario);
$decode=  json_decode($datosEncode);

$guardar=$decode[0]->value;

if($guardar==1){
include_once("./conexion.php");
$con=  conectar();
$queryEquiposAplicanObsolescencia="SELECT 
	h.No_HV, 
	h.Disp_Soporte_Consumibles, 
	h.Vida_Contable, 
	h.Edad_Equipo, 
	h.Soporte_Tecnico_Respuestos, 
	h.Disp_Soporte_Repuestos, 
	h.Inversion,
	IF(COUNT(f.HV_Equipo)=0,0,COUNT(f.HV_Equipo)) AS Cant_Fallas_Reportadas, 
	IF(SUM(r.Costo_Intervencion)=0,0,SUM(r.Costo_Intervencion)) AS Costos_Manto 
FROM 
	hoja_vida AS h 
	LEFT JOIN reporte_fallas_equipos AS f ON h.No_HV = f.HV_Equipo 
	LEFT JOIN reportes_intervencion AS r ON h.No_HV = r.HV_Equipo
        LEFT JOIN puesta_marcha AS p ON h.No_HV=p.No_HV
WHERE 
	h.Disp_Soporte_Consumibles <> '' && h.Vida_Contable <> '' && h.Edad_Equipo <> '' && h.Soporte_Tecnico_Respuestos <> '' && h.Disp_Soporte_Repuestos <> '' && p.Fecha_Descarte='0000-00-00'
        && CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV)

GROUP BY
	h.No_HV";


$conexionEquiposEstimarObsolescencia=mysql_query($queryEquiposAplicanObsolescencia, $con);

$queryCicloEstimado="SELECT MAX(Ciclo_Obsolescencia) AS Max_Ciclo FROM obsolescencia WHERE 1";
$conexionCiclo=mysql_query($queryCicloEstimado, $con);
while($arrayCiclo=mysql_fetch_array($conexionCiclo)){
    $MaxCiclo=$arrayCiclo['Max_Ciclo'];
}
$Ciclo_A_Estimar=$MaxCiclo+1;


while($arrayEquiposEstimarObsolescencia=mysql_fetch_array($conexionEquiposEstimarObsolescencia)){
    
$codHV=$arrayEquiposEstimarObsolescencia['No_HV'];
$nombreEquipo='Monedas';
$Marca='Mercedez';
$Modelo='2016';
$SoportesConsumibles=$arrayEquiposEstimarObsolescencia['Disp_Soporte_Consumibles'];
$EventosAdversos=50;
$vidaUtilContable=$arrayEquiposEstimarObsolescencia['Vida_Contable'];
$edadEquipo=$arrayEquiposEstimarObsolescencia['Edad_Equipo'];
$RelacionEdad_vida=$edadEquipo/$vidaUtilContable;
$CantidadFallas=$arrayEquiposEstimarObsolescencia['Cant_Fallas_Reportadas'];
$ProveedorIncluyeRepuestos=$arrayEquiposEstimarObsolescencia['Soporte_Tecnico_Respuestos'];
$SoporteRepuestos=$arrayEquiposEstimarObsolescencia['Disp_Soporte_Repuestos'];
$operabilidadEquipo=50;
$Satisfaccion=50;
$cobertura=50;

$inversionAdquisicion=$arrayEquiposEstimarObsolescencia['Inversion'];
$GastoManto=$arrayEquiposEstimarObsolescencia['Costos_Manto'];
$RelacionGastoInversion=$GastoManto/$inversionAdquisicion;
    
    


// calculos

//Evaluacion tecnica

// Factor de mantenimientos preventivos

if($CantidadFallas<=2){
    $puntosFallas=1;
}else if($CantidadFallas>2 && $CantidadFallas<=7){
    $puntosFallas=50;
}else if($CantidadFallas>7){
    $puntosFallas=100;
}

if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionPrimerFactor=0.099;
}else if($EventosAdversos=='1' && $SoportesConsumibles!=""){
    $PonderacionPrimerFactor=0.0765;
}else if($EventosAdversos!='1' && $SoportesConsumibles==""){
    $PonderacionPrimerFactor=0.081;
}else{
    $PonderacionPrimerFactor=0.063;
}

$TotalPrimerFactor=$puntosFallas*$PonderacionPrimerFactor;

// Soporte tecnico no incluye repuestos


if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionSegundoFactor=0.1305;
}else if($EventosAdversos=='1' && $SoportesConsumibles!=""){
    $PonderacionSegundoFactor=0.1035;
}else if($EventosAdversos!='1' && $SoportesConsumibles==""){
    $PonderacionSegundoFactor=0.108;
}else{
    $PonderacionSegundoFactor=0.090;
}

$TotalSegundoFactor=$ProveedorIncluyeRepuestos*$PonderacionSegundoFactor;

// Disponibilidad soporte de repuestos

if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionTercerFactor=0.1305;
}else if($EventosAdversos=='1' && $SoportesConsumibles!=""){
    $PonderacionTercerFactor=0.1035;
}else if($EventosAdversos!='1' && $SoportesConsumibles==""){
    $PonderacionTercerFactor=0.108;
}else{
    $PonderacionTercerFactor=0.090;
}

$TotalTercerFactor=$SoporteRepuestos*$PonderacionTercerFactor;

// Disponibilidad de soporte de consumibles

if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionCuartoFactor=0;
}else if($EventosAdversos=='1'){
    $PonderacionCuartoFactor=0.1035;
}else if($SoportesConsumibles==""){
    $PonderacionCuartoFactor=0;
}else{
    $PonderacionCuartoFactor=0.090;
}

$TotalCuartoFactor=$SoportesConsumibles*$PonderacionCuartoFactor;

// Ha tenido eventos adversos


if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionQuintoFactor=0;
}else if($EventosAdversos=='1' && $SoportesConsumibles!=""){
    $PonderacionQuintoFactor=0;
}else if($EventosAdversos!='1' && $SoportesConsumibles==""){
    $PonderacionQuintoFactor=0.081;
}else{
    $PonderacionQuintoFactor=0.063;
}


$TotalQuintoFactor=$EventosAdversos*$PonderacionQuintoFactor;

// Relacion entre la edad del equipo y vida util contable

if($RelacionEdad_vida<=0.2){
    
    $PonderacionsextoFactor=1;
    
}else if($RelacionEdad_vida>0.2 && $RelacionEdad_vida<=0.4){
    
    $PonderacionsextoFactor=25;
    
}else if($RelacionEdad_vida>0.4 && $RelacionEdad_vida<=0.6){
    $PonderacionsextoFactor=50;
    
}else if($RelacionEdad_vida>0.6 && $RelacionEdad_vida<=0.8){
    $PonderacionsextoFactor=75;
    
}else if($RelacionEdad_vida>0.8 && $RelacionEdad_vida<=1){
    
    $PonderacionsextoFactor=100;
    
}

if($EventosAdversos=='1' && $SoportesConsumibles==""){
    $PonderacionSextoFactor1=0.09;
}else if($EventosAdversos=='1'){
    $PonderacionSextoFactor1=0.063;
}else if($SoportesConsumibles==""){
    $PonderacionSextoFactor1=0.072;
}else{
    $PonderacionSextoFactor1=0.054;
}

$TotalSextoFactor=$PonderacionsextoFactor*$PonderacionSextoFactor1;


$TotalEvaluacionesTecnica=$TotalPrimerFactor+$TotalSegundoFactor+$TotalTercerFactor+$TotalCuartoFactor+$TotalQuintoFactor+$TotalSextoFactor;


//Evaluacion tecnica

$operabilidadEquipoPonderado=$operabilidadEquipo*0.06;
$SatisfaccionPonderado=$Satisfaccion*0.06;
$coberturaPonderado=$cobertura*0.18;

$TotalEvaluacionTecnica=$operabilidadEquipoPonderado+$SatisfaccionPonderado+$coberturaPonderado;

// Evaluacion Economica

if($RelacionGastoInversion==0){
    $ValorRespuestaEconomica=1;
}else if($RelacionGastoInversion<=0.1){
    $ValorRespuestaEconomica=30;
}else if($RelacionGastoInversion<=0.2){
    $ValorRespuestaEconomica=65;
}else if($RelacionGastoInversion<=0.3){
    $ValorRespuestaEconomica=100;
}else{
    $ValorRespuestaEconomica=100;
}

$TotalEvaluacionEconomica=$ValorRespuestaEconomica*0.25;


$Indice=$TotalEvaluacionesTecnica+$TotalEvaluacionTecnica+$TotalEvaluacionEconomica;

//$Indice=350;


if($Indice<11){
    $TipoMensaje="alert alert-success";
    $IndiceCualitativo="Tecnología NO requiere evaluación ni renovación";
    $IndiceSignificado="El equipo se encuentra en óptimas condiciones.";
    
}else if($Indice>=11 && $Indice<40){
    $TipoMensaje="alert alert-info";
    $IndiceCualitativo="Evaluar tecnología en un año";
    $IndiceSignificado="El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluación.";
    
}else if($Indice>=40 && $Indice<90){
    $TipoMensaje="alert alert-warning";
    $IndiceCualitativo="Renovación de tecnología a la brevedad (Plazo inferior a un año)";
    $IndiceSignificado="El equipo puede mantenerse en el servicio y se recomienda su reposición en un plazo inferior a un año.";
    
}else{
    $TipoMensaje="alert alert-danger";
    $IndiceCualitativo="Reposición de tecnología (Inmediato)";
    $IndiceSignificado="El equipo no es viable de mantener en el servicio y se recomienda su reposición.";
}

$queryInsertarEstimacionObsolescencia="INSERT INTO obsolescencia(
	Cod_Equipo, Ciclo_Obsolescencia, 
	Fecha_Ciclo, Disp_Soportes_Consumibles, 
	Eventos_Adversos, Vida_Util_Contable, 
	Edad_Equipo, Cant_Manto_Correctivo, 
	Proveed_SoporT_SinRepuestos, 
	Disp_Soporte_Repuestos, Operabilidad_Equipo, 
	Satisfaccion_Equipo, Cobertura_Necesidades, 
	Inversion_Adquisicion, Gastos_Manto, 
	Indice_Obsolescencia,Indice_Cualitativo,Indice_Significado, Fecha_Estimacion
) 
VALUES 
	(
		'$codHV', '$Ciclo_A_Estimar', '$fecharegistro', 
		'Disp_Soportes_Consumibles', 'Eventos_Adversos', 'Vida_Util_Contable', 
		'Edad_Equipo', 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRepuestos', 
		'Disp_Soporte_Repuestos', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 
		'Cobertura_Necesidades', 'Inversion_Adquisicion', 'Gastos_Manto', 
		'$Indice','$IndiceCualitativo','$IndiceSignificado','$fecharegistro'
	)";

mysql_query($queryInsertarEstimacionObsolescencia, $con);

}// Fin del while

//$array=array('mensaje'=>$TipoMensaje,'indiceCualitativo'=>$IndiceCualitativo,'IndiceSignificado'=>$IndiceSignificado,'indice'=>$Indice);

//$array=array(
//    'codHV'=>$codHV,
//    'nombreEquipo'=>$nombreEquipo,
//    'marca'=>$Marca,
//    'modelo'=>$Modelo,
//    'SoporteConsumibles'=>$SoportesConsumibles,
//    'eventosAdversos'=>$EventosAdversos,
//    'vidaUtilContable'=>$vidaUtilContable,
//    'edadEquipo'=>$edadEquipo,
//    'RelacionedadEquipo'=>$RelacionEdad_vida,
//    'CantFallas'=>$CantidadFallas,
//    'ProveedorIncluyerepuestos'=>$ProveedorIncluyeRepuestos,
//    'soporteRepuestos'=>$SoporteRepuestos,
//    'operabilidadEquipo'=>$operabilidadEquipo,
//    'satisfaccion'=>$Satisfaccion,
//    'cobertura'=>$cobertura,
//    'InversionAdquisicion'=>$inversionAdquisicion,
//    'GastoManto'=>$GastoManto,
//    'RelacionGastoManto'=>$RelacionGastoInversion
//    );

//echo json_encode($array);
}
?>