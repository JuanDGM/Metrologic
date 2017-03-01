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
    <body>
            <?php
        include ('./conexion.php');
        $con=  conectar();
        echo "<a href='Menu.php' style='margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>";
        ?>
        <div id="contorno">
            <div class="page-header" id="encabezadoBuscador">
            <p id="titulo">BUSCAR DE HOJA DE VIDA DE EQUIPOS</p>
        </div>
        <?php

        // Condicionales inputs entrada
        
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
   
    if(isset($conexionBuscar)){
        ?> 
    
            
<script type="text/javascript">
$(document).ready(function(){
    $("#tableBusqueda").DataTable({
        
        "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
        
    });
});
</script>

<div id="panel1" class="panel panel-default">
    <div class="panel-heading" role="tab" id="barraExpancion">
        <h4 class="panel-title" style="text-align: center;">
                                        <a class="collapsed" role="button">
                                            FILTROS DE BUSQUEDA DE EQUIPOS
                                        </a>
                                    </h4>
                                </div>
<form class="form-inline" id="formBuscador" style="margin: 10px;" method="POST" action="Buscar_hojaVida.php">
    <div class="form-group" id="sede">
                <?php
                if(isset($sede)){
                  $s=$sede;  
                }else{
                  $s="";  
                }
                ?>
                
                <label class="lblFiltros">SEDE</label>
                <input type="text" name="sede" id="txtSede" class="form-control" value="<?php echo $s; ?>" placeholder="<?php echo $s; ?>">
    </div>
    
<div class="form-group" id="area">
                 <?php
                if(isset($Area)){
                  $a=$Area;  
                }else{
                  $a="";  
                }
                ?>   
                
                <label class="lblFiltros">ÁREA</label>
                <input type="text" name="area" id="txtArea" class="form-control" value="<?php echo $a; ?>" placeholder="<?php echo $a; ?>">
            </div>
    
    <div class="form-group" id="sub_area">
         <?php
                if(isset($SubArea)){
                  $sa=$SubArea;  
                }else{
                  $sa="";  
                }
                ?>        
        
        <label class="lblFiltros">SUB-AREA</label>
                <input type="text" name="subarea" id="txtSubArea" class="form-control" value="<?php echo $sa; ?>" placeholder="<?php echo $sa; ?>">
            </div>
    
    <div class="form-group" id="Tipo_equipo">
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
    
    <div class="form-group" id="Cod_HV">
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
   
    
    <button type="submit" name="enviar" class="btn btn-primary">Generar</button>
    
    </form>
</div>
   
<div id="DisplayOrdenador">
<div class="table-responsive" style="width: 100%;margin: auto">
    <table id="tableBusqueda" class="table table-bordered table-hover">
        <thead>
        <tr style="background: #eee;text-align: center">
            <td id="tdAreaOcultarMovil">AREA</td>
            <td>No HV</td>
            <td>NOMBRE DEL EQUIPO</td>
            <td id="tdTipoEquipoOcultarMovil">TIPO DE EQUIPO</td>
            <td>ESTADO INTERVENCIÓN</td>
            <td>FICHA TÉCNICA</td>
        </tr>
        </thead>
        <tbody>
      <?php
  
      $i=0;
      while($arrayBuscar=mysql_fetch_array($conexionBuscar)){
       $i++;
       echo "<tr>"; 
       echo "<td id='tdAreaOcultarMovil'>".$arrayBuscar['Area']."</td>";
       echo "<td>".$arrayBuscar['No_HV']."</td>";
       echo "<td>".$arrayBuscar['Nombre_Equipo']."</td>";
       echo "<td id='tdTipoEquipoOcultarMovil'>".$arrayBuscar['Tipo_Equipo']."</td>";
       
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
                        
                        // maxima version de frecuencia de intervencion definida para el equipo
                        
                        $maxVersionFrecuenciaIntervencion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_EQUIPO='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $conexionMaximaVersionFrecuenciaIntervencion=mysql_query($maxVersionFrecuenciaIntervencion, $con); 
                        while($arrayMaxVersionIntervencion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaIntervencion)){
                            $MaxVersionIntervencion=$arrayMaxVersionIntervencion['MAX(Version_Intervencion)'];
                        }
                        
                        $queryequipobuscadoPreventivo = "SELECT i.Frecuencia FROM intervenciones as i WHERE i.HV_Equipo='".$arrayBuscar['No_HV']."' && i.Tipo_Intervencion='Mantenimiento preventivo' && Version_Intervencion='$MaxVersionIntervencion'";
                        
                        //$queryequipobuscadoPreventivo = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $queryequipobuscadoVerificacion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Verificacion'";
                        $queryequipobuscadoCalibracion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calibracion'";
                        $queryequipobuscadoCalificacion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion'";
                        
                        $queryequipobuscadoOtro=
                        "SELECT 
                            Tipo_Intervencion, Frecuencia 
                        FROM 
                            intervenciones 
                        WHERE 
                            HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion'";
                        
                        $conexionequipobuscadoPreventivo= mysql_query($queryequipobuscadoPreventivo,$con);
                        $conexionequipobuscadoVerificacion= mysql_query($queryequipobuscadoVerificacion,$con);
                        $conexionequipobuscadoCalibracion= mysql_query($queryequipobuscadoCalibracion,$con);
                        $conexionequipobuscadoCalificacion= mysql_query($queryequipobuscadoCalificacion,$con);
                        $conexionequipobuscadoOtro= mysql_query($queryequipobuscadoOtro,$con);
                        
                        while($arrayequipobuscadoPreventivo=  mysql_fetch_array($conexionequipobuscadoPreventivo)){
                            $mantoPreventivo= $arrayequipobuscadoPreventivo['Frecuencia'];
                            }
                        while($arrayequipobuscadoVerificacion=  mysql_fetch_array($conexionequipobuscadoVerificacion)){
                            $verificacion= $arrayequipobuscadoVerificacion['Frecuencia'];
                            }
                        while($arrayequipobuscadoCalibracion=  mysql_fetch_array($conexionequipobuscadoCalibracion)){
                            $calibracion= $arrayequipobuscadoCalibracion['Frecuencia'];
                            }
                        while($arrayequipobuscadoCalificacion=  mysql_fetch_array($conexionequipobuscadoCalificacion)){
                            $calificacion= $arrayequipobuscadoCalificacion['Frecuencia'];
                            }
                        while($arrayequipobuscadoOtro=  mysql_fetch_array($conexionequipobuscadoOtro)){
                            $TipoOtro= $arrayequipobuscadoOtro['Tipo_Intervencion'];
                            $FrecuenciaOtro= $arrayequipobuscadoOtro['Frecuencia'];
                            }
                            
                            $queryUltimaFechaIntervencionMantoPreventivo="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo'";
                            $queryUltimaFechaIntervencionVerificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Verificacion'";
                            $queryUltimaFechaIntervencionCalibracion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calibracion'";
                            $queryUltimaFechaIntervencionCalificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion'";
                            $queryUltimaFechaIntervencionOtro="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion=''";
                            
                            $conexionUltimaFechaIntervencionManto=mysql_query($queryUltimaFechaIntervencionMantoPreventivo, $con);
                            $conexionUltimaFechaIntervencionVerificacion=mysql_query($queryUltimaFechaIntervencionVerificacion, $con);
                            $conexionUltimaFechaIntervencionCalibracion=mysql_query($queryUltimaFechaIntervencionCalibracion, $con);
                            $conexionUltimaFechaIntervencionCalificacion=mysql_query($queryUltimaFechaIntervencionCalificacion, $con);
                            $conexionUltimaFechaIntervencionOtro=mysql_query($queryUltimaFechaIntervencionOtro, $con);
                            
                            while($arrayUltimaFechaIntervencionManto=  mysql_fetch_array($conexionUltimaFechaIntervencionManto)){
                                $fechaUltimoManto=$arrayUltimaFechaIntervencionManto['MAX(Fecha_Intervencion)'];
                            }
                            while($arrayUltimaFechaIntervencionVerificacion=  mysql_fetch_array($conexionUltimaFechaIntervencionVerificacion)){
                                $FechaUltimoVerificacion=$arrayUltimaFechaIntervencionVerificacion['MAX(Fecha_Intervencion)'];
                            }
                            while($arrayUltimaFechaIntervencionCalibracion=  mysql_fetch_array($conexionUltimaFechaIntervencionCalibracion)){
                                $FechaUltimoCalibracion=$arrayUltimaFechaIntervencionCalibracion['MAX(Fecha_Intervencion)'];
                            }
                            while($arrayUltimaFechaIntervencionCalificacion=  mysql_fetch_array($conexionUltimaFechaIntervencionCalificacion)){
                                $FechaUltimoCalificacion=$arrayUltimaFechaIntervencionCalificacion['MAX(Fecha_Intervencion)'];
                            }
                            while($arrayUltimaFechaIntervencionOtro=  mysql_fetch_array($conexionUltimaFechaIntervencionOtro)){
                                $FechaUltimoOtro=$arrayUltimaFechaIntervencionOtro['MAX(Fecha_Intervencion)'];
                            }
       $FechaMarcha=$arrayBuscar['Fecha_Marcha'];
                            
        $time=  time();
        $fecharegistro=date("Y-m-d", $time);
       
       
        if(isset($color)){
            $estilo=$color;
        }else{
            $estilo="";
        }
       echo "<td style='width:300px;' bgcolor=''>";
                        if(isset($FechaMarcha) && $FechaMarcha!="0000-00-00"){
                            echo $EquipoFueraUso="";
                        }else{
                            echo $EquipoFueraUso="<p style='color: red;'>Equipo fuera de uso</p>";
                        }
       
                            // MANTENIMIENTO PREVENTIVO ALERTA BUSCADOR
                           if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00"){
                               if(isset($fechaUltimoManto) && $fechaUltimoManto!="" && $fechaUltimoManto!="0000-00-00"){
                                    $Sumar=$mantoPreventivo." day";
                                    $nuevafechaManto1 = date('Y-m-d', strtotime("$fechaUltimoManto + $Sumar"));    
                               }else{
                                   $Sumar=$mantoPreventivo." day";
                                    $nuevafechaManto1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaManto1) - strtotime($fecharegistro))/86400;
                                    $diasManto=abs($diasProximaIntervencion);
                                    $diasManto=floor($diasProximaIntervencion);
                                    if($diasManto<0){
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Mantenimiento P. VENCIDO desde: ".$nuevafechaManto1."</p>";
                                }else if(isset($nuevafechaManto1) && $nuevafechaManto1!="0000-00-00" && $diasManto<=30){
                                    echo $respuestaManto="<p style='color:black;padding:0px;margin:0px;'>Mantenimiento preventivo en: ".$diasManto." dias</p>";
                                }else {
                                    $respuestaMantoGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }
                             
