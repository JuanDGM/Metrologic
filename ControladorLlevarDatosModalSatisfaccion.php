<?php
$codigoReporte=$_POST['codigoReporte'];
//$proveedorEvaluar=$_POST['proveedorEncuesta'];
//$tecnicoEvaluar=$_POST['tecnico'];
//$intervencionesEvaluar=$_POST['intervenciones'];

//$array=array('codReporte'=>$codigoReporte,'proveedorEvaluar'=>$proveedorEvaluar,'tecnicoEvaluar'=>$tecnicoEvaluar,'intervencionEvaluar'=>$intervencionesEvaluar);
//$array=array('codReporte'=>$codigoReporte,'proveedorEvaluar'=>$proveedorEvaluar);

echo json_encode($codigoReporte);
?>