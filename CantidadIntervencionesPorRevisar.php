<?php
require_once ('./conexion.php');
$con=  conectar();

$queryCantIntervencionesRevisar="SELECT 
                                                    r.No_Intervencion, 
                                                    r.HV_Equipo,
                                                    h.Nombre_Equipo,
                                                    r.Tipo_Intervencion, 
                                                    r.Descripcion, 
                                                    r.Fecha_Esperada, 
                                                    r.Fecha_Intervencion, 
                                                    r.Nombre_Proveedor 
                                            FROM 
                                                    reportes_intervencion AS r LEFT JOIN hoja_vida AS h ON r.HV_Equipo=h.No_HV 
                                            WHERE 
                                                    Tipo_Intervencion<>'Mantenimiento correctivo' && Estado_Intervencion<>'Aprobado'";

$conexionCantIntervencionesRevisar=mysql_query($queryCantIntervencionesRevisar, $con);

$numero = mysql_num_rows($conexionCantIntervencionesRevisar);

if($numero>0){
              echo json_encode($numero);
           } else {
               echo json_encode("0");
               }


?>