//                             else if(isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
//                                   echo $respuestaManto="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }else{
//                                echo $respuestaManto="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }
                            
                            
                            // VERIFICACIÓN ALERTA BUSCADOR
                           if(isset($verificacion) && $verificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00"){
                                
                               if(isset($FechaUltimoVerificacion) && $FechaUltimoVerificacion!="" && $FechaUltimoVerificacion!="0000-00-00"){
                                    $Sumar=$verificacion." day";
                                    $nuevafechaVerificacion1 = date('Y-m-d', strtotime("$FechaUltimoVerificacion + $Sumar"));    
                               }else{
                                   $Sumar=$verificacion." day";
                                    $nuevafechaVerificacion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaVerificacion1) - strtotime($fecharegistro))/86400;
                                    $diasVerificacion=abs($diasProximaIntervencion);
                                    $diasVerificacion=floor($diasProximaIntervencion);
                                
                                    
                                if($diasVerificacion<0){
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Verificación VENCIDA desde: ".$nuevafechaVerificacion1."</p>";
                                    
                                }else if(isset($nuevafechaVerificacion1) && $nuevafechaVerificacion1!="0000-00-00" && $diasVerificacion<=30){
                                    echo $respuestaVerificacion="<p style='color:black;padding:0px;margin:0px;'>Verificación en: ".$diasVerificacion." dias</p>";
                                
                                    
                                }else {
                                    $respuestaVerificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                    
                                }
                             }
                             
