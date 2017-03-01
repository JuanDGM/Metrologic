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

?>


<div id="ContenedorGraficos">
<?php

// CALCULO PARA DETERMINAR LA CANTIDAD DE INTERVENCIONES MES (PRIMER INTERVENCION)     
            
            $queryPrimerIntervenion="SELECT Anio_Primer,Mes_Primer,COUNT(Tipo_Intervencion) AS Cant_Intervenciones FROM (SELECT 
	i.HV_Equipo, 
	i.Tipo_Intervencion, 
	i.Frecuencia, 
	i.Aplica_Desde, 
	p.Fecha_Marcha, 
	IF(
		i.Aplica_Desde='Puesta en marcha', p.Fecha_Marcha, 
		DATE_ADD(
		p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
)
	) AS Primer_Intervencion,
    YEAR(IF(
		i.Aplica_Desde='Puesta en marcha', p.Fecha_Marcha, 
		DATE_ADD(
		p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
)
	)) Anio_Primer,
    month(IF(
		i.Aplica_Desde='Puesta en marcha', p.Fecha_Marcha, 
		DATE_ADD(
		p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
)
	)) AS Mes_Primer
FROM 
	intervenciones AS i 
	LEFT JOIN puesta_marcha AS p ON i.HV_Equipo = p.No_HV && i.Version_Ubicacion = p.Version 
WHERE 
	1 
GROUP BY 
	i.HV_Equipo, 
	i.Tipo_Intervencion) AS BDPRIMERINTERVENCION WHERE Anio_Primer='2017' && Mes_Primer='1'";
            
            $conexionPrimerIntervencion=mysql_query($queryPrimerIntervenion, $con);    
            
            while($ArrayPrimerIntervencion=mysql_fetch_array($conexionPrimerIntervencion)){
                $cantPrimerIntervencionesEnero=$ArrayPrimerIntervencion['Cant_Intervenciones'];
            }





// CICLO PARA CALCULAR LA CANTIDAD DE INTERVENCIONES VENCIDAS ENTRE FECHAS DE EJECUCION EN TABLA reporteIntervencion.php sql (proyectadas)
        
    for($i=1;$i<=12;$i++){
        $cadena=count($i);
        if($cadena==1){
            $periodo='0'.$i;
        }else{
            $periodo=$i;
        }
        $queryCantidadIntervencionesVencidas="SELECT 
                            r.Cod_Mes_Esperado AS Mes, 
                            IF(
                                    FLOOR(
                                            DATEDIFF(
                                                    r.Fecha_Intervencion, r.Fecha_Esperada
                                            )/ i.Frecuencia
                                    )< 0, 
                                    0, 
                                    FLOOR(
                                            DATEDIFF(
                                                    r.Fecha_Intervencion, r.Fecha_Esperada
                                            )/ i.Frecuencia
                                    )
                            ) AS PeriodosProyectados 
                    FROM 
                            reportes_intervencion AS r 
                            LEFT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                    WHERE 
                            r.Cod_Mes_Esperado='$periodo'
                    GROUP BY 
                            r.Cod_Mes_Esperado";
 
        $conexionCantIntervencionesVencidasProyectadas=mysql_query($queryCantidadIntervencionesVencidas,$con);
            
       while($arrayCantVencidasProyectadas=  mysql_fetch_array($conexionCantIntervencionesVencidasProyectadas)){
           $arrayCantVencidasProyectadas['Mes'];
           $PeriodosVencidosProyectados=$arrayCantVencidasProyectadas['PeriodosProyectados']."<br/>";
       
       if($PeriodosVencidosProyectados==""){
           $valor=0;
       }else {
          $valor=$arrayCantVencidasProyectadas['PeriodosProyectados'];
       }
        $ArrayCantPeriodos[$i]=$valor."<br/>";
        $ArrayMes[$i]=$i."<br/>";
       }
            } // Fin ciclo for
       
            if(isset($ArrayMes[1])){
              $PeriodosProyectadosEne=$ArrayCantPeriodos[1];
            }else{
              $PeriodosProyectadosEne=0;
            }
            
            if(isset($ArrayMes[2])){
              $PeriodosProyectadosFeb=$ArrayCantPeriodos[2];
            }else{
              $PeriodosProyectadosFeb=0;
            }
            
            if(isset($ArrayMes[3])){
              $PeriodosProyectadosMar=$ArrayCantPeriodos[3];
            }else{
              $PeriodosProyectadosMar=0;
            }
            
            if(isset($ArrayMes[4])){
              $PeriodosProyectadosAbr=$ArrayCantPeriodos[4];
            }else{
              $PeriodosProyectadosAbr=0;
            }
            
            if(isset($ArrayMes[5])){
              $PeriodosProyectadosMay=$ArrayCantPeriodos[5];
            }else{
              $PeriodosProyectadosMay=0;
            }
            
            if(isset($ArrayMes[6])){
              $PeriodosProyectadosJun=$ArrayCantPeriodos[6];
            }else{
              $PeriodosProyectadosJun=0;
            }
            
            if(isset($ArrayMes[7])){
              $PeriodosProyectadosJul=$ArrayCantPeriodos[7];
            }else{
              $PeriodosProyectadosJul=0;
            }
            
            if(isset($ArrayMes[8])){
              $PeriodosProyectadosAgo=$ArrayCantPeriodos[8];
            }else{
              $PeriodosProyectadosAgo=0;
            }
            
            if(isset($ArrayMes[9])){
              $PeriodosProyectadosSep=$ArrayCantPeriodos[9];
            }else{
              $PeriodosProyectadosSep=0;
            }
            
            if(isset($ArrayMes[10])){
              $PeriodosProyectadosOct=$ArrayCantPeriodos[10];
            }else{
              $PeriodosProyectadosOct=0;
            }
            
            if(isset($ArrayMes[11])){
              $PeriodosProyectadosNov=$ArrayCantPeriodos[11];
            }else{
              $PeriodosProyectadosNov=0;
            }
            
            if(isset($ArrayMes[12])){
              $PeriodosProyectadosDic=$ArrayCantPeriodos[12];
            }else{
              $PeriodosProyectadosDic=0;
            }
            

