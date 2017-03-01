<?php
session_start();
require_once './dompdf_0-7-0/dompdf/autoload.inc.php';
require_once ('./conexion.php');
$con=  conectar();
use Dompdf\Dompdf;
$codigoOrden=$_GET['id'];
//$codigoOrden=6;
    
$content='
<html>
    <head>
        <meta charset="UTF-8">
        <title>Orden Intervencion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script src="jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
    </head>
    <body>';
       
            $queryOrdenProgramada="SELECT 
	Cod_Servicio,    
        HV_Equipo, 
	Tipo_Intervencion, 
	Nombre_Proveedor,
        Observacion,
        Fecha_Solicitud,
	Fecha_Programada, 
	Fecha_Realizacion, 
	Estado 
FROM 
	programacion_intervencion 
WHERE 
	Cod_Servicio = '$codigoOrden'";
               
               $conexionOrdenProgramada= mysql_query($queryOrdenProgramada, $con);
               
               while($arrayOrdenProgramada=mysql_fetch_array($conexionOrdenProgramada)){
               
               
               $codServicio=$arrayOrdenProgramada['Cod_Servicio'];
               $arrayOrdenProgramada['HV_Equipo'];
               $arrayOrdenProgramada['Tipo_Intervencion'];
               $proveedor=$arrayOrdenProgramada['Nombre_Proveedor'];
               $Observacion=$arrayOrdenProgramada['Observacion'];
               $FechaSolicitud=$arrayOrdenProgramada['Fecha_Solicitud'];
               $FechaProgramada=$arrayOrdenProgramada['Fecha_Programada'];
               $arrayOrdenProgramada['Fecha_Realizacion'];
               $arrayOrdenProgramada['Estado'];
               
               }
            

            $content.='<div class="container">
                <h1 id="titulo" style="text-align: center;">ORDEN DE SERVICIO INTERVENCION A EQUIPOS</h1>
            
                <br/>
                
                <div id="CantenedorTablaOrdenador">
                <form method="POST" action="#" id="formularioEdicion">
                    <table>
                <tr>
                    <td>NOMBRE PROVEDOR:</td>
                    <td>'.$proveedor.'</td>
                    <td style="width: 600px;"></td>
                    <td>No ORDEN: </td>
                    <td><strong>'.$codServicio.'</strong></td>
                </tr>
                <tr>
                    <td>FECHA SOLICITUD:</td>
                    <td style="width: 80px;">'.$FechaSolicitud.'</td>
                </tr>
                <tr>
                    <td>FECHA ESPERADA EJECUCIÓN:</td>
                    <td>'.$FechaProgramada.'</td>
                    </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td colspan="4"><textarea class="form-control" rows="3" value="'.$Observacion.'">'.$Observacion.'</textarea></td>
                </tr>
                
            </table>
                </form>
                </div>
                <br/>
                <br/>
                <h3 style="text-align: center;border: #eee 1px solid;margin: 0px;padding: 5px;">EQUIPOS A INTERVENIR</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>CIUDAD</td>
                            <td>SEDE</td>
                            <td>AREA</td>
                            <td>COD EQUIPO</td>
                            <td>NOMBRE EQUIPO</td>
                            <td>TIPO INTERVENCION</td>
                            <td>FECHA PRESUPUESTADA</td>
                            <td>FECHA EJECUCIÓN</td>
                            <td>ESTADO</td>
                        </tr>
                    </thead>';
                    
               $content.='<tbody>';
               
               $queryOrdenProgramada="SELECT 
	m.Sede, 
	m.Area, 
	m.SubArea, 
	p.HV_Equipo, 
	h.Nombre_Equipo, 
	p.Tipo_Intervencion, 
	p.Nombre_Proveedor, 
	p.Fecha_Programada, 
	p.Fecha_Realizacion, 
	p.Estado 
FROM 
	hoja_vida AS h 
	LEFT JOIN programacion_intervencion AS p ON h.No_HV = p.HV_Equipo 
	LEFT JOIN puesta_marcha AS m ON p.HV_Equipo = m.No_HV 
WHERE 
	Cod_Servicio = '$codigoOrden' && CONCAT(m.No_HV, m.Fecha_Marcha) IN (
		SELECT 
			CONCAT(
				m.No_HV, 
				MAX(m.Fecha_Marcha)
			) 
		FROM 
			puesta_marcha AS m 
		GROUP BY 
			m.No_HV
	) 
GROUP BY 
	p.HV_Equipo, 
	p.Tipo_Intervencion";
               
               $conexionOrdenProgramada= mysql_query($queryOrdenProgramada, $con);
               
               while($arrayOrdenProgramada=mysql_fetch_array($conexionOrdenProgramada)){
               
               $content.='<tr>';
               
               $content.='<td>'.$arrayOrdenProgramada['Sede'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['Area'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['SubArea'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['HV_Equipo'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['Nombre_Equipo'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['Tipo_Intervencion'].'</td>';
               
               $content.='<td>'.$arrayOrdenProgramada['Fecha_Programada'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['Fecha_Realizacion'].'</td>';
               $content.='<td>'.$arrayOrdenProgramada['Estado'].'</td>';
               
               }
                $content.='</tr>';
               
           $content.='</tbody>';
               
               
            $content.='
            </table>
            
            <br/>
                <br/>
                
                <p>SOLICITUD REALIZADA POR:<strong><u>'.$_SESSION['usuario'].'</u></strong></p>
                <br/>
                <br/>



        
        </body>
</html>';



// reference the Dompdf namespace

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>