//                             else if(isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
//                                   echo $respuestaVerificacion="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }else{
//                                echo $respuestaVerificacion="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }
                            
                            
                            
                            // CALIBRACION ALERTA BUSCADOR
                           if(isset($calibracion) && $calibracion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00"){
                                
                               if(isset($FechaUltimoCalibracion) && $FechaUltimoCalibracion!="" && $FechaUltimoCalibracion!="0000-00-00"){
                                    $Sumar=$calibracion." day";
                                    $nuevafechaCalibracion1 = date('Y-m-d', strtotime("$FechaUltimoCalibracion + $Sumar"));    
                               }else{
                                   $Sumar=$calibracion." day";
                                   $nuevafechaCalibracion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaCalibracion1) - strtotime($fecharegistro))/86400;
                                    $diasCalibracion=abs($diasProximaIntervencion);
                                    $diasCalibracion=floor($diasProximaIntervencion);
                                
                                     
                                if($diasCalibracion<0){
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Calibracion VENCIDA desde: ".$nuevafechaCalibracion1."</p>";
                                
                                    
                                }else if(isset($nuevafechaCalibracion1) && $nuevafechaCalibracion1!="0000-00-00" && $diasCalibracion<=30){
                                    echo "<p style='color:black;padding:0px;margin:0px;'>Calibración en: ".$diasCalibracion." dias</p>";
                                
                                    
                                }else {
                                    //echo "<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                
                                    
                                }
                                }
                                
                                   