//////////////////////////////////////////////////////////////
// CALCULO DE LA CANTIDAD DE INTERVENCIONES PROGRAMADAS

            
for($i=1;$i<=12;$i++){
            
    $cadena=count($i);
        if($cadena==1){
            $periodo='0'.$i;
        }else{
            $periodo=$i;
        }
$queryCantIntervencionesProgramadas="SELECT 
	s.Cod_Mes, 
	s.Nombre_Mes AS Mes, 
	COUNT(r.Fecha_Esperada) AS Cant_Intervenciones_Programadas, 
	IF(
		COUNT(r.Fecha_Esperada)= 0, 
		0, 
		SUM(
			IF(
				r.Fecha_Esperada < r.Fecha_Intervencion, 
				0, 1
			)
		)
	) AS Cant_Intervenciones_Cumplen, 
	Round(100 *(
		IF(
			COUNT(r.Fecha_Esperada)= 0, 
			0, 
			SUM(
				IF(
					r.Fecha_Esperada < r.Fecha_Intervencion, 
					0, 1
				)
			))
		/ COUNT(r.Fecha_Esperada)),1) AS Cumplimiento 
		FROM 
			prueba AS s 
			LEFT JOIN reportes_intervencion AS r ON s.Cod_Mes = r.Cod_Mes_Esperado 
		WHERE 
			r.Cod_Mes_Esperado='$periodo'
		GROUP BY 
			s.Nombre_Mes"; 
		
 
       $conexionCantIntervencionesProgramadas=mysql_query($queryCantIntervencionesProgramadas,$con);
            
       while($arrayCantIntervencionesProgramadas=  mysql_fetch_array($conexionCantIntervencionesProgramadas)){
           $arrayCantIntervencionesProgramadas['Cod_Mes'];
           $CantidadIntervencionesProgramadas=$arrayCantIntervencionesProgramadas['Cant_Intervenciones_Programadas']."<br/>";
           $CantidadIntervencionesCumplen=$arrayCantIntervencionesProgramadas['Cant_Intervenciones_Cumplen']."<br/>";
       
       if($CantidadIntervencionesProgramadas==""){
           $valor=0;
       }else {
          $valor=$CantidadIntervencionesProgramadas;
           $CantidadCumplen=$CantidadIntervencionesCumplen; 
          
       }
        $ArrayCantIntervencionesProgramadas[$i]=$valor."<br/>";
        $ArrayMesIntervencionesProgramadas[$i]=$i."<br/>";
        $ArrayCantIntervencionesCumplen[$i]=$CantidadCumplen."<br/>";
       
        
       }
            } // Fin ciclo for 
       
        
            
            if(isset($ArrayMesIntervencionesProgramadas[1])){
              $CantIntervencionesProgramadasEne=$ArrayCantIntervencionesProgramadas[1];
                $CantIntervencionesCumplenEne=$ArrayCantIntervencionesCumplen[1];
              
            }else{
              $CantIntervencionesProgramadasEne=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[2])){
              $CantIntervencionesProgramadasFeb=$ArrayCantIntervencionesProgramadas[2];
              $CantIntervencionesCumplenFeb=$ArrayCantIntervencionesCumplen[2];
            }else{
              $CantIntervencionesProgramadasFeb=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[3])){
              $CantIntervencionesProgramadasMar=$ArrayCantIntervencionesProgramadas[3];
              $CantIntervencionesCumplenMar=$ArrayCantIntervencionesCumplen[3];
            }else{
              $CantIntervencionesProgramadasMar=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[4])){
              $CantIntervencionesProgramadasAbr=$ArrayCantIntervencionesProgramadas[4];
              $CantIntervencionesCumplenAbr=$ArrayCantIntervencionesCumplen[4];
            }else{
              $CantIntervencionesProgramadasAbr=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[5])){
              $CantIntervencionesProgramadasMay=$ArrayCantIntervencionesProgramadas[5];
              $CantIntervencionesCumplenMay=$ArrayCantIntervencionesCumplen[5];
            }else{
              $CantIntervencionesProgramadasMay=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[6])){
              $CantIntervencionesProgramadasJun=$ArrayCantIntervencionesProgramadas[6];
              $CantIntervencionesCumplenJun=$ArrayCantIntervencionesCumplen[6];
            }else{
              $CantIntervencionesProgramadasJun=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[7])){
              $CantIntervencionesProgramadasJul=$ArrayCantIntervencionesProgramadas[7];
              $CantIntervencionesCumplenJul=$ArrayCantIntervencionesCumplen[7];
            }else{
              $CantIntervencionesProgramadasJul=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[8])){
              $CantIntervencionesProgramadasAgo=$ArrayCantIntervencionesProgramadas[8];
              $CantIntervencionesCumplenAgo=$ArrayCantIntervencionesCumplen[8];
            }else{
              $CantIntervencionesProgramadasAgo=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[9])){
               $CantIntervencionesProgramadasSep=$ArrayCantIntervencionesProgramadas[9];
               $CantIntervencionesCumplenSep=$ArrayCantIntervencionesCumplen[9];
            }else{
               $CantIntervencionesProgramadasSep=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[10])){
               $CantIntervencionesProgramadasOct=$ArrayCantIntervencionesProgramadas[10];
               $CantIntervencionesCumplenOct=$ArrayCantIntervencionesCumplen[10];
            }else{
               $CantIntervencionesProgramadasOct=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[11])){
               $CantIntervencionesProgramadasNov=$ArrayCantIntervencionesProgramadas[11];
               $CantIntervencionesCumplenNov=$ArrayCantIntervencionesCumplen[11];
            }else{
               $CantIntervencionesProgramadasNov=0;
            }
            
            if(isset($ArrayMesIntervencionesProgramadas[12])){
               $CantIntervencionesProgramadasDic=$ArrayCantIntervencionesProgramadas[12];
               $CantIntervencionesCumplenDic=$ArrayCantIntervencionesCumplen[12];
            }else{
               $CantIntervencionesProgramadasDic=0;
            }
  
            /////////////////////////////////////////////////////
            // Suma de intervenciones vencidas entre la fecha de la ultima intervencion/puestamarcha y la fecha actual
            
