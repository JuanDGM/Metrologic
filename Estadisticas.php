<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Indicadores</title>
        <link rel="stylesheet" href="EstilosEstadisticas.css">
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
                $("#IndicadoresInventarioEquipos").show();
                    $("#IndicadoresCronogramas").hide();
                    $("#IndicadoresSolicitudes").hide();
                
                
                $("#btnInventarios").click(function(){
                    
                    $("#IndicadoresInventarioEquipos").show();
                    $("#IndicadoresCronogramas").hide();
                    $("#IndicadoresSolicitudes").hide();
                });
                $("#btnCronogramas").click(function(){
                    $("#IndicadoresCronogramas").show();
                    $("#IndicadoresInventarioEquipos").hide();            
                    $("#IndicadoresSolicitudes").hide();
                });
                
                $("#btnSolicitudes").click(function(){
                    $("#IndicadoresSolicitudes").show();
                    $("#IndicadoresCronogramas").hide();
                    $("#IndicadoresInventarioEquipos").hide();
                });
                
            });
        </script>
    </head>
    <body>
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        <div id="contenedorMenu">
            <img id="logo" src="images/LogoApp/logo.png">
        <div class="list-group" style="width: 85%;margin-left: 30px;float: left;">
            <!--<button type="button" class="list-group-item">Resúmen estadisticas</button>-->
            <button id="btnInventarios" type="button" class="list-group-item" autofocus>Inventario de equipos</button>
            <button id="btnCronogramas" type="button" class="list-group-item">Cumplimiento al cronograma</button>
            <button id="btnSolicitudes" type="button" class="list-group-item">Atención a fallas reportadas</button>
            <button id="btnDesempeno" type="button" class="list-group-item">Desempeño de los equipos</button>
            <button id="btnGastos" type="button" class="list-group-item">Gastos de mantenimiento y metrología</button>
        </div>        
            
        </div>
        
        
        
        <div id="ContenedorGraficos">
        
            <div class="page-header" style="width: 100%;height: 100px;border-bottom: 1px solid #a3a3a3;">
                <a href='Menu.php' style='float: right;margin-right: 30px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
                <h1 style="font-weight: bold;margin-left:5%;vertical-align: middle;">INDICADORES</h1>
            </div>
            
            
            
        <!--Caracterizacion de equipos actuales-->
        <div id="IndicadoresInventarioEquipos">
            <h1 style="text-align: center;color:#0B7D85;font-weight: bold;">INVENTARIO DE EQUIPOS</h1>
        <?php 
        require_once('./CalculoIndicadoresInventariosEquipos.php');
        ?>    
        </div>
        <!--CUMPLIMIENTO A CRONOGRAMAS-->
        <div id="IndicadoresCronogramas" style="display: none;">
            <h1 style="text-align: center;color:#0B7D85;font-weight: bold;">INDICADORES DE CUMPLIMIENTO A CRONOGRAMAS</h1>
        <?php 
        require_once('./CalculosCumplimientoCronogramas.php');
        ?>
        </div>      
    <!--segundo grafico:-->      

        <!--Fin display indicadores cronogramas-->
        
    <!--ATENCION A SOLICITUDES (FALLAS)-->
    <div id="IndicadoresSolicitudes" style="display: none;">
        <h1 style="text-align: center;color:#0B7D85;font-weight: bold;">INDICADORES DE ATENCIÓN A FALLAS REPORTADAS</h1>
        <?php
                require_once ('./CalculosAtencionFallasReportadas.php');
        ?>
        
        </div>
        </div>
        <!--Fin display indicadores Atencion solicitudes (fallas)-->    
    </body>
</html>