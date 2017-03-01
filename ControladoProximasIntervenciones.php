<?php

include ('./conexion.php');
$con = conectar();


$DiasProximasIntervenciones=$_POST['DiasProximasIntervenciones'];

$time=  time();
$fecharegistro=date("Y-m-d", $time);




//otra manera de generar formato a una fecha:
//$nuevafecha = new DateTime($fecharegistro);
//$nuevafecha->modify($Sumar);
//echo $nuevafecha->format('Y-m-d');


// podes sumar 1 dia o su equivalente en segundos (tenes que borrar una de las 2 lineas):


$Sumar=$DiasProximasIntervenciones." day";
$nuevafecha = date('Y-m-d', strtotime("$fecharegistro + $Sumar"));
$MaximaProximaFechaIntervencionControlar=$nuevafecha;

$queryIntervencionEquipo= "SELECT
	p.Area,
        r.Nombre_Proveedor,
        t.Version_Intervencion AS Version_Planificada,
        t.Nombre_Proveedor as Proveedor_Planificado,
        t.Fecha_Programada,
        h.No_HV,
        h.Nombre_Equipo,
        r.Fecha_Intervencion, 
        i.Tipo_Intervencion,
        r.Version_Intervencion AS Version_Intervencion,
        IF(t.Fecha_Programada IS null, '','') as Estado,
	IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
                
        ), p.Fecha_Marcha) AS PROXIMA_FECHA,
        IF(DATEDIFF(IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	), 
        
		
            p.Fecha_Marcha),                

        '$fecharegistro')>=0,'PROXIMANTE','VENCIDO') AS 'VIGENCIA'

FROM 
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
	LEFT JOIN intervenciones as i ON h.No_HV = i.HV_Equipo 
	LEFT JOIN reportes_intervencion as r ON h.No_HV = r.HV_Equipo 
	AND i.Tipo_Intervencion = r.Tipo_Intervencion
        
    LEFT JOIN programacion_intervencion as t ON h.No_HV = t.HV_Equipo AND i.Tipo_Intervencion=t.Tipo_Intervencion
WHERE
CONCAT(p.No_HV,p.Version) IN 
    (SELECT CONCAT(p.No_HV,MAX(p.Version)) FROM puesta_marcha AS p GROUP BY p.No_HV)
    &&
    p.Fecha_Descarte='0000-00-00'
    &&
    IF(DATEDIFF(IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	
    ), 
    p.Fecha_Marcha),
        '$fecharegistro')>=0,'PROXIMAMENTE','VENCIDO')='PROXIMAMENTE'
    &&
    IF(r.Fecha_Intervencion<>'',DATE_ADD(
			r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY

                )>='2000-01-01',DATE_ADD(
			p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
		)>='2000-01-01'
		) &&
        
        IF(r.Fecha_Intervencion<>'',DATE_ADD(
			r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
		)<='$MaximaProximaFechaIntervencionControlar',DATE_ADD(
			p.Fecha_Marcha, INTERVAL 0 DAY
		)<='$MaximaProximaFechaIntervencionControlar' 
		) &&
        
    i.Frecuencia>0 &&
	i.Tipo_Intervencion<>'' &&
    IF(
    p.Fecha_Marcha is not null OR r.Fecha_Intervencion, 1,null)
    is not null &&
	IF(
		i.HV_Equipo is null, 
		1, 
		concat(h.No_HV, i.Version_Intervencion,i.Tipo_Intervencion) in (
			SELECT 
                            concat(
					h.No_HV, 
					MAX(i.Version_Intervencion),
                                        i.Tipo_Intervencion
				) 
			FROM 
				hoja_vida as h 
				LEFT JOIN intervenciones as i ON h.No_HV = i.HV_Equipo 
			GROUP BY 
				h.No_HV,
                                i.Tipo_Intervencion    
        )
	) 
	AND IF(
		r.HV_Equipo is null, 
		1, 
		concat(h.No_HV, r.Version_Intervencion,r.Tipo_Intervencion) in (
			SELECT 
				concat(
					h.No_HV,
					MAX(r.Version_Intervencion),
                                        r.Tipo_Intervencion
				)
			FROM 
				hoja_vida as h 
				LEFT JOIN reportes_intervencion AS r ON h.No_HV = r.HV_Equipo 
			GROUP BY 
				h.No_HV,
                                r.Tipo_Intervencion
        	)
	)
        AND IF(
		t.HV_Equipo is null, 
		1, 
		concat(h.No_HV, t.Version_Programacion,t.Tipo_Intervencion) in (
			SELECT 
				concat(
					h.No_HV, 
					MAX(t.Version_Programacion),
                                        t.Tipo_Intervencion
				) 
			FROM 
				hoja_vida as h 
				LEFT JOIN programacion_intervencion AS t ON h.No_HV = t.HV_Equipo 
			GROUP BY 
				h.No_HV,
                                t.Tipo_Intervencion
		)
	)
GROUP BY 
	h.No_HV,
	i.Tipo_Intervencion";
           
           $conexionIntervencionEquipo=mysql_query($queryIntervencionEquipo, $con);
           
           $numero = mysql_num_rows($conexionIntervencionEquipo);

           if($numero>0){
               
              echo json_encode($numero);
               
           } else {
               echo json_encode(0);
               }


?>
