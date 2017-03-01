<?php
include ('./conexion.php');
$con = conectar();
//El ajax que genera la cantidad de equipos es InventarioEquipos.js
$queryInventario= "SELECT h.No_HV,p.Fecha_Descarte FROM hoja_vida AS h LEFT JOIN puesta_marcha AS p ON h.No_HV=p.No_HV WHERE p.Fecha_Descarte='0000-00-00' && CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV) GROUP BY h.No_HV";
$conexionInventario=mysql_query($queryInventario, $con);
           $numero = mysql_num_rows($conexionInventario);
           if($numero>0){
              echo json_encode($numero);
           } else {
               echo json_encode("0");
               }
?>
