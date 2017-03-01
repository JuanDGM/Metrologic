<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar Equipo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosBuscador.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script src="crearhvajax.js"></script>
        <script src="validacionHv.js"></script>
        <!--<script src="BuscadorLocalizacion.js"></script>-->
        <!--<script src="buscarHv.js"></script>-->
        <script>
            $(document).ready(function(){
                $("#barraExpancion").click(function(){
                    $("#formBuscador").toggle();
                });
            });
                
            //document.getElementById("btnIrHV").addEventListener("click",enviar,false);
            function enviar(NumeroFormulario){
                var Formulario="#formularioedicion"+NumeroFormulario;
                $(Formulario).submit();
            }
        
        </script>
    </head>
    <!--<body onload="buscarHojavida()">-->
    <body id="Cuerpo">
            <?php
        include_once('./conexion.php');
        $con=  conectar();
        ?>
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
       
        <div id="contorno">
            <div class="page-header" id="encabezadoBuscador" style="border-bottom: 1px solid #a3a3a3;">
                <div style="float: left;">
                <h2 id="titulo">BUSCADOR DE EQUIPOS</h2>
                </div>
                <div style="float: right;margin: 30px;">
                <a href='Menu.php' style='margin: 30px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
            </div>
            </div>
            <?php
//echo "<a href='Menu.php' style='margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>";
         echo "<br/>";   
        // Condicionales inputs entrada
        if(isset($_POST['enviar'])){
           $Ciudad=$_POST['Ciudad'];
           $Sede=$_POST['Sede'];
           $Area=$_POST['Area'];
           $tp=$_POST['tipoEquipo'];
           $CodHV=$_POST['Cod_Equipo'];
           if($Ciudad==""){
               $ConsultaCiudad=1;
           }else{
               $ConsultaCiudad="p.Sede='$Ciudad'";
           } 
           if($Sede==""){
               $ConsultaSede=1;
           }else{
               $ConsultaSede="p.Area='$Sede'";
           } 
           if($Area==""){
               $consultaArea=1;
           }else{
               $consultaArea="p.SubArea='$Area'";
            } 
           if($tp==""){
               $consultatp=1;
           }else{
               $consultatp="h.Tipo_Equipo='$tp'";
           } 
           if($CodHV==""){
               $consultaCodHV=1;
           }else{
               $consultaCodHV="h.No_HV='$CodHV'";
           } 
            
           $condicionquery="$ConsultaCiudad && $ConsultaSede && $consultaArea && $consultatp && $consultaCodHV";
            
        }else{
           $condicionquery=1; 
        }
        
//        if(isset($_POST['enviar']) && $_POST['tipoEquipo']!=""){
//            
//            echo $tp=$_POST['tipoEquipo'];
//            echo $condicionquery="h.Tipo_Equipo='$tp'";
//            
//            
//        }else if(isset($_POST['enviar']) && $_POST['tipoEquipo']==""){
//            
//            echo $condicionquery=1;
//        }else{
//            
//            echo $condicionquery=1;
//        }
        
// cuando no se selecciona ningun filtro en la busqueda
    
    $queryBuscar="SELECT
	IF(p.Area IS null, 'NO TIENE UBICACIÓN',p.Area) AS Area,
	h.Id,
        m.Ruta,
	h.No_HV,
	h.Tipo_Equipo, 
	h.Nombre_Equipo,
        p.Fecha_Marcha,
        p.Fecha_Descarte,
        p.Sede,
        p.Area,
        p.SubArea
FROM
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
        LEFT JOIN imagenes_equipos as m ON h.No_HV = m.No_HV
WHERE
      $condicionquery

      &&  IF(CONCAT(h.No_HV, p.Version) IS null,1,

    CONCAT(h.No_HV, p.Version) IN (
			SELECT
    			CONCAT(
				h.No_HV, 
				MAX(p.Version)
			) 
		FROM 
			hoja_vida as h 
			LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
		WHERE 
			1 
		GROUP BY 
			h.No_HV
	)) && p.Fecha_Descarte='0000-00-00'
GROUP BY 
	p.Area, 
	h.Tipo_Equipo, 
	h.No_HV";

    $conexionBuscar=mysql_query($queryBuscar, $con);
   
    if(isset($conexionBuscar)){
        ?> 
    
            
<script type="text/javascript">
$(document).ready(function(){
    $("#tableBusqueda").DataTable({
        
        "language":{
            "search": "Búsqueda Rápida",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            }
        
    });
});



</script>

<!--barraExpancion-->
                
<div class="panel panel-default" id="panel1">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title" style="text-align: center;background: white;">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="font-weight: bold;font-size: 21px;" aria-expanded="true" aria-controls="collapseOne">
                OPCIONES DE BÚSQUEDA DE EQUIPOS <span class="glyphicon glyphicon-triangle-bottom"></span><span class="glyphicon glyphicon-triangle-top"></span>
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body" id="panelBody">    
<form id="formBuscador" method="POST" action="Buscar_hojaVida.php">
    <div class="form-group" id="Ciudad">
                <?php
                if(isset($Ciudad)){
                  $c=$Ciudad;  
                }else{
                  $c="";  
                }
                
                $querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                
                ?>
       
            
        <div class="form-group" id="campoCiudad">
                <label class="lblFiltros">CIUDAD</label>
                <select class="form-control" name="Ciudad" id="txtCiudad" value="<?php echo $c; ?>" placeholder="<?php echo $c; ?>">
                    <option></option> 
                   <?php
                   
                   while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                   
                    echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                }
                   ?>
                   </select>
        
        </div>
    </div>
    
    <?php echo $c; ?>
    
