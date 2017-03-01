<script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" href="estilos.css">-->
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
<?php

function historialIntervenciones($b){
    //require_once ('./conexion.php');
   $con=  conectar();
   $hv=$b;
   $queryHistorialIntervenciones="SELECT No_Intervencion,Tipo_Intervencion,Fecha_Intervencion,Descripcion, Nombre_Proveedor, Nombre_Tecnico,Nombre_Recibe_Trabajo,Estado_Equipo FROM reportes_intervencion WHERE HV_Equipo='$hv'"; 
   $conexionqueryHistorial=  mysql_query($queryHistorialIntervenciones, $con);
  
  ?>
    
    <script type="text/javascript">
                $(document).ready(function(){
                $("#tablaHistorial").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
                 
                });
            });
            </script>
    
    
    <?php
  
  echo "<table id='tablaHistorial' class='table table-bordered'>";
  echo "<thead>";
  echo "<tr style='text-align: center;background: #F7F3B1;'><td style='font-size:13px;width:50px;'>COD INTERVENCION</td><td style='width:20px;'>FECHA INTERVENCION</td><td style='width:25px;'>TIPO INTERVENCIÓN</td><td style='width:250px;'>DESCRIPCIÓN</td><td style='width:25px;'>PROVEEDOR</td><td style='width:25px;'>TÉCNICO</td><td style='width:25px;'>RECIBIDO POR</td><td style='width:25px;'>ESTADO</td><td style='width:30px;'>REPORTE INTERVENCION</td></tr>";
  echo "</thead>";
  echo "<tbody>";
  
  while($arrayHistorialIntervencion=  mysql_fetch_array($conexionqueryHistorial)){
                echo "<tr>";
                echo "<td>".$arrayHistorialIntervencion['No_Intervencion']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Fecha_Intervencion']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Tipo_Intervencion']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Descripcion']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Nombre_Proveedor']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Nombre_Tecnico']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Nombre_Recibe_Trabajo']."</td>";
                echo "<td>".$arrayHistorialIntervencion['Estado_Equipo']."</td>";
                echo "<td style='text-align:center;'><button type='submit' class='btn btn-info'><span class='glyphicon glyphicon-file'></span></button></td>";
                echo "</tr>";
        }
        echo "</tbody>";
  echo "</table>";
 
}
?>
    