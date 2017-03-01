<?php
session_start();
require_once './dompdf_0-7-0/dompdf/autoload.inc.php';
require_once ('./conexion.php');
$con=  conectar();
use Dompdf\Dompdf;



$conten='
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ficha Equipo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosHojaVida.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="validacionHv.js"></script>
        <script src="crearhvajax.js"></script>   
        <script src="editarHV.js"></script>   
        <script src="cargarImagenEquipo.js"></script>   
        <script src="asignarCodigo.js"></script>
        <script src="SeleccionUbicacionEquipos.js"></script>
        <script src="SeleccionSenalizacionRiesgos.js"></script>
       
    </head>
    <body id="cuerpo">';
$codHV=$_GET['id'];

    $querySeleccionImagenquipo="SELECT 
	Ruta 
FROM 
	imagenes_equipos 
WHERE 
	No_HV='$codHV'";

$conexionImagenEquipo=mysql_query($querySeleccionImagenquipo, $con);

while($arrayImagen=mysql_fetch_array($conexionImagenEquipo)){
    $imagenEquipo=$arrayImagen['Ruta'];
}

$queryDatosEquipo="SELECT 
	Tipo_Equipo, 
	Nombre_Equipo, 
	Nombre_Proveedor, 
	Modelo, 
	No_Serie, 
	Marca, 
	Voltaje, 
	Amperaje, 
	Potencia, 
	Caracteristicas, 
	Razon_SocialProveedor, 
	Nit_Proveedor, 
	Ciudad_Proveedor, 
	Direccion_Proveedor, 
	Telefono_Proveedor, 
	Celular_Proveedor, 
	Registro_Invima, 
	Inversion, 
	Edad_Equipo, 
	Vida_Contable, 
	Disp_Soporte_Repuestos, 
	Disp_Soporte_Consumibles, 
	Soporte_Tecnico_Respuestos 
FROM 
	hoja_vida 
WHERE 
	No_HV='$codHV'";

$conexionInformacionHV=mysql_query($queryDatosEquipo, $con);

while($arrayInfomHV=mysql_fetch_assoc($conexionInformacionHV)){
        $tipoEquipo=$arrayInfomHV['Tipo_Equipo'];
        $nombreEquipo=$arrayInfomHV['Nombre_Equipo']; 
	$nombreProveedor=$arrayInfomHV['Nombre_Proveedor']; 
	$modelo=$arrayInfomHV['Modelo']; 
	$serie=$arrayInfomHV['No_Serie']; 
	$marca=$arrayInfomHV['Marca']; 
	$voltaje=$arrayInfomHV['Voltaje']; 
	$amperaje=$arrayInfomHV['Amperaje']; 
	$potencia=$arrayInfomHV['Potencia']; 
	$caracteriscas=$arrayInfomHV['Caracteristicas']; 
	$razonSocial=$arrayInfomHV['Razon_SocialProveedor']; 
	$nitProveedor=$arrayInfomHV['Nit_Proveedor']; 
	$ciudadProveedor=$arrayInfomHV['Ciudad_Proveedor']; 
	$direccionProveedor=$arrayInfomHV['Direccion_Proveedor']; 
	$telefonoProveedor=$arrayInfomHV['Telefono_Proveedor']; 
	$celularProveedor=$arrayInfomHV['Celular_Proveedor']; 
	$registroInvima=$arrayInfomHV['Registro_Invima']; 
	$inversion=$arrayInfomHV['Inversion']; 
	$edadEquipo=$arrayInfomHV['Edad_Equipo']; 
	$vidaContable=$arrayInfomHV['Vida_Contable']; 
	$dispSoporteRepuestos=$arrayInfomHV['Disp_Soporte_Repuestos']; 
	$dispSoporteConsumibles=$arrayInfomHV['Disp_Soporte_Consumibles']; 
	$dispSoporteTecnicoRepuestos=$arrayInfomHV['Soporte_Tecnico_Respuestos'];
}


        if(isset($tipoEquipo)){$te=$tipoEquipo;}else{$te="";}
        if(isset($nombreEquipo)){$ne=$nombreEquipo;}else{$ne="";}
	if(isset($nombreProveedor)){$np=$nombreProveedor;}else{$np="";} 
	if(isset($modelo)){$mod=$modelo;}else{$mod="";}
	if(isset($serie)){$s=$serie;}else{$s="";}
	if(isset($marca)){$mar=$marca;}else{$mar="";} 
	if(isset($voltaje)){$vol=$voltaje;}else{$vol="";}
	if(isset($amperaje)){$amp=$amperaje;}else{$amp="";}
	if(isset($potencia)){$pot=$potencia;}else{$pot="";}
	if(isset($caracteriscas)){$car=$caracteriscas;}else{$car="";}
	if(isset($razonSocial)){$razon=$razonSocial;}else{$razon="";}
	if(isset($nitProveedor)){$nit=$nitProveedor;}else{$nit="";}
	if(isset($ciudadProveedor)){$ciudad=$ciudadProveedor;}else{$ciudad="";}
	if(isset($direccionProveedor)){$direccion=$direccionProveedor;}else{$direccion="";}
	if(isset($telefonoProveedor)){$telefono=$telefonoProveedor;}else{$telefono="";}
	if(isset($celularProveedor)){$celular=$celularProveedor;}else{$celular="";}
	if(isset($registroInvima)){$Invima=$registroInvima;}else{$Invima="";}
	if(isset($inversion)){$inver=$inversion;}else{$inver="";}
	if(isset($edadEquipo)){$edadE=$edadEquipo;}else{$edadE="";}
	if(isset($vidaContable)){$vidaCont=$vidaContable;}else{$vidaCont="";}
	if(isset($dispSoporteRepuestos)){$dispSoporteR=$dispSoporteRepuestos;}else{$dispSoporteR="";} 
	if(isset($dispSoporteConsumibles)){$dispSoporteC=$dispSoporteConsumibles;}else{$dispSoporteC="";} 
	if(isset($dispSoporteTecnicoRepuestos)){$dispSoporteTecnicoR=$dispSoporteTecnicoRepuestos;}else{$dispSoporteTecnicoR="";}

        // Ubicacion y puesta en marcha
        
        $queryUbicacion="SELECT 
	Sede, 
	Area, 
	SubArea, 
	Fecha_Marcha 