<div class="form-group" id="campoSede">
                 <?php
                if(isset($Sede)){
                  $s=$Sede;  
                }else{
                  $s="Todos";  
                }
                
                $querySeleccionSede="SELECT Area FROM ubicaciones WHERE 1 GROUP BY Area";
                 
                
                
                $conexionSeleccionSede=mysql_query($querySeleccionSede, $con);
                
                ?>   
                
                <label class="lblFiltros">SEDE</label>
                <!--<input type="text" name="Sede" id="txtSede" class="form-control" value="<?php //echo $s; ?>" placeholder="<?php //echo $s; ?>">-->
                <select class="form-control" name="Sede" id="txtSede" value="<?php echo $s; ?>" placeholder="<?php echo $s; ?>">
                    <option></option>
                   <?php
                   while($arraySeleccionSede=mysql_fetch_array($conexionSeleccionSede)){
                   
                    echo "<option>".$arraySeleccionSede['Area']."</option>";
                }
                   ?>
                   </select>
        </div>
    
    <div class="form-group" id="CampoArea">
         <?php
                if(isset($Area)){
                  $a=$Area;  
                }else{
                  $a="";  
                }
                
                $querySeleccionArea="SELECT Sub_Area FROM ubicaciones GROUP BY Sub_Area";
                $conexionSeleccionArea=mysql_query($querySeleccionArea, $con);
                ?>        
        
        <label class="lblFiltros">AREA</label>
                <!--<input type="text" name="Area" id="txtArea" class="form-control" value="<?php //echo $a; ?>" placeholder="<?php //echo $a; ?>">-->
                <select class="form-control" name="Area" id="txtArea" value="<?php echo $a; ?>" placeholder="<?php echo $a; ?>">
                    <option></option> 
                   <?php
                   while($arraySeleccionArea=mysql_fetch_array($conexionSeleccionArea)){
                    echo "<option>".$arraySeleccionArea['Sub_Area']."</option>";
                }
                   ?>
                   </select>
    </div>
    
    <div class="form-group" id="campoTipo_equipo">
        <?php
                if(isset($tp)){
                  $t=$tp;  
                }else{
                  $t="";  
                }
                ?>        
        
        <label class="lblFiltros">TIPO EQUIPO</label>
                <input type="text" id="txtTipoEquipo" name="tipoEquipo" class="form-control" value="<?php echo $t; ?>" placeholder="<?php echo $t; ?>">
            </div>
    
    <div class="form-group" id="campoCod_HV">
        <?php
                if(isset($CodHV)){
                  $ch=$CodHV;  
                }else{
                  $ch="";  
                }
                ?>        
        
        <label class="lblFiltros">No EQUIPO</label>
                <input type="text" id="txtCodEquipo" name="Cod_Equipo" class="form-control" value="<?php echo $ch; ?>" placeholder="<?php echo $ch; ?>">
            </div>
    <br/>
    <div id="campobtn">
    
    <button type="submit" name="enviar" class="btn btn-primary">Generar</button>
    </div>
    </form>
        </div>
        </div>
</div>
<br/>
   
