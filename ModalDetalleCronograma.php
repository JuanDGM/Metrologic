<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
    </head>
    <body>
<?php  


function modalCronogramas(){ 
$codHV="HV1";    
$AñoCronograma=2016;
$NombreEquipo="Balanza";
$frecuencia=30;
$FechaFinCronograma=$AñoCronograma."-12-31";

?>
  <a href="#" id="botonintructivo" data-toggle="modal" data-target="#myModal">Ejecución</a>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel"><strong>DETALLE EJECUCIÓN CRONOGRAMA DE INTERVENCIONES METROLOGICAS Y MANTENIMIENTOS</strong></h4>
      </div>
        <div class="modal-body" style="text-align: left">
            <table class="table table-bordered">
                <tr>
                    <td style="text-align: center;font-weight: bold;">CÓDIGO EQUIPO</td>
                    <td style="text-align: center;font-weight: bold;">NOMBRE EQUIPO</td>
                    <td style="text-align: center;font-weight: bold;">CUMPLIMIENTO</td>
                </tr>
                <tr>
                    <?php
                    $con= conectar();
                    ?>
                    <td style="text-align: center;"><?php echo $codHV; ?></td>
                    <td style="text-align: center;"><?php echo $NombreEquipo ?></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    
                    </tr>
                    
            </table>
            <br/>
            <table class="table">
                <tr style="background: #ccc">
                    <td style="text-align: center;font-weight: bold;">Tipo intervencion</td>
                    <td style="text-align: center;font-weight: bold;">Fecha programada</td>
                    <td style="text-align: center;font-weight: bold;">Fecha ejecutada</td>
                    <td style="text-align: center;font-weight: bold;">Estado</td>
                    <td style="text-align: center;font-weight: bold;">Estado</td>
                </tr>
                <tr>
                <?php
                
                    $queryDetalleIntervencion="SELECT 
	Tipo_Intervencion, 
	Fecha_Esperada, 
	Fecha_Intervencion, 
	IF(
		Fecha_Esperada < Fecha_Intervencion, 
		'Ejecutado vencido', 'Ejecutado'
	) as Estado 
FROM 
	reportes_intervencion 
WHERE 
	HV_Equipo = '$codHV' && Year(Fecha_Esperada)= '$AñoCronograma' 
ORDER BY
	Fecha_Intervencion ASC";            
                    $conexionDetalleIntervencion=mysql_query($queryDetalleIntervencion, $con);
                while($arrayDetalleIntervencion=  mysql_fetch_array($conexionDetalleIntervencion)){
                    echo "<td>".$arrayDetalleIntervencion['Tipo_Intervencion']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Fecha_Esperada']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Fecha_Intervencion']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Estado']."</td>";
                    if($arrayDetalleIntervencion['Estado']=='Ejecutado'){
                    echo "<td class='glyphicon glyphicon-ok' aria-hidden='true' style='color:green;'></td>";
                   }else{
                     echo "<td class='glyphicon glyphicon-ok' style='color:orange'></td>";  
                   }
                    echo "</tr>";
                    
                    echo "<tr>";
                    echo "<td>".$arrayDetalleIntervencion['Tipo_Intervencion']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Fecha_Esperada']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Fecha_Intervencion']."</td>";
                    echo "<td>".$arrayDetalleIntervencion['Estado']."</td>";
                    if($arrayDetalleIntervencion['Estado']=='Ejecutado'){
                    echo "<td class='glyphicon glyphicon-ok' aria-hidden='true' style='color:green;'></td>";
                   }else{
                     echo "<td class='glyphicon glyphicon-ok' style='color:orange'></td>";  
                   }
                    echo "</tr>";
                    
                   }
                    
                    
                
                    
                    
                ?>
                
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div>
<?php
}
?>
</body>
</html>