FROM 
	puesta_marcha 
WHERE 
	CONCAT(No_HV, Version) IN (
		SELECT 
			CONCAT(
				No_HV, 
				MAX(Version)
			) 
		FROM 
			puesta_marcha 
		GROUP BY 
			No_HV
	) && No_HV = '$codHV'";

        $conexionUbicacion=mysql_query($queryUbicacion, $con);
        
        while($arrayUbicacion=  mysql_fetch_assoc($conexionUbicacion)){
            $Ciudad=$arrayUbicacion['Sede'];
            $Sede=$arrayUbicacion['Area'];
            $area=$arrayUbicacion['SubArea'];
            $fechaMarcha=$arrayUbicacion['Fecha_Marcha'];
        }
        
        if(isset($Ciudad)){$CiudadV=$Ciudad;}else{$CiudadV="";}
        if(isset($Sede)){$sedeV=$Sede;}else{$sedeV="";}
        if(isset($area)){$areaV=$area;}else{$areaV="";}
        if(isset($fechaMarcha)){$fechaMarchaV=$fechaMarcha;}else{$fechaMarchaV="";}
        
        
        // Frecuencias de intervenciones metrologicas
        
        
        $QueryIntervencionesManto="SELECT 
	Tipo_Intervencion, 
	Frecuencia, 
	Aplica_Desde 
FROM 
	intervenciones 
WHERE 
	CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo
	) && HV_Equipo = '$codHV' && Tipo_Intervencion='Mantenimiento preventivo'";
        
        $conexionIntervencionesManto=mysql_query($QueryIntervencionesManto, $con);
        
        while($arrayFrecuenciaManto=  mysql_fetch_assoc($conexionIntervencionesManto)){
            $frecuenciaManto=$arrayFrecuenciaManto['Frecuencia'];
            $aplicaManto=$arrayFrecuenciaManto['Aplica_Desde'];
        }
         
        $QueryIntervencionesVerificacion="SELECT 
	Tipo_Intervencion, 
	Frecuencia, 
	Aplica_Desde 
FROM 
	intervenciones 
WHERE 
	CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo
	) && HV_Equipo = '$codHV' && Tipo_Intervencion='Verificacion'";
        
        $conexionIntervencionesVerificacion=mysql_query($QueryIntervencionesVerificacion, $con);
        
        while($arrayFrecuenciaVerificacion=  mysql_fetch_assoc($conexionIntervencionesVerificacion)){
            $frecuenciaVerificacion=$arrayFrecuenciaVerificacion['Frecuencia'];
            $aplicaVerificacion=$arrayFrecuenciaVerificacion['Aplica_Desde'];
        }
         
        $QueryIntervencionesCalibracion="SELECT 
	Tipo_Intervencion, 
	Frecuencia, 
	Aplica_Desde 
