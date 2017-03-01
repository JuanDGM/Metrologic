<?php
$datosFormulario=$_POST['DatosFormulario'];

$datosEncode=  json_encode($datosFormulario);
$decode=  json_decode($datosEncode);

$codHV=$decode[0]->value;
$nombreEquipo=$decode[1]->value;
$Marca=$decode[2]->value;
$Modelo=$decode[3]->value;
$SoportesConsumibles=$decode[5]->value;
$EventosAdversos=$decode[6]->value;
$vidaUtilContable=$decode[7]->value;
$edadEquipo=$decode[8]->value;
$RelacionEdad_vida=$decode[9]->value;
$CantidadFallas=$decode[10]->value;
$ProveedorIncluyeRepuestos=$decode[11]->value;
$SoporteRepuestos=$decode[12]->value;

$operabilidadEquipo=$decode[13]->value;
$Satisfaccion=$decode[14]->value;
$cobertura=$decode[15]->value;

$inversionAdquisicion=$decode[16]->value;
$GastoManto=$decode[17]->value;
$RelacionGastoInversion=$decode[18]->value;


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

$array=array('mensaje'=>$TipoMensaje,'indiceCualitativo'=>$IndiceCualitativo,'IndiceSignificado'=>$IndiceSignificado,'indice'=>$Indice);

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

echo json_encode($array);

?>