<div id="DisplayOrdenador">
<!--<div class="table-responsive" style="width: 90%;margin: auto">-->
<div class="table-responsive" style="width: 90%;margin: auto">
    <table id="tableBusqueda" class="table table-bordered table-hover">
        <thead style="background: white;">
        <tr style="text-align: center;font-weight: bold;font-family: arial,sans-serif;vertical-align: middle;">
            <td id="tdAreaOcultarMovil" style="vertical-align: middle;font-size: 18px;">AREA</td>
            <td style="vertical-align: middle;font-size: 18px;width: 100px;">IMAGEN EQUIPO</td>
            <td style="vertical-align: middle;font-size: 18px;">No HV</td>
            <td style="vertical-align: middle;font-size: 18px;">NOMBRE DEL EQUIPO</td>
            <td id="tdTipoEquipoOcultarMovil" style="vertical-align: middle;font-size: 18px;">TIPO DE EQUIPO</td>
            <td style="vertical-align: middle;font-size: 18px;">NOTIFICACIONES</td>
            <td style="vertical-align: middle;font-size: 18px;width: 110px;">FICHA TÉCNICA</td>
        </tr>
        </thead>
        <tbody style="background: white;">
      <?php
  
      $i=0;
      while($arrayBuscar=mysql_fetch_array($conexionBuscar)){
       $i++;
       echo "<tr>"; 
       echo "<td id='tdAreaOcultarMovil' style='font-family:arial;font-size:20px;'>".$arrayBuscar['Area']."</td>";
       echo "<td align='center' style='width:100px;font-size:20px;'><img src='".$arrayBuscar['Ruta']."' style='width:50px;'></td>";
       echo "<td style='font-size:20px;'>".$arrayBuscar['No_HV']."</td>";
       echo "<td style='font-size:20px;'>".$arrayBuscar['Nombre_Equipo']."</td>";
       echo "<td id='tdTipoEquipoOcultarMovil' style='font-size:20px;'>".$arrayBuscar['Tipo_Equipo']."</td>";
       
       $queryMaxVersionUbicacion="SELECT MAX(Version) FROM puesta_marcha WHERE No_HV='".$arrayBuscar['No_HV']."'";
                        $ConexionVersionUbicacion=mysql_query($queryMaxVersionUbicacion, $con);
                        
                        while($arrayMaxVersionUbicacion=  mysql_fetch_array($ConexionVersionUbicacion)){
                            $MaxVersionUbicacion=$arrayMaxVersionUbicacion['MAX(Version)'];
                        }
                        
                        $queryequipobuscadoubicacion="SELECT Sede,Area,SubArea, Fecha_Marcha FROM puesta_marcha WHERE No_HV='".$arrayBuscar['No_HV']."' && Version='$MaxVersionUbicacion'";  
                        $conexionequipobuscadoUbicacion= mysql_query($queryequipobuscadoubicacion,$con);
                        
                        while($arrayequipobuscado=  mysql_fetch_array($conexionequipobuscadoUbicacion)){
                            $Sede=$arrayequipobuscado['Sede'];
                            $Area=$arrayequipobuscado['Area'];
                            $SubArea=$arrayequipobuscado['SubArea'];
                            $Fecha_Marcha=$arrayequipobuscado['Fecha_Marcha'];
                        }
                        
                          
       echo "</td>";
        
       echo "<td>";
       //Celda para alerta de intervenciones
       
       
       $maxVersionFrecuenciaMatenimiento="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $conexionMaximaVersionFrecuenciaManto=mysql_query($maxVersionFrecuenciaMatenimiento, $con); 
                        while($arrayMaxVersionIntervencion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaManto)){
                            $MaxVersionIntervencion=$arrayMaxVersionIntervencion['MAX(Version_Intervencion)'];
                        }
       $mantoPreventivo=0;
       $queryequipobuscadoPreventivo = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo' && Version_Intervencion='$MaxVersionIntervencion'";
       $conexionFrecuenciaPreventivo=mysql_query($queryequipobuscadoPreventivo, $con);
       while($arrayFrecuenciaPreventivo=  mysql_fetch_array($conexionFrecuenciaPreventivo)){
           $mantoPreventivo=$arrayFrecuenciaPreventivo['Frecuencia'];
       }
       
       $maxVersionFrecuenciaVerificacion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Verificacion'";
                        $conexionMaximaVersionFrecuenciaVerificacion=mysql_query($maxVersionFrecuenciaVerificacion, $con); 
                        while($arrayMaxVersionVerificacion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaVerificacion)){
                            $MaxVersionVerificacion=$arrayMaxVersionVerificacion['MAX(Version_Intervencion)'];
                        }
       $Verificacion=0;
       $queryequipobuscadoVerificacion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Verificacion' && Version_Intervencion='$MaxVersionVerificacion'";
       $conexionFrecuenciaVerificacion=mysql_query($queryequipobuscadoVerificacion, $con);
       while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
           $Verificacion=$arrayFrecuenciaVerificacion['Frecuencia'];
       }
       
       $maxVersionFrecuenciaCalibracion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calibracion'";
                        $conexionMaximaVersionFrecuenciaCalibracion=mysql_query($maxVersionFrecuenciaCalibracion, $con); 
                        while($arrayMaxVersionCalibracion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaCalibracion)){
                            $MaxVersionCalibracion=$arrayMaxVersionCalibracion['MAX(Version_Intervencion)'];
                        }
       $Calibracion=0;
       $queryequipobuscadoCalibracion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calibracion' && Version_Intervencion='$MaxVersionCalibracion'";
       $conexionFrecuenciaCalibracion=mysql_query($queryequipobuscadoCalibracion, $con);
       while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
           $Calibracion=$arrayFrecuenciaCalibracion['Frecuencia'];
       }
       
       $maxVersionFrecuenciaCalificacion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion'";
                        $conexionMaximaVersionFrecuenciaCalificacion=mysql_query($maxVersionFrecuenciaCalificacion, $con); 
                        while($arrayMaxVersionCalificacion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaCalificacion)){
                            $MaxVersionCalificacion=$arrayMaxVersionCalificacion['MAX(Version_Intervencion)'];
                        }
       
        $Calificacion=0;
       $queryequipobuscadoCalificacion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion' && Version_Intervencion='$MaxVersionCalificacion'";
       $conexionFrecuenciaCalificacion=mysql_query($queryequipobuscadoCalificacion, $con);
       while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
           $Calificacion=$arrayFrecuenciaCalificacion['Frecuencia'];
       }
       
       
       $queryNombreIntervencionOtro="SELECT 
	Tipo_Intervencion