//         $queryCantIntervencionesVencidasAHoy="SELECT
//            SUM(Dias_Transcurridos)
//        (SELECT 
//	h.No_HV, 
//	p.Fecha_Marcha, 
//	i.Frecuencia, 
//	r.Fecha_Intervencion, 
//	IF(
//		r.Fecha_Intervencion <> '' && p.Fecha_Marcha <> '' && r.Fecha_Intervencion >= p.Fecha_Marcha, 
//		DATEDIFF(
//			'2016-12-16', r.Fecha_Intervencion
//		), 
//		IF(
//			p.Fecha_Marcha <> '', 
//			DATEDIFF('2016-12-16', p.Fecha_Marcha), 
//			0
//		)
//	) AS Dias_Transcurridos 
//FROM 
//	hoja_vida AS h 
//	LEFT JOIN puesta_marcha AS p ON h.No_HV = p.No_HV 
//	LEFT JOIN intervenciones AS i ON h.No_HV = i.HV_Equipo 
//	LEFT JOIN reportes_intervencion AS r ON h.No_HV = r.HV_Equipo 
//	AND i.Tipo_Intervencion = r.Tipo_Intervencion 
//WHERE 
//	CONCAT(p.No_HV, p.Version) IN (
//		SELECT 
//			CONCAT(
//				p.No_HV, 
//				MAX(p.Version)
//			) 
//		FROM 
//			puesta_marcha AS p 
//		WHERE 
//			1
//	) && CONCAT(
//		i.HV_Equipo, i.Tipo_Intervencion, 
//		i.Version_Intervencion
//	) IN (
//		SELECT 
//			CONCAT(
//				i.HV_Equipo, 
//				i.Tipo_Intervencion, 
//				MAX(i.Version_Intervencion)
//			) 
//		FROM 
//			intervenciones AS i 
//		WHERE 
//			1
//	) 
//GROUP BY 
//	h.No_HV, 
//	i.Tipo_Intervencion) AS BDCONDICIONADA
//WHERE 1";
//                 
//         $conexionIntervencionesVencidasAHoy=mysql_query($queryCantIntervencionesVencidasAHoy, $con);
//         
//         while($arrayCantIntervencionesVencidasAHoy=  mysql_fetch_array($conexionIntervencionesVencidasAHoy)){
//            echo $diasAhoy= $arrayCantIntervencionesVencidasAHoy['SUM(Dias_Transcurridos)'];
//            echo $frecuenciaEquipoActual=$arrayCantIntervencionesVencidasAHoy['i.Frecuencia'];
//         }
//            echo "</br>";
            
            
            ////////////////////////////////////////////////////
            // Suma de cantidades Mensuales
            
            $cantEne=$cantPrimerIntervencionesEnero+$PeriodosProyectadosEne+$CantIntervencionesProgramadasEne;
            
            $cantFeb=$PeriodosProyectadosFeb+$CantIntervencionesProgramadasFeb;
            
            $cantMar=$PeriodosProyectadosMar+$CantIntervencionesProgramadasMar;
            
            $cantAbr=$PeriodosProyectadosAbr+$CantIntervencionesProgramadasAbr;
            
            $cantMay=$PeriodosProyectadosMay+$CantIntervencionesProgramadasMay;
            
            $cantJun=$PeriodosProyectadosJun+$CantIntervencionesProgramadasJun;
            
            $cantJul=$PeriodosProyectadosJul+$CantIntervencionesProgramadasJul;
            
            $cantAgo=$PeriodosProyectadosAgo+$CantIntervencionesProgramadasAgo;
            
            $cantSep=$PeriodosProyectadosSep+$CantIntervencionesProgramadasSep;
            
            $cantOct=$PeriodosProyectadosOct+$CantIntervencionesProgramadasOct;
            
            $cantNov=$PeriodosProyectadosNov+$CantIntervencionesProgramadasNov;
            
            $cantDic=$PeriodosProyectadosDic+$CantIntervencionesProgramadasDic;
            
            
            // Calculo de % de Cumplimiento
            
            if($cantEne!=0 && isset($CantIntervencionesCumplenEne)){
            $CumplimientoEne=100*$CantIntervencionesCumplenEne/$cantEne;
            }else{
            $CumplimientoEne=0;    
            }
            if($cantFeb!=0 && isset($CantIntervencionesCumplenFeb)){
            $CumplimientoFeb=100*$CantIntervencionesCumplenFeb/$cantFeb;
            }else{
            $CumplimientoFeb=0;    
            }
            if($cantMar!=0 && isset($CantIntervencionesCumplenMar)){
            $CumplimientoMar=100*$CantIntervencionesCumplenMar/$cantMar;
            }else{
            $CumplimientoMar=0;    
            }
            if($cantAbr!=0 && isset($CantIntervencionesCumplenAbr)){
            $CumplimientoAbr=100*$CantIntervencionesCumplenAbr/$cantAbr;
            }else{
            $CumplimientoAbr=0;    
            }
            if($cantMay!=0 && isset($CantIntervencionesCumplenMay)){
            $CumplimientoMay=100*$CantIntervencionesCumplenMay/$cantMay;
            }else{
            $CumplimientoMay=0;    
            }
            if($cantJun!=0 && isset($CantIntervencionesCumplenJun)){
            $CumplimientoJun=100*$CantIntervencionesCumplenJun/$cantJun;
            }else{
            $CumplimientoJun=0;    
            }
            if($cantJul!=0 && isset($CantIntervencionesCumplenJul)){
            $CumplimientoJul=100*$CantIntervencionesCumplenJul/$cantJul;
            }else{
            $CumplimientoJul=0;    
            }
            if($cantAgo!=0 && isset($CantIntervencionesCumplenAgo)){
            $CumplimientoAgo=100*$CantIntervencionesCumplenAgo/$cantAgo;
            }else{
            $CumplimientoAgo=0;    
            }
            if($cantSep!=0 && isset($CantIntervencionesCumplenSep)){
            $CumplimientoSep=100*$CantIntervencionesCumplenSep/$cantSep;
            }else{
            $CumplimientoSep=0;    
            }
            if($cantOct!=0 && isset($CantIntervencionesCumplenOct)){
            $CumplimientoOct=100*$CantIntervencionesCumplenOct/$cantOct;
            }else{
            $CumplimientoOct=0;    
            }
            if($cantNov!=0 && isset($CantIntervencionesCumplenNov)){
            $CumplimientoNov=100*$CantIntervencionesCumplenNov/$cantNov;
            }else{
            $CumplimientoNov=0;    
            }
            if($cantDic!=0 && isset($CantIntervencionesCumplenDic)){
            $CumplimientoDic=100*$CantIntervencionesCumplenDic/$cantDic;
            }else{
            $CumplimientoDic=0;    
            }
