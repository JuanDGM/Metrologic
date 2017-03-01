<?php
include_once("./conexion.php");
function NumeroIntervenciones(){

$con=  conectar();

$time=  time();
$fecha_Sistema=date("Y-M-d",$time);

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
        LEFT JOIN puesta_marcha AS p ON h.No_HV =P.No_HV
WHERE 
	h.Disp_Soporte_Consumibles <> '' && h.Vida_Contable <> '' && h.Edad_Equipo <> '' && h.Soporte_Tecnico_Respuestos <> '' && h.Disp_Soporte_Repuestos <> ''
        && p.Fecha_Descarte='0000-00-00' && CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV)
GROUP BY
	h.No_HV";

$conexionEquiposEstimarObsolescencia=mysql_query($queryEquiposAplicanObsolescencia, $con);

echo $numero = mysql_num_rows($conexionEquiposEstimarObsolescencia);
}

///////////////////////////////////

function CicloObsolescenciaaEstimar(){
    $con=  conectar();
$queryCicloEstimado="SELECT MAX(Ciclo_Obsolescencia) AS Max_Ciclo FROM obsolescencia WHERE 1";
$conexionCiclo=mysql_query($queryCicloEstimado, $con);
while($arrayCiclo=mysql_fetch_array($conexionCiclo)){
    $MaxCiclo=$arrayCiclo['Max_Ciclo'];
}
echo $Ciclo_A_Estimar=$MaxCiclo+1;
}

function ultimoCicloEvaluado(){
    $con=  conectar();
$queryCicloEstimado="SELECT MAX(Ciclo_Obsolescencia) AS Max_Ciclo FROM obsolescencia WHERE 1";
$conexionCiclo=mysql_query($queryCicloEstimado, $con);
while($arrayCiclo=mysql_fetch_array($conexionCiclo)){
    echo $MaxCiclo=$arrayCiclo['Max_Ciclo'];
}

    
    
}


function CantidadEquiposInventario(){
    $con=  conectar();
    $queryInventario= "SELECT h.No_HV FROM hoja_vida h LEFT JOIN puesta_marcha AS p ON h.No_HV=p.No_HV WHERE p.Fecha_Descarte='0000-00-00' && CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV)";
    $conexionInventario=mysql_query($queryInventario, $con);
    echo $numero = mysql_num_rows($conexionInventario);
}


//pendientes:
//    Eventos adveros,
//       cantidad manto correctivo (en el ultimo año),
//        Satisfaccion del equipo (),
//        cobertura de necesidades,
//        Gastos manto (Gastos manto correctivo en el ultimo año) No estos realiozando el filtro de ultimo año


?>