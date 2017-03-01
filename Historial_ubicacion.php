


<script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>



<?php

function historialUbicacion($b){
   $con=  conectar();
   $hv=$b;
   $queryHistorialUbicacion="SELECT Sede,Area,SubArea, Fecha_Marcha FROM puesta_marcha WHERE No_HV='$hv'"; 
   $conexionqueryHistorial=  mysql_query($queryHistorialUbicacion, $con);
?>
   
   <script type="text/javascript">
$(document).ready(function(){
    $("#tablaHistorialUbicacion").DataTable({
            "searching": true,    
            "ordering": false,
            "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
        
    });
});
</script>
   
  <?php 
   
  echo "<div class='table-responsive'>";
  echo "<table class='table table-bordered' id='tablaHistorialUbicacion' style='margin: auto;'>";
  echo "<thead>";
  echo "<tr style='text-align: center;background: #F7F3B1;'>";
  echo "<td>CIUDAD</td><td>SEDE</td><td>AREA</td><td>FECHA PUESTA MARCHA</td>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
        while($arrayHistorialubicacion=  mysql_fetch_array($conexionqueryHistorial)){
                echo "<tr>";
                echo "<td>".$arrayHistorialubicacion['Sede']."</td>";
                echo "<td>".$arrayHistorialubicacion['Area']."</td>";
                echo "<td>".$arrayHistorialubicacion['SubArea']."</td>";
                echo "<td>".$arrayHistorialubicacion['Fecha_Marcha']."</td>";
                
                echo "</tr>";
        }
        echo "</tbody>";
  echo "</table>";
  echo "</div>";
}
?>