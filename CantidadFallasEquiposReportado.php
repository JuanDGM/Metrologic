
<?php
include('./conexion.php');
$con=  conectar();
    
$queryEquiposFallasPendientes="SELECT * FROM reporte_fallas_equipos AS f LEFT JOIN puesta_marcha AS p ON f.HV_Equipo=p.No_HV WHERE f.Fecha_Ejecutado='0000-00-00' && CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV) && Fecha_Descarte='0000-00-00' GROUP BY p.No_HV";
$conexionEquipoFallasPendientes=  mysql_query($queryEquiposFallasPendientes, $con);

$numero = mysql_num_rows($conexionEquipoFallasPendientes);

if($numero>0){
              echo json_encode($numero);
           } else {
               echo json_encode("0");
               }
?>
