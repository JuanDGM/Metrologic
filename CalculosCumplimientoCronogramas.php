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

// CANTIDAD DE INTERVENCIONES EN LA PRIMER INTERVENCION DEL EQUIPO

$queryPrimeraIntervencionesENE="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '1' && Version='1'";


$conexionPuestaMarchaENE=mysql_query($queryPrimeraIntervencionesENE, $con);

while($arrayPuestaMarchaENE=mysql_fetch_array($conexionPuestaMarchaENE)){
    echo $puestaMarchaENE=$arrayPuestaMarchaENE['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesFEB="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '2' && Version='1'";


$conexionPuestaMarchaFEB=mysql_query($queryPrimeraIntervencionesFEB, $con);

while($arrayPuestaMarchaFEB=mysql_fetch_array($conexionPuestaMarchaFEB)){
    echo $puestaMarchaFEB=$arrayPuestaMarchaFEB['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesMAR="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '3' && Version='1'";


$conexionPuestaMarchaMAR=mysql_query($queryPrimeraIntervencionesMAR, $con);

while($arrayPuestaMarchaMAR=mysql_fetch_array($conexionPuestaMarchaMAR)){
    echo $puestaMarchaMAR=$arrayPuestaMarchaMAR['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesABR="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '4' && Version='1'";


$conexionPuestaMarchaABR=mysql_query($queryPrimeraIntervencionesABR, $con);

while($arrayPuestaMarchaABR=mysql_fetch_array($conexionPuestaMarchaABR)){
    echo $puestaMarchaABR=$arrayPuestaMarchaABR['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesMAY="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '5' && Version='1'";


$conexionPuestaMarchaMAY=mysql_query($queryPrimeraIntervencionesMAY, $con);

while($arrayPuestaMarchaMAY=mysql_fetch_array($conexionPuestaMarchaMAY)){
    echo $puestaMarchaMAY=$arrayPuestaMarchaMAY['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesJUN="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '6' && Version='1'";


$conexionPuestaMarchaJUN=mysql_query($queryPrimeraIntervencionesJUN, $con);

while($arrayPuestaMarchaJUN=mysql_fetch_array($conexionPuestaMarchaJUN)){
    echo $puestaMarchaJUN=$arrayPuestaMarchaJUN['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesJUL="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '7' && Version='1'";


$conexionPuestaMarchaJUL=mysql_query($queryPrimeraIntervencionesJUL, $con);

while($arrayPuestaMarchaJUL=mysql_fetch_array($conexionPuestaMarchaJUL)){
    echo $puestaMarchaJUL=$arrayPuestaMarchaJUL['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesAGO="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '8' && Version='1'";


$conexionPuestaMarchaAGO=mysql_query($queryPrimeraIntervencionesAGO, $con);

while($arrayPuestaMarchaAGO=mysql_fetch_array($conexionPuestaMarchaAGO)){
    echo $puestaMarchaAGO=$arrayPuestaMarchaAGO['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesSEP="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '9' && Version='1'";


$conexionPuestaMarchaSEP=mysql_query($queryPrimeraIntervencionesSEP, $con);

while($arrayPuestaMarchaSEP=mysql_fetch_array($conexionPuestaMarchaSEP)){
    echo $puestaMarchaSEP=$arrayPuestaMarchaSEP['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesOCT="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '10' && Version='1'";


$conexionPuestaMarchaOCT=mysql_query($queryPrimeraIntervencionesOCT, $con);

while($arrayPuestaMarchaOCT=mysql_fetch_array($conexionPuestaMarchaOCT)){
    echo $puestaMarchaOCT=$arrayPuestaMarchaOCT['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesNOV="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '11' && Version='1'";


$conexionPuestaMarchaNOV=mysql_query($queryPrimeraIntervencionesNOV, $con);

while($arrayPuestaMarchaNOV=mysql_fetch_array($conexionPuestaMarchaNOV)){
    echo $puestaMarchaNOV=$arrayPuestaMarchaNOV['Cant_Intervenciones'];
}
$queryPrimeraIntervencionesDIC="SELECT 
	COUNT(No_HV) AS Cant_Intervenciones 
FROM 
	(
		SELECT 
			p.No_HV,
                        p.Version,
			p.Fecha_Marcha, 
			i.Tipo_Intervencion, 
			i.Frecuencia, 
			i.Aplica_Desde, 
			IF(
				i.Aplica_Desde = 'Puesta en marcha', 
				p.Fecha_Marcha, 
				DATE_ADD(
					p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
				)
			) AS PRIMER_INTERVENCION, 
			YEAR(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS ANIO_PRIMER, 
			MONTH(
				IF(
					i.Aplica_Desde = 'Puesta en marcha', 
					p.Fecha_Marcha, 
					DATE_ADD(
						p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
					)
				)
			) AS MES_PRIMER 
		FROM 
			puesta_marcha AS p 
			LEFT JOIN intervenciones AS i ON p.No_HV = i.HV_Equipo 
		WHERE 
			1 
		GROUP BY 
			p.Fecha_Marcha, 
			p.Version
	) AS BD 
WHERE 
	ANIO_PRIMER = '2017' && MES_PRIMER = '12' && Version='1'";


$conexionPuestaMarchaDIC=mysql_query($queryPrimeraIntervencionesDIC, $con);

while($arrayPuestaMarchaDIC=mysql_fetch_array($conexionPuestaMarchaDIC)){
    echo $puestaMarchaDIC=$arrayPuestaMarchaDIC['Cant_Intervenciones'];
}

// CANTIDAD DE INTERVENCIONES REALIZADAS




  ?> 
</div>   
    </body>
</html>