FROM 
	intervenciones 
WHERE 
	CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo
	) && HV_Equipo = '$codHV' && Tipo_Intervencion='Calibracion'";
        
        $conexionIntervencionesCalibracion=mysql_query($QueryIntervencionesCalibracion, $con);
        
        while($arrayFrecuenciaCalibracion=  mysql_fetch_assoc($conexionIntervencionesCalibracion)){
            $frecuenciaCalibracion=$arrayFrecuenciaCalibracion['Frecuencia'];
            $aplicaCalibracion=$arrayFrecuenciaCalibracion['Aplica_Desde'];
        }
        
        $QueryIntervencionesCalificacion="SELECT 
	Tipo_Intervencion, 
	Frecuencia, 
	Aplica_Desde 
FROM 
	intervenciones 
WHERE 
	CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo
	) && HV_Equipo = '$codHV' && Tipo_Intervencion='Calificacion'";
        
        $conexionIntervencionesCalificacion=mysql_query($QueryIntervencionesCalificacion, $con);
        
        while($arrayFrecuenciaCalificacion=  mysql_fetch_assoc($conexionIntervencionesCalificacion)){
            $frecuenciaCalificacion=$arrayFrecuenciaCalificacion['Frecuencia'];
            $aplicaCalificacion=$arrayFrecuenciaCalificacion['Aplica_Desde'];
        }
        
        $QueryIntervencionesOtro="SELECT 
	Tipo_Intervencion, 
	Frecuencia, 
	Aplica_Desde 
FROM 
	intervenciones 