FROM 
	intervenciones 
WHERE 
	HV_Equipo = '".$arrayBuscar['No_HV']."' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion' && CONCAT(HV_Equipo, Version_Intervencion) IN (
		SELECT 
			CONCAT(
				HV_Equipo, 
				MAX(Version_Intervencion)
			) 
		FROM 
			intervenciones 
		WHERE 
			HV_Equipo = '".$arrayBuscar['No_HV']."')";
	
       
       $conexionNombreIntervencionOtro=mysql_query($queryNombreIntervencionOtro, $con);
       
       while($arrayNombreIntervencionOtro=mysql_fetch_array($conexionNombreIntervencionOtro)){
           $NombreTipoIntevencionOtro=$arrayNombreIntervencionOtro['Tipo_Intervencion'];
       }
       
       $maxVersionFrecuenciaOtro="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion'";
                        $conexionMaximaVersionFrecuenciaOtro=mysql_query($maxVersionFrecuenciaOtro, $con); 
                        while($arrayMaxVersionOtro=  mysql_fetch_array($conexionMaximaVersionFrecuenciaOtro)){
                            $MaxVersionOtro=$arrayMaxVersionOtro['MAX(Version_Intervencion)'];
                        }
       
       $Otro=0;
       $queryequipobuscadoOtro = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion' && Version_Intervencion='$MaxVersionOtro'";
       $conexionFrecuenciaOtro=mysql_query($queryequipobuscadoOtro, $con);
       while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
           $Otro=$arrayFrecuenciaOtro['Frecuencia'];
       }                
       
       
                            if(isset($mantoPreventivo) && $mantoPreventivo>0){
                            $queryUltimaFechaIntervencionMantoPreventivo="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo'";
                            $conexionUltimaFechaIntervencionManto=mysql_query($queryUltimaFechaIntervencionMantoPreventivo, $con);
                            while($arrayUltimaFechaIntervencionManto=  mysql_fetch_array($conexionUltimaFechaIntervencionManto)){
                                $fechaUltimoManto=$arrayUltimaFechaIntervencionManto['MAX(Fecha_Intervencion)'];
                            }
                            }
                            
                            
                            if(isset($Verificacion) && $Verificacion>0){
                            $queryUltimaFechaIntervencionVerificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Verificacion'";
                            $conexionUltimaFechaIntervencionVerificacion=mysql_query($queryUltimaFechaIntervencionVerificacion, $con);
                            while($arrayUltimaFechaIntervencionVerificacion=  mysql_fetch_array($conexionUltimaFechaIntervencionVerificacion)){
                                $FechaUltimoVerificacion=$arrayUltimaFechaIntervencionVerificacion['MAX(Fecha_Intervencion)'];
                            }
                            }
                            
                            
                            if(isset($Calibracion) && $Calibracion>0){
                            $queryUltimaFechaIntervencionCalibracion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calibracion'";
                            $conexionUltimaFechaIntervencionCalibracion=mysql_query($queryUltimaFechaIntervencionCalibracion, $con);
                            while($arrayUltimaFechaIntervencionCalibracion=  mysql_fetch_array($conexionUltimaFechaIntervencionCalibracion)){
                                $FechaUltimoCalibracion=$arrayUltimaFechaIntervencionCalibracion['MAX(Fecha_Intervencion)'];
                            }
                            }
                            
                            
                            
                            if(isset($Calificacion) && $Calificacion>0){
                            $queryUltimaFechaIntervencionCalificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion'";
                            $conexionUltimaFechaIntervencionCalificacion=mysql_query($queryUltimaFechaIntervencionCalificacion, $con);
                            while($arrayUltimaFechaIntervencionCalificacion=  mysql_fetch_array($conexionUltimaFechaIntervencionCalificacion)){
                                $FechaUltimoCalificacion=$arrayUltimaFechaIntervencionCalificacion['MAX(Fecha_Intervencion)'];
                            }
                            }
                            
                            
                            
                            $queryUltimaFechaIntervencionOtro="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion'";
                            $conexionUltimaFechaIntervencionOtro=mysql_query($queryUltimaFechaIntervencionOtro, $con);
                            while($arrayUltimaFechaIntervencionOtro=  mysql_fetch_array($conexionUltimaFechaIntervencionOtro)){
                                $FechaUltimoOtro=$arrayUltimaFechaIntervencionOtro['MAX(Fecha_Intervencion)'];
                            }
                            
                            
                            
                            
                            
                            
       $FechaMarcha=$arrayBuscar['Fecha_Marcha'];
                            
        $time=  time();
        
        // ALERTA QUE EL EQUIPO SE ENCUENTRA FUEREA DE USO
        
        if(isset($FechaMarcha) && $FechaMarcha!="" && $FechaMarcha!="0000-00-00" ){
            
            
        }else{
            echo "<p style='color:red;font-size:17px;'>Equipo fuera de uso</p>";
            
        }
        
        
       // MANTENIMIENTO PREVENTIVO ALERTA BUSCADOR
                        
                            $fecharegistro=date("Y-m-d", $time);
                            
                        if(isset($fechaUltimoManto) && isset($mantoPreventivo)){    
                            $Sumar=$mantoPreventivo." day";
                            $nuevafechaManto1 = date('Y-m-d', strtotime("$fechaUltimoManto + $Sumar"));
                        }        
                        if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && isset($nuevafechaManto1) && $nuevafechaManto1>=$Fecha_Marcha){
                               if(isset($fechaUltimoManto) && $fechaUltimoManto!="" && $fechaUltimoManto!="0000-00-00"){
                                    $Sumar=$mantoPreventivo." day";
                                    $nuevafechaManto1 = date('Y-m-d', strtotime("$fechaUltimoManto + $Sumar"));    
                               }else{
                                   //$Sumar=$mantoPreventivo." day";
                                    //$nuevafechaManto1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                    $nuevafechaManto1 = $Fecha_Marcha;
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaManto1) - strtotime($fecharegistro))/86400;
                                    $diasManto=abs($diasProximaIntervencion);
                                    $diasManto=floor($diasProximaIntervencion);
                                    if($diasManto<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Mantenimiento Preventivo desde ".$nuevafechaManto1."</p>";
                                }else if(isset($nuevafechaManto1) && $nuevafechaManto1!="0000-00-00" && $diasManto<=30){
                                    echo $respuestaManto="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Mantenimiento preventivo en: ".$diasManto." dias</p>";
                                }else {
                                    $respuestaMantoGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }else if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $fechaUltimoManto<=$Fecha_Marcha){
                                 $nuevafechaManto1 = $Fecha_Marcha;
                                 $diasProximaIntervencion=(strtotime($nuevafechaManto1) - strtotime($fecharegistro))/86400;
                                    $diasManto=abs($diasProximaIntervencion);
                                    $diasManto=floor($diasProximaIntervencion);
                                    if($diasManto<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Mantenimiento Preventivo desde ".$nuevafechaManto1."</p>";
                                }else if(isset($nuevafechaManto1) && $nuevafechaManto1!="0000-00-00" && $diasManto<=30){
                                    echo $respuestaManto="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Mantenimiento preventivo en: ".$diasManto." dias</p>";
                                }else {
                                    $respuestaMantoGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                                 
                             }
                             
       // VERIFICACION: ALERTA BUSCADOR
                             if(isset($FechaUltimoVerificacion) && isset($Verificacion)){
                            $Sumar=$Verificacion." day";
                            $nuevafechaVerificacion = date('Y-m-d', strtotime("$FechaUltimoVerificacion + $Sumar"));
                             }
                           if(isset($Verificacion) && $Verificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && isset($nuevafechaVerificacion) && $nuevafechaVerificacion>=$Fecha_Marcha){
                               if(isset($FechaUltimoVerificacion) && $FechaUltimoVerificacion!="" && $FechaUltimoVerificacion!="0000-00-00"){
                                    $Sumar=$Verificacion." day";
                                    $nuevafechaVerificacion = date('Y-m-d', strtotime("$FechaUltimoVerificacion + $Sumar"));    
                               }else{
                                   
                                    $nuevafechaVerificacion =$Fecha_Marcha;
                                }
                                    $diasProximaVerificacion=(strtotime($nuevafechaVerificacion) - strtotime($fecharegistro))/86400;
                                    $diasVerificacion=abs($diasProximaVerificacion);
                                    $diasVerificacion=floor($diasProximaVerificacion);
                                    if($diasVerificacion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Verificación desde ".$nuevafechaVerificacion."</p>";
                                }else if(isset($nuevafechaVerificacion) && $nuevafechaVerificacion!="0000-00-00" && $diasVerificacion<=30){
                                    echo $respuestaVerificacion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO:<span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Verificación en: ".$diasVerificacion." dias</p>";
                                }else {
                                    $respuestaVerificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }else if(isset($Verificacion) && $Verificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $FechaUltimoVerificacion<=$Fecha_Marcha){
                                 $nuevafechaVerificacion =$Fecha_Marcha;
                                 $diasProximaVerificacion=(strtotime($nuevafechaVerificacion) - strtotime($fecharegistro))/86400;
                                    $diasVerificacion=abs($diasProximaVerificacion);
                                    $diasVerificacion=floor($diasProximaVerificacion);
                                    if($diasVerificacion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Verificación desde ".$nuevafechaVerificacion."</p>";
                                }else if(isset($nuevafechaVerificacion) && $nuevafechaVerificacion!="0000-00-00" && $diasVerificacion<=30){
                                    echo $respuestaVerificacion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO:<span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Verificación en: ".$diasVerificacion." dias</p>";
                                }else {
                                    $respuestaVerificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                                 
                             }
                            
                             
    // CALIBRACION: ALERTA BUSCADOR
                                    if(isset($FechaUltimoCalibracion) && isset($Calibracion)){
                                    $Sumar=$Calibracion." day";
                                    $nuevafechaCalibracion = date('Y-m-d', strtotime("$FechaUltimoCalibracion + $Sumar"));
                                    }
                             if(isset($Calibracion) && $Calibracion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && isset($nuevafechaCalibracion) && $nuevafechaCalibracion>=$Fecha_Marcha){
                               if(isset($FechaUltimoCalibracion) && $FechaUltimoCalibracion!="" && $FechaUltimoCalibracion!="0000-00-00"){
                                    $Sumar=$Calibracion." day";
                                    $nuevafechaCalibracion = date('Y-m-d', strtotime("$FechaUltimoCalibracion + $Sumar"));    
                               }else{
                                   
                                    $nuevafechaCalibracion = $Fecha_Marcha;
                                }
                                    $diasProximaCalibracion=(strtotime($nuevafechaCalibracion) - strtotime($fecharegistro))/86400;
                                    $diasCalibracion=abs($diasProximaCalibracion);
                                    $diasCalibracion=floor($diasProximaCalibracion);
                                    if($diasCalibracion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Calibracion desde ".$nuevafechaCalibracion."</p>";
                                }else if(isset($nuevafechaCalibracion) && $nuevafechaCalibracion!="0000-00-00" && $diasCalibracion<=30){
                                    echo $respuestaCalibracion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO:<span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Calibración en: ".$diasCalibracion." dias</p>";
                                }else {
                                    $respuestaCalibracionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }else if(isset($Calibracion) && $Calibracion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $FechaUltimoCalibracion<=$Fecha_Marcha){
                                 $nuevafechaCalibracion = $Fecha_Marcha;
                                 $diasProximaCalibracion=(strtotime($nuevafechaCalibracion) - strtotime($fecharegistro))/86400;
                                    $diasCalibracion=abs($diasProximaCalibracion);
                                    $diasCalibracion=floor($diasProximaCalibracion);
                                    if($diasCalibracion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Calibracion desde ".$nuevafechaCalibracion."</p>";
                                }else if(isset($nuevafechaCalibracion) && $nuevafechaCalibracion!="0000-00-00" && $diasCalibracion<=30){
                                    echo $respuestaCalibracion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO:<span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Calibración en: ".$diasCalibracion." dias</p>";
                                }else {
                                    $respuestaCalibracionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                                 
                             }
                             
                             
    // CALIFICACION: ALERTA BUSCADOR
                             
                             if(isset($FechaUltimoCalificacion) && isset($Calificacion)){
                                    $Sumar=$Calificacion." day";
                                    $nuevafechaCalificacion = date('Y-m-d', strtotime("$FechaUltimoCalificacion + $Sumar"));
                             }
                           if(isset($Calificacion) && $Calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && isset($nuevafechaCalificacion) && $nuevafechaCalificacion>=$Fecha_Marcha){
                               if(isset($FechaUltimoCalificacion) && $FechaUltimoCalificacion!="" && $FechaUltimoCalificacion!="0000-00-00"){
                                    $Sumar=$Calificacion." day";
                                    $nuevafechaCalificacion = date('Y-m-d', strtotime("$FechaUltimoCalificacion + $Sumar"));    
                               }else{
                                   
                                    $nuevafechaCalificacion =$Fecha_Marcha;
                                }
                                    $diasProximaCalificacion=(strtotime($nuevafechaCalificacion) - strtotime($fecharegistro))/86400;
                                    $diasCalificacion=abs($diasProximaCalificacion);
                                    $diasCalificacion=floor($diasProximaCalificacion);
                                    if($diasCalificacion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Calificación desde ".$nuevafechaCalificacion."</p>";
                                }else if(isset($nuevafechaCalificacion) && $nuevafechaCalificacion!="0000-00-00" && $diasCalificacion<=30){
                                    echo $respuestaCalificacion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Calificación en: ".$diasCalificacion." dias</p>";
                                }else {
                                    $respuestaCalificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }else if(isset($Calificacion) && $Calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $FechaUltimoCalificacion<=$Fecha_Marcha){
                                 $nuevafechaCalificacion =$Fecha_Marcha;
                                 $diasProximaCalificacion=(strtotime($nuevafechaCalificacion) - strtotime($fecharegistro))/86400;
                                    $diasCalificacion=abs($diasProximaCalificacion);
                                    $diasCalificacion=floor($diasProximaCalificacion);
                                    if($diasCalificacion<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: Calificación desde ".$nuevafechaCalificacion."</p>";
                                }else if(isset($nuevafechaCalificacion) && $nuevafechaCalificacion!="0000-00-00" && $diasCalificacion<=30){
                                    echo $respuestaCalificacion="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> Calificación en: ".$diasCalificacion." dias</p>";
                                }else {
                                    $respuestaCalificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                                 
                             } 

            // OTRO: ALERTA BUSCADOR
        
                             
                             if(isset($FechaUltimoOtro) && isset($Otro)){
                                    $Sumar=$Otro." day";
                                    $nuevafechaOtro = date('Y-m-d', strtotime("$FechaUltimoOtro + $Sumar"));
                             }
                           if(isset($Otro) && $Otro>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && isset($nuevafechaOtro) && $nuevafechaOtro>=$Fecha_Marcha){
                               if(isset($FechaUltimoOtro) && $FechaUltimoOtro!="" && $FechaUltimoOtro!="0000-00-00"){
                                    $Sumar=$Otro." day";
                                    $nuevafechaOtro = date('Y-m-d', strtotime("$FechaUltimoOtro + $Sumar"));    
                               }else{
                                   
                                    $nuevafechaOtro =$Fecha_Marcha;
                                }
                                    $diasProximaOtro=(strtotime($nuevafechaOtro) - strtotime($fecharegistro))/86400;
                                    $diasOtro=abs($diasProximaOtro);
                                    $diasOtro=floor($diasProximaOtro);
                                    if($diasOtro<0){
                                       
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: ".$NombreTipoIntevencionOtro." desde ".$nuevafechaOtro."</p>";
                                }else if(isset($nuevafechaOtro) && $nuevafechaOtro!="0000-00-00" && $diasOtro<=30){
                                    echo $respuestaOtro="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> ".$NombreTipoIntevencionOtro." en: ".$diasOtro." dias</p>";
                                }else {
                                    $respuestaOtroGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }else if(isset($Otro) && $Otro>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $FechaUltimoOtro<=$Fecha_Marcha){
                                 $nuevafechaOtro =$Fecha_Marcha;
                                 $diasProximaOtro=(strtotime($nuevafechaOtro) - strtotime($fecharegistro))/86400;
                                    $diasOtro=abs($diasProximaOtro);
                                    $diasOtro=floor($diasProximaOtro);
                                    if($diasOtro<0){
                                    echo "<p style='padding:0px;margin:0px;font-size:17px;'>VENCIDO <span class='glyphicon glyphicon-remove' style='color:red'></span>: ".$NombreTipoIntevencionOtro." desde ".$nuevafechaOtro."</p>";
                                }else if(isset($nuevafechaOtro) && $nuevafechaOtro!="0000-00-00" && $diasOtro<=30){
                                    echo $respuestaOtro="<p style='color:black;padding:0px;margin:0px;font-size:17px;'>PROXIMO: <span class='glyphicon glyphicon-warning-sign' style='color:#FF8E03'></span> ".$NombreTipoIntevencionOtro." en: ".$diasOtro." dias</p>";
                                }else {
                                    $respuestaOtroGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                                 
                             }                     
                             
                             
                             
         // ALERTA DE REPORTE DE FALLAS
                             
                             
                             
                  $queryIdentificarFallasPendientes="SELECT 
                                                            r.HV_Equipo,
                                                            r.Estado_Equipo, 
                                                            r.Fecha_Reporte, 
                                                            r.Prioridad, 
                                                            r.Nombre_Reporta 
                                                    FROM 
                                                            hoja_vida AS h LEFT JOIN reporte_fallas_equipos AS r ON h.No_HV=r.HV_Equipo 
                                                    WHERE 
                                                            Fecha_Ejecutado = '0000-00-00' && HV_Equipo='".$arrayBuscar['No_HV']."'";           
                  $conexionIdentificarFallasPendientes=mysql_query($queryIdentificarFallasPendientes, $con);
                  
                  while($arrayIdentificarFallasPendientes=mysql_fetch_array($conexionIdentificarFallasPendientes)){
                      $hvEquipo=$arrayIdentificarFallasPendientes['HV_Equipo'];
                      $estadoEquipoFalla=$arrayIdentificarFallasPendientes['Estado_Equipo'];
                      $fechaReporteFalla=$arrayIdentificarFallasPendientes['Fecha_Reporte'];
                      $prioridad=$arrayIdentificarFallasPendientes['Prioridad'];
                      $NombreReporta=$arrayIdentificarFallasPendientes['Nombre_Reporta'];
                  }
                  
                  if(isset($fechaReporteFalla) && $arrayBuscar['No_HV']==$hvEquipo){
                  
                  echo "REPORTE FALLAS <span class='glyphicon glyphicon-remove' style='color:red'></span>: <strong>ESTADO EQUIPO</strong>:<strong style='color:red;'>$estadoEquipoFalla</strong>. Reportado desde:<strong>$fechaReporteFalla</strong>";
                  
                  }
       
       echo "</td>";
       
       $id=$arrayBuscar['Id'];
       echo "<td style='width:50px;font-size:17px;' align='center'>";
    echo "<form id='formularioedicion' method='POST' action='hojaVida.php'>";
    
        echo "<input type='hidden' value='none' name='desdebuscador'>";       
        echo "<input type='hidden' name='idseleccionado1' value='$id'>";
       
        echo "<button type='submit' id='idseleccionado' class='btn btn-info'><span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
    echo "</td>";   
    echo "</form>";   
     }        
    
       echo "</tr>";     
           ?> 
            </tbody>
  </table>
    
    
    <?php } ?>
</div>
</div>
    </div>

<!--  DISPLAY PARA CELULAR   -->
    
    <div id="DisplayCelulares">
    
    <?php
        
    if(isset($_POST['enviar'])){
        
        $sede=$_POST['sede'];
           $Area=$_POST['area'];
           $SubArea=$_POST['subarea'];
           $tp=$_POST['tipoEquipo'];
           $CodHV=$_POST['Cod_Equipo'];
            
           if($sede==""){
               $ConsultaSede=1;
           }else{
               $ConsultaSede="p.Sede='$sede'";
           } 
           if($Area==""){
               $ConsultaArea=1;
           }else{
               $ConsultaArea="p.Area='$Area'";
           } 
           if($SubArea==""){
               $consultaSubArea=1;
           }else{
               $consultaSubArea="p.SubArea='$SubArea'";
            } 
           if($tp==""){
               $consultatp=1;
           }else{
               $consultatp="h.Tipo_Equipo='$tp'";
           } 
           if($CodHV==""){
               $consultaCodHV=1;
           }else{
               $consultaCodHV="h.No_HV='$CodHV'";
           } 
            
           $condicionquery="$ConsultaSede && $ConsultaArea && $consultaSubArea && $consultatp && $consultaCodHV";
           
           
           
        }else{
           $condicionquery=1; 
        }
        
        // cuando no se selecciona ningun filtro en la busqueda
    
    $queryBuscar="SELECT
	IF(p.Area IS null, 'NO TIENE UBICACIÓN',p.Area) AS Area,
	h.Id,
	h.No_HV,
	h.Tipo_Equipo, 
	h.Nombre_Equipo,
        p.Fecha_Marcha,
        p.Sede,
        p.Area,
        p.SubArea
FROM
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
WHERE
 
	$condicionquery

      &&  IF(CONCAT(h.No_HV, p.Version) IS null,1,

    CONCAT(h.No_HV, p.Version) IN (
			SELECT
    			CONCAT(
				h.No_HV, 
				MAX(p.Version)
			) 
		FROM 
			hoja_vida as h 
			LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
		WHERE 
			1 
		GROUP BY 
			h.No_HV
	))
GROUP BY 
	p.Area, 
	h.Tipo_Equipo, 
	h.No_HV";

    $conexionBuscar=mysql_query($queryBuscar, $con);
    
    
    echo "<div class='list-group'>";
       while($arrayBuscar=mysql_fetch_array($conexionBuscar)){
       $i++;
       
       
    $id=$arrayBuscar['Id'];
        echo "<a href='#' onclick='enviar($id)' class='list-group-item' id='btnIrHV'>";
        echo "<h4 class='list-group-item-heading'>Codigo:<strong>".$arrayBuscar['No_HV']."</strong> Nombre: <strong>".$arrayBuscar['Nombre_Equipo']."</strong></h4>";
        echo "<p class='list-group-item-text'><label>Ubicacion: </label>".$arrayBuscar['Area']."<label>Tipo Equipo: </label>".$arrayBuscar['Tipo_Equipo']."</p>";
        
        
       echo "<td style='width:50px;'>";
    
    echo "<form id='formularioedicion$id' method='POST' action='hojaVida.php'>";
        echo "<input type='hidden' value='none' name='desdebuscador'>";       
        echo "<input type='hidden' name='idseleccionado1' value='$id'>";
       
        //echo "<button type='submit' id='idseleccionado'><span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
    echo "</td>";   
    echo "</form>";
    
        echo "</a>";
       } 
    echo "</div>";    
       ?>
    </body>
</html>