?>            

    <div id="chart_div"></div>
        <script>
            
       google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawCurveTypes);

function drawCurveTypes() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mes');
      data.addColumn('number', '% Cumplimiento');
      data.addColumn('number', 'Meta');

      data.addRows([
        ['Ene',<?php echo $CumplimientoEne; ?>, 100],
        ['Feb',<?php echo $CumplimientoFeb; ?>, 100],
        ['Mar',<?php echo $CumplimientoMar; ?>, 100],
        ['Abr',<?php echo $CumplimientoAbr; ?>, 100],
        ['May',<?php echo $CumplimientoMay; ?>, 100],
        ['Jun',<?php echo $CumplimientoJun; ?>, 100],
        ['Jul',<?php echo $CumplimientoJul; ?>, 100],
        ['Ago',<?php echo $CumplimientoAgo; ?>, 100],
        ['Sep',<?php echo $CumplimientoSep; ?>, 100],
        ['Oct',<?php echo $CumplimientoOct; ?>, 100],
        ['Nov',<?php echo $CumplimientoNov; ?>, 100],
        ['Dic',<?php echo $CumplimientoDic; ?>, 100]
      ]);

      var options = {
          title: '1. % DE CUMPLIMIENTO AL PROGRAMA DE MANTENIMIENTO DE EQUIPOS Y METROLOGÍA',
        
        hAxis: {
          title: 'Meses'
        },
        vAxis: {
          title: '% de cumplimiento'
        },
        series: {
          1: {curveType: 'function'}
        },
        width:600
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    } 
        </script>
        
        <div id="chart_div1"></div>
    <br/>
        <script>
            
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawCurveTypes);

