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
    </head>
    <body>
       
        
        <?php
        include_once('./conexion.php');
        $con=  conectar();
        $time=  time();
        $fecharegistro=date("Y-m-d", $time);
        $año=date("Y",$time);
        
        // Query para el comportamiento mensual de la cantidad de fallas
        
        $queryCantidadFallasReportadasEne="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Jan' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasFeb="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Feb' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasMar="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Mar' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasAbr="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Apr' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasMay="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='May' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasJun="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Jun' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasJul="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Jul' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasAgo="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Aug' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasSep="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Sep' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasOct="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Oct' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasNov="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Nov' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $queryCantidadFallasReportadasDic="SELECT 											Anio_Reporte,				
                                                Anio_Reporte,
                                                Mes_Reporte,
                                                MONTH(Fecha_Fallo_Equipo) AS NoMes,
                                                COUNT(HV_Equipo) AS TotalFallas
                                        FROM 
                                                reporte_fallas_equipos 
                                        WHERE 
                                                Mes_Reporte='Dec' && Anio_Reporte='$año' 
                                        GROUP BY 
                                                Mes_Reporte";
        
        $ConexionCantidadFallasReportadasEne=mysql_query($queryCantidadFallasReportadasEne, $con);
        $ConexionCantidadFallasReportadasFeb=mysql_query($queryCantidadFallasReportadasFeb, $con);
        $ConexionCantidadFallasReportadasMar=mysql_query($queryCantidadFallasReportadasMar, $con);
        $ConexionCantidadFallasReportadasAbr=mysql_query($queryCantidadFallasReportadasAbr, $con);
        $ConexionCantidadFallasReportadasMay=mysql_query($queryCantidadFallasReportadasMay, $con);
        $ConexionCantidadFallasReportadasJun=mysql_query($queryCantidadFallasReportadasJun, $con);
        $ConexionCantidadFallasReportadasJul=mysql_query($queryCantidadFallasReportadasJul, $con);
        $ConexionCantidadFallasReportadasAgo=mysql_query($queryCantidadFallasReportadasAgo, $con);
        $ConexionCantidadFallasReportadasSep=mysql_query($queryCantidadFallasReportadasSep, $con);
        $ConexionCantidadFallasReportadasOct=mysql_query($queryCantidadFallasReportadasOct, $con);
        $ConexionCantidadFallasReportadasNov=mysql_query($queryCantidadFallasReportadasNov, $con);
        $ConexionCantidadFallasReportadasDic=mysql_query($queryCantidadFallasReportadasDic, $con);
       
        while($arrayCantidadFallasReportadasEne=mysql_fetch_array($ConexionCantidadFallasReportadasEne)){
            $Ene=$arrayCantidadFallasReportadasEne['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasFeb=mysql_fetch_array($ConexionCantidadFallasReportadasFeb)){
            $Feb=$arrayCantidadFallasReportadasFeb['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasMar=mysql_fetch_array($ConexionCantidadFallasReportadasMar)){
            $Mar=$arrayCantidadFallasReportadasMar['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasAbr=mysql_fetch_array($ConexionCantidadFallasReportadasAbr)){
            $Abr=$arrayCantidadFallasReportadasAbr['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasMay=mysql_fetch_array($ConexionCantidadFallasReportadasMay)){
            $May=$arrayCantidadFallasReportadasMay['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasJun=mysql_fetch_array($ConexionCantidadFallasReportadasJun)){
            $Jun=$arrayCantidadFallasReportadasJun['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasJul=mysql_fetch_array($ConexionCantidadFallasReportadasJul)){
            $Jul=$arrayCantidadFallasReportadasJul['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasAgo=mysql_fetch_array($ConexionCantidadFallasReportadasAgo)){
            $Ago=$arrayCantidadFallasReportadasAgo['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasSep=mysql_fetch_array($ConexionCantidadFallasReportadasSep)){
            $Sep=$arrayCantidadFallasReportadasSep['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasOct=mysql_fetch_array($ConexionCantidadFallasReportadasOct)){
            $Oct=$arrayCantidadFallasReportadasOct['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasNov=mysql_fetch_array($ConexionCantidadFallasReportadasNov)){
            $Nov=$arrayCantidadFallasReportadasNov['TotalFallas'];
        }
        while($arrayCantidadFallasReportadasDic=mysql_fetch_array($ConexionCantidadFallasReportadasDic)){
            $Dic=$arrayCantidadFallasReportadasDic['TotalFallas'];
        }
        

        if(isset($Ene)){
            $Ene;
        }else{
            $Ene='null';
        }
        if(isset($Feb)){
            $Feb;
        }else{
            $Feb='null';
        }
        if(isset($Mar)){
            $Mar;
        }else{
            $Mar='null';
        }
        if(isset($Abr)){
            $Abr;
        }else{
            $Abr='null';
        }
        if(isset($May)){
            $May;
        }else{
            $May='null';
        }
        if(isset($Jun)){
            $Jun;
        }else{
            $Jun='null';
        }
        if(isset($Jul)){
            $Jul;
        }else{
            $Jul='null';
        }
        if(isset($Ago)){
            $Ago;
        }else{
            $Ago='null';
        }
        if(isset($Sep)){
            $Sep;
        }else{
            $Sep='null';
        }
        if(isset($Oct)){
            $Oct;
        }else{
            $Oct='null';
        }
        if(isset($Nov)){
            $Nov;
        }else{
            $Nov='null';
        }
        if(isset($Dic)){
            $Dic;
        }else{
            $Dic='null';
        }
        
        
        ?>

        <div id="chart_div9"></div>
        <!--<div id="curve_chart" style="width: 900px; height: 500px"></div>-->    
<script>




    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Meses');
      data.addColumn('number', 'Cant_Fallas');

      data.addRows([
        
            ['Ene',<?php echo $Ene; ?>],
            ['Feb',<?php echo $Feb; ?>],
            ['Mar',<?php echo $Mar; ?>],
            ['Abr',<?php echo $Abr; ?>],
            ['May',<?php echo $May; ?>],
            ['Jun',<?php echo $Jun; ?>],
            ['Jul',<?php echo $Jul; ?>],
            ['Ago',<?php echo $Ago; ?>],
            ['Sep',<?php echo $Sep; ?>],
            ['Oct',<?php echo $Oct; ?>],
            ['Nov',<?php echo $Nov; ?>],
            ['Dic',<?php echo $Dic; ?>]
        
      ]);

      var options = {
        title: '1. COMPORTAMIENTO MENSUAL DE LA CANTIDAD DE FALLAS DE EQUIPOS REPORTADAS',  
        hAxis: {
          title: 'Meses'
        },
        vAxis: {
          title: 'Cantidad fallas reportadas'
        },
        backgroundColor: '#f1f8e9',
        width:600,
        height:350
        };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div9'));
      chart.draw(data, options);
    }


</script>



<?php


?>

</body>

</html>