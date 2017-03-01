<?php

include ('./conexion.php');
$con = conectar();


$DiasUltimasIntervenciones=$_POST['UltimasIntervenciones'];

$time=  time();
$fecharegistro=date("Y-m-d", $time);

$Sumar=$DiasUltimasIntervenciones." day";
$nuevafecha = date('Y-m-d', strtotime("$fecharegistro - $Sumar"));
echo $DesdeFechaIntervencion=$nuevafecha;

$queryIntervencionEquipo= "SELECT 
	p.Ubicacion,
        h.No_HV,
        h.Nombre_Equipo,
	p.Fecha_Marcha, 
	r.Fecha_Intervencion, 
	i.Tipo_Intervencion, 
	r.Nombre_Proveedor, 
	r.Nombre_Tecnico,
	IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>$fecharegistro,
       DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	),
       
    
                p.Fecha_Marcha
		
	) AS PROXIMA_FECHA,
    
       
	IF(DATE_ADD(
			p.Fecha_Marcha, INTERVAL i.Frecuencia DAY
		)>='$fecharegistro', 
		'Vigente',
		'Vencido'
	) as ESTADO 
FROM 
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
	LEFT JOIN intervenciones as i ON h.No_HV = i.HV_Equipo 
	LEFT JOIN reportes_intervencion as r ON h.No_HV = r.HV_Equipo 
	AND i.Tipo_Intervencion = r.Tipo_Intervencion 
WHERE
    
    r.Fecha_Intervencion<>''
    
    &&
    
    DATE_SUB('$fecharegistro', INTERVAL 30 DAY)<=r.Fecha_Intervencion
    
    &&
        
    r.Fecha_Intervencion<='$fecharegistro'
    
    &&
        
    
    
    i.Frecuencia>0 &&
	i.Tipo_Intervencion<>'' &&
    
    IF(
    p.Fecha_Marcha is not null OR r.Fecha_Intervencion, 1,null)
    
    is not null &&
       
	IF(
		i.HV_Equipo is null, 
		1, 
		concat(h.No_HV, i.Version_Intervencion) in (
			SELECT 
				concat(
					h.No_HV, 
					MAX(i.Version_Intervencion)
				) 
			FROM 
				hoja_vida as h 
				LEFT JOIN intervenciones as i ON h.No_HV = i.HV_Equipo 
			GROUP BY 
				h.No_HV
		)
	) 
	AND IF(
		r.HV_Equipo is null, 
		1, 
		concat(h.No_HV, r.Version_Intervencion) in (
			SELECT 
				concat(
					h.No_HV, 
					MAX(r.Version_Intervencion)
				) 
			FROM 
				hoja_vida as h 
				LEFT JOIN reportes_intervencion AS r ON h.No_HV = r.HV_Equipo 
			GROUP BY 
				h.No_HV
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
               echo json_encode('No Existen');
               }


?>
