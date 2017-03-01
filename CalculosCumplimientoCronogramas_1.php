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

        <script>
            
        $(document).ready(function(){
        $('.collapse').collapse();
        });
    
    </script>
    </head>
    <body>
<?php
require_once('./conexion.php');
$con=  conectar();

?>

        <div id="ContenedorGraficos">
            
            <?php
            // Cantidad de intervenciones a realizar en la puesta en marcha (sin reporte de intervencion) 
            
            
            $queryCantidadPrimeraIntervencionProgramada="";
            
            
            
            
            
            
            
            
            // Cantidad de intervenciones Realizadas 
            
            
            
            // Cantidad de intervenciones entre la fecha de puesta en marcha y la primera intervencion ó a la ultima fecha del cronograma
            
            // Cantidad de intervenciones entre la fecha programada y la fecha vencida 
            
            
            // Cantidad de intervenciones entre la la ultima fecha de intervencion y el ultimo dia del año en curso
            
            ?>
            
            
        </div>

    </body>
</html>