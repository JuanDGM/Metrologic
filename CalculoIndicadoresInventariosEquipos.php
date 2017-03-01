<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Indicadores</title>
        <link rel="stylesheet" href="EstilosCalculosCumplimientoCronogramas.css">
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body>
        <?php
            require_once('./conexion.php');
            $con=  conectar();
        $queryCantidadEquiposPorTipo="SELECT 
                                                h.Tipo_Equipo,
                                                h.No_HV,
                                                COUNT(h.Tipo_Equipo) AS cantidad 
                                        FROM 
                                                hoja_vida AS h 
                                                LEFT JOIN puesta_marcha AS p ON h.No_HV = p.No_HV 
                                        WHERE 
                                                CONCAT(p.No_HV,p.Version) IN (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV) 
                                        GROUP BY 
                                                tipo_equipo,h.No_HV";

        $conexionCantidadEquiposPorTipo=mysql_query($queryCantidadEquiposPorTipo, $con);
        ?>  
        
          <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Tipo de equipo", "Cantidad equipos", { role: "style" } ],
        <?php
        while($arrayCantidadEquiposPorTipo=mysql_fetch_array($conexionCantidadEquiposPorTipo)){
        
          ?>
        
       ["<?php echo $arrayCantidadEquiposPorTipo['Tipo_Equipo']; ?>",<?php echo $arrayCantidadEquiposPorTipo['cantidad']; ?>, "#76A7FA"],
          <?php
          
          }
          ?>
               
     ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "CANTIDAD DE INTERVENCIONES POR TIPO",
        
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 95%; height: 300px;margin: auto;padding: 20px;"></div>
    
        
    </body>
</html>