//                                else if(isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
//                                   echo $respuestaCalibracion="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }else{
//                                echo $respuestaCalibracion="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }
                            
                            // CALIFICACIÓN ALERTA BUSCADOR
                           if(isset($calificacion) && $calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00"){
                                
                               if(isset($FechaUltimoCalificacion) && $FechaUltimoCalificacion!="" && $FechaUltimoCalificacion!="0000-00-00"){
                                    $Sumar=$calificacion." day";
                                    $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$FechaUltimoCalificacion + $Sumar"));    
                               }else{
                                   $Sumar=$calificacion." day";
                                    $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaCalificacion1) - strtotime($fecharegistro))/86400;
                                    $diasCalificacion=abs($diasProximaIntervencion);
                                    $diasCalificacion=  floor($diasProximaIntervencion);
                                    
                                if($diasCalificacion<0){
                                    echo $respuestaCalificacion="<p style='color:red;padding:0px;margin:0px;'>Calificación VENCIDA desde: ".$nuevafechaCalificacion1."</p>";
                                    
                                }else if(isset($nuevafechaCalificacion1) && $nuevafechaCalificacion1!="0000-00-00" && $diasCalificacion<=30){
                                    echo $respuestaCalificacion="<p style='color:black;padding:0px;margin:0px;'>Calificación en: ".$diasCalificacion." dias</p>";
                                    
                                }else {
                                    $respuestaCalificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                    
                                }
                             }
                            
                           // OTRA INTERVENCION ALERTA BUSCADOR
                           if(isset($FrecuenciaOtro) && $FrecuenciaOtro>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00"){
                                
                               if(isset($FechaUltimoOtro) && $FechaUltimoOtro!="" && $FechaUltimoOtro!="0000-00-00"){
                                    $Sumar=$FrecuenciaOtro." day";
                                    $nuevafechaOtro1 = date('Y-m-d', strtotime("$FechaUltimoOtro + $Sumar"));    
                               }else{
                                   $Sumar=$FrecuenciaOtro." day";
                                    $nuevafechaOtro1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                                }
                                    $diasProximaIntervencion=(strtotime($nuevafechaOtro1) - strtotime($fecharegistro))/86400;
                                    $diasOtro=abs($diasProximaIntervencion);
                                    $diasOtro=floor($diasProximaIntervencion);
                                
                                    
                                if($diasOtro<0 && $TipoOtro!="" && isset($nuevafechaCalificacion1)){
                                    echo $respuestaOtro="<p style='color:red;padding:0px;margin:0px;'>".$TipoOtro." VENCIDO desde: ".$nuevafechaCalificacion1."</p>";
                                
                                    
                                }else if(isset($nuevafechaOtro1) && $nuevafechaOtro1!="0000-00-00" && $diasOtro<=30 && $TipoOtro!=""){
                                    echo $respuestaOtro="<p style='color:black;padding:0px;margin:0px;'>".$TipoOtro." en: ".$diasOtro." dias</p>";
                                    
                                }else {
                                    $respuestaOtro="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }
                             
                                 if(
                                    isset($diasManto)&& 
                                    $diasManto<0|| 
                                    isset($diasVerificacion)&&
                                    $diasVerificacion<0||
                                    isset($diasCalibracion)&&
                                    $diasCalibracion<0 ||
                                    isset($diasCalificacion)&&
                                    $diasCalificacion<0 || 
                                    isset($diasOtro) &&
                                    $diasOtro<0   
                                         
                                    ){
                                     
                                    $color="red";
                                     
                                 } else if(
                                     
                                    isset($diasManto)&& 
                                    //$diasManto>0 && 
                                    $diasManto<30 || 
                                    isset($diasVerificacion)&&
                                    //$diasVerificacion> 0 &&
                                    $diasVerificacion<30 ||
                                    isset($diasCalibracion)&&
                                    //$diasCalibracion >0 &&
                                    $diasCalibracion <30 ||
                                    isset($diasCalificacion)&&
                                    //$diasCalificacion >0 && 
                                    $diasCalificacion <30 || 
                                    isset($diasOtro) &&
                                    //$diasOtro >0 &&
                                    $diasOtro <30
                                         
                                         ){
                                    $color="yellow";
                                     
                                         }else if(
                                             
                                             
                                    isset($diasManto)&& 
                                    $diasManto==""|| 
                                    isset($diasVerificacion)&&
                                    $diasVerificacion==""||
                                    isset($diasCalibracion)&&
                                    $diasCalibracion=="" ||
                                    isset($diasCalificacion)&&
                                    $diasCalificacion=="" || 
                                    isset($diasOtro) &&
                                    $diasOtro=="" 
                                         ){    
                                           
                                          $color="green";   
                                             
                                         }
                           
       echo "</td>";
        
       $id=$arrayBuscar['Id'];
       echo "<td style='width:50px;'>";
    echo "<form id='formularioedicion' method='POST' action='hojaVida.php'>";
    
        echo "<input type='hidden' value='none' name='desdebuscador'>";       
        echo "<input type='hidden' name='idseleccionado1' value='$id'>";
       
        echo "<button type='submit' id='idseleccionado'><span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
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