WHERE 
	CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		GROUP BY 
			HV_Equipo
	) && HV_Equipo = '$codHV' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
        
        $conexionIntervencionesOtro=mysql_query($QueryIntervencionesOtro, $con);
        
        while($arrayFrecuenciaOtro=  mysql_fetch_assoc($conexionIntervencionesOtro)){
            $TipoIntervencionOtro=$arrayFrecuenciaOtro['Tipo_Intervencion'];
            $frecuenciaOtro=$arrayFrecuenciaOtro['Frecuencia'];
            $aplicaOtro=$arrayFrecuenciaOtro['Aplica_Desde'];
        }
        
        $conten.='<h1 style="text-align:center;font-wight:bold;">HOJA DE VIDA DEL EQUIPO</h1>';

        $conten.='<div class="panel-group">
                            <div id="panel1" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" 
                                           >
                                            INFORMACIÓN GENERAL DEL EQUIPO
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body" id="contenedor1">
                                    
                                    <table>
                                        <tr>
                                        <td>
                                        <div id="contenedorImagen">';
                                                    $conten.='<span alt="..." class="img-thumbnail" style="max-width:250px;height:205px;">';
                                                    
                                                    if(isset($imagenEquipo)){
                                                        $foto=$imagenEquipo;
                                                    }else{
                                                        $foto="./images/EquipoSinImagen/no_image.png";
                                                    }
                                                    
                                                    $conten.='<img style="max-width:250px;height:205px;" src="'.$foto.'">';
                                                    $conten.='</span>      
                                        </div>                      
                                        </td>
                                        <td style="width:100px;"></td>
                                        <td>      
                                                    <divclass="form-group">
                                                        <label class="control-label" for="inputSuccess2">N° HOJA DE VIDA</label>
                                                        <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$codHV.'</div>
                                        </div>
                                        
                                                    <div class="form-group">
                                                        <label for="exampleInputName2">TIPO DE EQUIPO</label>
                                                        <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$te.'</div>
         
                                                    </div>
                                        
                                        <div class="form-group"> 
                                                        <label for="exampleInputName2">NOMBRE DE EQUIPO</label>
                                                        <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$ne.'</div>
 
                                                    </div>
                                        
                                        <div class="form-group">
                                                        <label for="exampleInputName2">NOMBRE PROVEEDOR DEL EQUIPO</label>
                                                                <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$np.'</div>
 
                                                    </div>
                                        </td>
                                        </tr>
                                        </table>                
                                        </div>
                                    </div>
                                </div>';
                            
                                $conten.="<br/>";                    
                                                    
                                                    
                                $conten.='<div id="panel2" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            ESPECIFICACIONES TÉCNICAS
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in">
                                    <div class="panel-body">

                                        <table>  
                                        <tr>
                                        <td>

                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">MODELO</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$mod.'</div>

                                        </div>
                                        </td>    
                                        <td>    
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">N° SERIE</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$s.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">MARCA</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$mar.'</div>

                                        </div>
                                      </td>
                                      </tr>
                                      <tr>
                                      <td>  
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">VOLTAJE</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$vol.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">AMPERAJE</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$amp.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">POTENCIA</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$pot.'</div>

                                        </div>
                                        </td>
                                        <tr>
                                        <td colspan="3">
                                        <div class="form-group col-md-4 col-lg-12">
                                            <label id="labelTxtArea" for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">CARACTERISTICAS Y COMPONENTES DEL EQUIPO<br/></label>
                                                    <div style="border: 1px solid;height:50px;width:630px;vertical-align: middle;" class="form-control">'.$car.'</div>

                                        </div>
                                    </td>
                                    </tr>
                                        </table>

                                </div>
                            </div>
                            </div>';                    
                            
                            // informacion de la compra    
                                
                            $conten.='<br/>';
                                
                            $conten.='<div id="panel2" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion7">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            INFORMACIÓN DE LA COMPRA
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="panel-collapse collapse in">
                                    <div class="panel-body">


                                    <table>    
                                        <tr>
                                          <td>
                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">RAZON SOCIAL DEL PROVEEDOR </label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$razon.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">NIT DEL PROVEEDOR</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$nit.'</div>

                                        </div>
                                        </td>    
                                        <td>    
                                            
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">CIUDAD</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$ciudad.'</div>

                                        </div>
                                        </td>    
                                        </tr>
                                        <tr>
                                        <td>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DIRECCIÓN</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$direccion.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">TELEFONO FIJO</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$telefono.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">CELULAR</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$celular.'</div>

                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">NO REGISTRO INVIMA</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$Invima.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">VALOR INVERSIÓN EQUIPO</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$inver.'</div>

                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">EDAD DEL EQUIPO</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$edadE.'</div>

                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>    
                                        
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">VIDA UTIL CONTABLE</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$vidaCont.'</div>

                                        </div>
                                        </td>  
                                        
                                        <td>
                                            <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DISPONIBILIDAD DE SOPORTE DE REPUESTOS</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$dispSoporteR.'</div>
                                        
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DISPONIBILIDAD DE SOPORTES DE CONSUMIBLES</label>
                                                <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$dispSoporteC.'</div>
                                        
                                        </div>
                                        </td>    
                                        <tr>
                                        <td>    
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">PROVEEDOR SOPORTE TECNICO INCLUYE REPUESTOS</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$dispSoporteTecnicoR.'</div>
                                        
                                        </div>
                                        </td>
                                        </tr>
                                    </table>    
                                        
                                </div>
                            </div>
                            </div>';
                                
                            //ubicacion y puesta en marcha
                            
                            $conten.='<br/>';
                            $conten.='<div id="panel3" class="panel panel-default">
                            <div class="panel-heading" role="tab" id="barraExpancion3">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        UBICACIÓN Y PUESTA EN MARCHA
                                    </a>
                                </h4>
                            </div>
                            
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    
                                <table style="margin:auto;">
                                <tr>
                                <td>
                                    <div class="form-group" style="margin-right: 30px;">
                                                    <label for="exampleInputName2">CIUDAD</label>
                                                    <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$CiudadV.'</div>
                                                </div>

                                   </td>
                                   <td>
                                    <div class="form-group" style="margin-right: 30px;">
                                                    <label for="exampleInputName2">SEDE</label>
                                                            <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$sedeV.'</div>

                                                </div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                                <div class="form-group" style="">
                                                    <label for="exampleInputName2">AREA</label>
                                                            <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$areaV.'</div>
                                                </div>
                                    </td>
                                    <td>
                                                <div class="form-group" style="">
                                                  <p style="width: 200px;margin-top: -5px;margin-left: 30px;font-weight: bold;">FECHA PUESTA MARCHA</p>
                                                            <div style="border: 1px solid;height:15px;width:170px;vertical-align: middle;" class="form-control">'.$fechaMarchaV.'</div> 
                                                </div>
                                    </td>
                                    </tr>
                                    </table>
                                </div>
                            </div>
                        </div>';
                            
                            
                            // PARAMETRIZACION DE INTERVENCIONES
                            
                            $queryIdentificarFrecuenciaManto="SELECT 
                                                                Frecuencia, 
                                                                Aplica_Desde 
                                                        FROM 
                                                                intervenciones 
                                                        WHERE 
                                                                Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(HV_Equipo, Version_Intervencion) IN (
                                                                        SELECT 
                                                                                CONCAT(
                                                                                        HV_Equipo, 
                                                                                        MAX(Version_Intervencion)
                                                                                ) 
                                                                        FROM 
                                                                                intervenciones
                                                                ) && HV_Equipo = '$codHV'";
                            
                            $queryIdentificarFrecuenciaVerificacion="SELECT 
                                                                Frecuencia, 
                                                                Aplica_Desde 
                                                        FROM 
                                                                intervenciones 
                                                        WHERE 
                                                                Tipo_Intervencion = 'Verificacion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
                                                                        SELECT 
                                                                                CONCAT(
                                                                                        HV_Equipo, 
                                                                                        MAX(Version_Intervencion)
                                                                                ) 
                                                                        FROM 
                                                                                intervenciones
                                                                ) && HV_Equipo = '$codHV'";
                            
                            $queryIdentificarFrecuenciaCalibracion="SELECT 
                                                                Frecuencia, 
                                                                Aplica_Desde 
                                                        FROM 
                                                                intervenciones 
                                                        WHERE 
                                                                Tipo_Intervencion = 'Calibracion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
                                                                        SELECT 
                                                                                CONCAT(
                                                                                        HV_Equipo, 
                                                                                        MAX(Version_Intervencion)
                                                                                ) 
                                                                        FROM 
                                                                                intervenciones
                                                                ) && HV_Equipo = '$codHV'";
                            
                            
                            $queryIdentificarFrecuenciaCalificacion="SELECT 
                                                                Frecuencia, 
                                                                Aplica_Desde 
                                                        FROM 
                                                                intervenciones 
                                                        WHERE 
                                                                Tipo_Intervencion = 'Calificacion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
                                                                        SELECT 
                                                                                CONCAT(
                                                                                        HV_Equipo, 
                                                                                        MAX(Version_Intervencion)
                                                                                ) 
                                                                        FROM 
                                                                                intervenciones
                                                                ) && HV_Equipo = '$codHV'";
                            
                            
                            $queryIdentificarFrecuenciaOtro="SELECT 
                                                                Tipo_Intervencion,
                                                                Frecuencia, 
                                                                Aplica_Desde 
                                                        FROM 
                                                                intervenciones 
                                                        WHERE 
                                                                Tipo_Intervencion <>'Mantenimiento preventivo' && Tipo_Intervencion <>'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
                                                                        SELECT 
                                                                                CONCAT(
                                                                                        HV_Equipo, 
                                                                                        MAX(Version_Intervencion)
                                                                                ) 
                                                                        FROM 
                                                                                intervenciones
                                                                ) && HV_Equipo = '$codHV'";
                            
                            $conexionFrecuenciaManto=mysql_query($queryIdentificarFrecuenciaManto, $con);
                            $conexionFrecuenciaVerificacion=mysql_query($queryIdentificarFrecuenciaVerificacion, $con);
                            $conexionFrecuenciaCalibracion=mysql_query($queryIdentificarFrecuenciaCalibracion, $con);
                            $conexionFrecuenciaCalificacion=mysql_query($queryIdentificarFrecuenciaCalificacion, $con);
                            $conexionFrecuenciaOtro=mysql_query($queryIdentificarFrecuenciaOtro, $con);
                            
                            while($arrayFrecuenciaManto=  mysql_fetch_assoc($conexionFrecuenciaManto)){
                                $FrecuenciaManto1=$arrayFrecuenciaManto['Frecuencia'];
                                $DesdeManto1=$arrayFrecuenciaManto['Aplica_Desde'];
                            }
                            
                            if(isset($FrecuenciaManto1)){
                                $FrecuenciaManto=$FrecuenciaManto1;
                                $DesdeManto=$DesdeManto1;
                            }else{
                                $FrecuenciaManto="";
                                $DesdeManto="";
                            }
                            
                            while($arrayFrecuenciaVerificacion=  mysql_fetch_assoc($conexionFrecuenciaVerificacion)){
                                $FrecuenciaVerificacion1=$arrayFrecuenciaVerificacion['Frecuencia'];
                                $DesdeVerificacion1=$arrayFrecuenciaVerificacion['Aplica_Desde'];
                            }
                            if(isset($FrecuenciaVerificacion1)){
                                $FrecuenciaVerificacion=$FrecuenciaVerificacion1;
                                $DesdeVerificacion=$DesdeVerificacion1;
                            }else{
                                $FrecuenciaVerificacion="";
                                $DesdeVerificacion="";
                            }
                            
                            while($arrayFrecuenciaCalibracion=  mysql_fetch_assoc($conexionFrecuenciaCalibracion)){
                                $FrecuenciaCalibracion1=$arrayFrecuenciaCalibracion['Frecuencia'];
                                $DesdeCalibracion1=$arrayFrecuenciaCalibracion['Aplica_Desde'];
                            }
                            
                            if(isset($FrecuenciaCalibracion1)){
                                $FrecuenciaCalibracion=$FrecuenciaCalibracion1;
                                $DesdeCalibracion=$DesdeCalibracion1;
                            }else{
                                $FrecuenciaCalibracion="";
                                $DesdeCalibracion="";
                                
                            }
                            
                            while($arrayFrecuenciaCalificacion=  mysql_fetch_assoc($conexionFrecuenciaCalificacion)){
                                $FrecuenciaCalificacion1=$arrayFrecuenciaCalificacion['Frecuencia'];
                                $DesdeCalificacion1=$arrayFrecuenciaCalificacion['Aplica_Desde'];
                            }
                            
                            if(isset($FrecuenciaCalificacion1)){
                                $FrecuenciaCalificacion=$FrecuenciaCalificacion1;
                                $DesdeCalificacion=$DesdeCalificacion1;
                            }else{
                                $FrecuenciaCalificacion="";
                                $DesdeCalificacion="";
                                
                            }
                            
                            while($arrayFrecuenciaOtro=  mysql_fetch_assoc($conexionFrecuenciaOtro)){
                                $TipoIntervenionOtro1=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                                $FrecuenciaOtro1=$arrayFrecuenciaOtro['Frecuencia'];
                                $DesdeOtro1=$arrayFrecuenciaOtro['Aplica_Desde'];
                            }
                            
                            if(isset($FrecuenciaOtro1)){
                                $TipoIntervenionOtro=$TipoIntervenionOtro1;
                                $FrecuenciaOtro=$FrecuenciaOtro1;
                                $DesdeOtro=$DesdeOtro1;
                            }else{
                                $TipoIntervenionOtro="Otro, cual?";
                                $FrecuenciaOtro="";
                                $DesdeOtro="";
                            }
                            
                           $conten.='<br/>';
                           
                           $conten.='<div id="panel4" class="panel panel-default">
                            <div class="panel-heading" role="tab" id="barraExpancion4">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        MANTENIMIENTOS E INTERVENCIONES METROLOGICAS
                                    </a>
                                </h4>
                            </div>';
                            $conten.='<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <table class="table table-condensed table-responsive" id="tablaIntervenciones" style="width: 90%;margin:auto;">
                                        <tr style="background: #ccc;text-align: center;">
                                         
                                            <td class="celdaTitulo" style="width:250px;">TIPO INTERVENCIÓN</td>
                                            <td class="celdaTitulo">FRECUENCIA (dias)</td>
                                            <td class="celdaTitulo">APLICA DESDE</td>
                                            
                                        </tr>
                                
                                        <tr>  
                                
                                <td>MANTENIMIENTO PREVENTIVO</td>';
                                if(isset($FrecuenciaManto)){echo $FrecuenciaManto;}else{$FrecuenciaManto="";}
                            
                                $conten.='<td style="text-align:center;">'.$FrecuenciaManto.'</td>
                                <td style="width:150px;">'.$DesdeManto.'</td>';
                                
                                    $conten.='</tr>
                                    
                                <tr>
                                <td>VERIFICACIÓN</td>';
                                if(isset($FrecuenciaVerificacion)){echo $FrecuenciaVerificacion;}else{$FrecuenciaVerificacion="";}
                                 $conten.='<td style="text-align:center;">'.$FrecuenciaVerificacion.'</td>
                                <td style="width:150px;">'.$DesdeVerificacion.'</td>';    
                                
                                    $conten.='</tr>
                                    <tr>   
                                <td>CALIBRACIÓN</td>';
                                if(isset($FrecuenciaCalibracion)){echo $FrecuenciaCalibracion;}else{$FrecuenciaCalibracion="";}
                                $conten.='<td style="text-align:center;">'.$FrecuenciaCalibracion.'</td>
                                <td style="width:150px;">'.$DesdeCalibracion.'</td>';
                                    $conten.='</tr>   
                                    <tr>
                                        <td>CALIFICACIÓN</td>';
                                        if(isset($FrecuenciaCalificacion)){echo $FrecuenciaCalificacion;}else{$FrecuenciaCalificacion="";}
                                    $conten.='<td style="text-align:center;">'.$FrecuenciaCalificacion.'</td>
                                    <td style="width:100px;">'.$DesdeCalificacion.'</td>';
                                    
                                    $conten.='</tr>
                                    <tr>
                                 <td>'.$TipoIntervenionOtro.'</td>';
                                
                                if(isset($FrecuenciaOtro)){echo $FrecuenciaOtro;}else{$FrecuenciaOtro="";}
                                
                                 $conten.='<td>'.$FrecuenciaOtro.'</td>
                                 <td style="width:150px;">'.$DesdeOtro.'</td> 
                                <td>';
                                if(isset($FrecuenciaOtro) && isset($nuevafechaOtro)){echo "<p style='display:inline;width:20px;'>".$nuevafechaOtro."</p>";}
                                $conten.='</td>
                            </tr>
                                    </table>
                                </div>';
                                 if(isset($_POST['desdebuscador'])){ }else{ '<div style="display:none">'; }
                         
                                
                                $conten.='</div>
                            </div>
                        </div>';
                       
                  // FIN DE LA TABLA DE FRECUENCIAS INTERVENCIONES              
                      
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';       
                                
                  // RIESGOS DETECTADOS DEL EQUIPO
                                
                    $conten.='<div id="panel2" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion8">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            CLASIFICACIÓN DEL RIESGO
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseEight" class="panel-collapse collapse in">
                                    <div class="panel-body">';            
                                    
                                    $querySeleccionCamposRiesgos="SELECT 
                                                                            Invasividad, 
                                                                            TipoRiesgo_Equipo 
                                                                    FROM 
                                                                            riesgos_equipos 
                                                                    WHERE 
                                                                            No_HV = '$codHV' && CONCAT(No_HV, Id) IN (
                                                                                    SELECT 
                                                                                            CONCAT(
                                                                                                    No_HV, 
                                                                                                    MAX(Id)
                                                                                            ) 
                                                                                    FROM 
                                                                                            riesgos_equipos 
                                                                                    GROUP BY 
                                                                                            No_HV
                                                                            )";
                                        
                                        
                                        $conexionSeleccionCamposRiesgos=mysql_query($querySeleccionCamposRiesgos, $con);
                                        
                                        while($arrayCamposRiesgos=  mysql_fetch_assoc($conexionSeleccionCamposRiesgos)){
                                            $Invasividad=$arrayCamposRiesgos['Invasividad'];
                                            $TipoRiesgo_Equipo=$arrayCamposRiesgos['TipoRiesgo_Equipo'];
                                            
                                        }
                            
                                        $conten.='<div class="row">  
                                        <div class="form-group col-md-4 col-lg-4">
                                            
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">GRADO DE INVASIVIDAD</label>
                                            <div>'.$Invasividad.'</div>
                                        </div>

                                            
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">CLASIFICACIÓN DEL RIESGO DEL EQUIPO</label>
                                            <div>'.$TipoRiesgo_Equipo.'</div>
                                        </div>';

                                            $querySeleccionarRiesgosGuardados="SELECT 
                                                                        Riesgo, 
                                                                        Icono
                                                                FROM 
                                                                        riesgos_equipos 
                                                                WHERE 
                                                                        No_HV = '$codHV'";
                                
                                
                                $conexionSeleccionarRiesgosGuardados=mysql_query($querySeleccionarRiesgosGuardados, $con);
                                
                                while($arrayRiesgosGuardados=  mysql_fetch_assoc($conexionSeleccionarRiesgosGuardados)){
                                    
                                        
                                    $conten.='<div style="float: left;margin: 3px;width: 100px;">
                                    <div>
                                          <img src='.$arrayRiesgosGuardados['Icono'].' alt="" style="width: 100px;">
                                          <label style="text-align: center;">'.$arrayRiesgosGuardados['Riesgo'].'</label>
                                      </div>
                                </div>';    
                                  
                                }
                                
                                            
                                        

                                   $conten.='</div>';
                                        
                                        
                                        
                            $conten.='</div>    
                                    </div>    
                                    </div>';    
                                
                                
                                
                  // FIN DE RIESGOS DETECTADOS              
                                
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                        $conten.='<br/>';    
                     
                // HISTORIAL DE INTERVENCIONES        
                        
   $queryHistorialIntervenciones="SELECT No_Intervencion,Tipo_Intervencion,Fecha_Intervencion,Descripcion, Nombre_Proveedor, Nombre_Tecnico,Nombre_Recibe_Trabajo,Estado_Equipo FROM reportes_intervencion WHERE HV_Equipo='$codHV'"; 
   $conexionqueryHistorial=  mysql_query($queryHistorialIntervenciones, $con);               
  
   $conten.='<div id="panel5" class="panel panel-default" style="margin-top:-14px;">
                            <div class="panel-heading" role="tab" id="barraExpancion5">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        HISTORIAL DE INTERVENCIONES
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">';
   
   
   
   
   $conten.='<table id="tablaHistorial" class="table table-bordered" style="margin_auto;">';
   $conten.='<thead>';
   $conten.='<tr style="text-align: center;background: #F7F3B1;"><td style="font-size:10px;width:18px;">COD INTERVENCION</td><td style="width:18px;font-size:10px;">FECHA INTERVENCION</td><td style="width:18px;font-size:10px;">TIPO INTERVENCIÓN</td><td style="width:130px;font-size:10px;">DESCRIPCIÓN</td><td style="width:18px;font-size:10px;">PROVEEDOR</td><td style="width:18px;font-size:10px;">TÉCNICO</td><td style="width:18px;font-size:10px;">RECIBIDO POR</td><td style="width:18px;font-size:10px;">ESTADO</td></tr>';
   $conten.='</thead>';
   $conten.='<tbody>';
   while($arrayHistorialIntervencion= mysql_fetch_assoc($conexionqueryHistorial)){
       
                $conten.='<tr>';
                $conten.='<td>'.$arrayHistorialIntervencion['No_Intervencion'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Fecha_Intervencion'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Tipo_Intervencion'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Descripcion'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Nombre_Proveedor'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Nombre_Tecnico'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Nombre_Recibe_Trabajo'].'</td>';
                $conten.='<td>'.$arrayHistorialIntervencion['Estado_Equipo'].'</td>';
                $conten.='</tr>';
        }
   $conten.='</tbody>';
   $conten.='</table>';
   
                                $conten.='</div>
                            </div>
                        </div>';                   
                        
    $conten.='<br/>';                            
                                
    // HISTORIAL PUESTA EN MARCHA
   
   $queryHistorialUbicacion="SELECT Sede,Area,SubArea, Fecha_Marcha FROM puesta_marcha WHERE No_HV='$codHV'"; 
   $conexionqueryHistorial=  mysql_query($queryHistorialUbicacion, $con);
                                
           $conten.='<div id="panel6" class="panel panel-default" style="margin-top:-14px;">
                            <div class="panel-heading" role="tab" id="barraExpancion6">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        HISTORIAL DE UBICACIÓN Y PUESTA EN MARCHA
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-body">';                     
   
           
  $conten.='<table class="table table-bordered" id="tablaHistorialUbicacion" style="margin: auto;">';
  $conten.='<thead>';
  $conten.='<tr style="text-align: center;background: #F7F3B1;">';
  $conten.='<td>CIUDAD</td><td>SEDE</td><td>AREA</td><td>FECHA PUESTA MARCHA</td>';
  $conten.='</tr>';
  $conten.='</thead>';
  $conten.='<tbody>';
        while($arrayHistorialubicacion=  mysql_fetch_array($conexionqueryHistorial)){
                $conten.='<tr>';
                $conten.='<td>'.$arrayHistorialubicacion['Sede'].'</td>';
                $conten.='<td>'.$arrayHistorialubicacion['Area'].'</td>';
                $conten.='<td>'.$arrayHistorialubicacion['SubArea'].'</td>';
                $conten.='<td>'.$arrayHistorialubicacion['Fecha_Marcha'].'</td>';
                
                $conten.='</tr>';
        }
        $conten.='</tbody>';
  $conten.='</table>';
           
           
           
                                
           
           $conten.='</div>
                            </div>
                        </div>';
                                
    $conten.='</body>
</html>';

// reference the Dompdf namespace

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($conten);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');
//$dompdf->setPaper('A4', 'landscape');


// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>