function drawCurveTypes() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mes');
      data.addColumn('number', 'Cantidad de intervenciones');
      data.addRows([
        ['Ene',<?php echo $cantEne; ?>],
        ['Feb',<?php echo $cantFeb; ?>],
        ['Mar',<?php echo $cantMar; ?>],
        ['Abr',<?php echo $cantAbr; ?>],
        ['May',<?php echo $cantMay; ?>],
        ['Jun',<?php echo $cantJun; ?>],
        ['Jul',<?php echo $cantJul; ?>],
        ['Ago',<?php echo $cantAgo; ?>],
        ['Sep',<?php echo $cantSep; ?>],
        ['Oct',<?php echo $cantOct; ?>],
        ['Nov',<?php echo $cantNov; ?>],
        ['Dic',<?php echo $cantDic; ?>]
      ]);

      var options = {
        
        title: '2. CANTIDAD DE MANTENIMIENTOS E INTERVENCIONES METROLOGICAS PROGRAMADAS',
        hAxis: {
          title: 'Meses'
        },
        vAxis: {
          title: 'Cantidad de intervenciones'
        },
        series: {
          1: {curveType: 'function'}
        },
        width:600
        
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));
      chart.draw(data, options);
    }  
   
    </script>    
</div>   
    </body>
</html>