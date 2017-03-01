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
                        
                          
       echo "</td>";
        
       echo "<td>";
       //Celda para alerta de intervenciones
       
       
       $maxVersionFrecuenciaMatenimiento="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $conexionMaximaVersionFrecuenciaManto=mysql_query($maxVersionFrecuenciaMatenimiento, $con); 
                        while($arrayMaxVersionIntervencion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaManto)){
                            $MaxVersionIntervencion=$arrayMaxVersionIntervencion['MAX(Version_Intervencion)'];
                        }
       
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
       
       $queryequipobuscadoCalificacion = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='".$arrayBuscar['No_HV']."' && Tipo_Intervencion='Calificacion' && Version_Intervencion='$MaxVersionCalificacion'";
       $conexionFrecuenciaCalificacion=mysql_query($queryequipobuscadoCalificacion, $con);
       while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
           $Calificacion=$arrayFrecuenciaCalificacion['Frecuencia'];
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
       
       // MANTENIMIENTO PREVENTIVO ALERTA BUSCADOR
                           if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $mantoPreventivo>$Fecha_Marcha){
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
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Mantenimiento P. VENCIDO desde: ".$nuevafechaManto1."</p>";
                                }else if(isset($nuevafechaManto1) && $nuevafechaManto1!="0000-00-00" && $diasManto<=30){
                                    echo $respuestaManto="<p style='color:black;padding:0px;margin:0px;'>Mantenimiento preventivo en: ".$diasManto." dias</p>";
                                }else {
                                    $respuestaMantoGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }
                             
       // VERIFICACION: ALERTA BUSCADOR
                           if(isset($Verificacion) && $Verificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $Verificacion>$Fecha_Marcha){
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
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Verificación. VENCIDA desde: ".$nuevafechaVerificacion."</p>";
                                }else if(isset($nuevafechaVerificacion) && $nuevafechaVerificacion!="0000-00-00" && $diasVerificacion<=30){
                                    echo $respuestaVerificacion="<p style='color:black;padding:0px;margin:0px;'>Verificación en: ".$diasVerificacion." dias</p>";
                                }else {
                                    $respuestaVerificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }
                             
                             
    // CALIBRACION: ALERTA BUSCADOR
                           if(isset($Calibracion) && $Calibracion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $Calibracion>$Fecha_Marcha){
                               if(isset($FechaUltimoVerificacion) && $FechaUltimoVerificacion!="" && $FechaUltimoVerificacion!="0000-00-00"){
                                    $Sumar=$Calibracion." day";
                                    $nuevafechaCalibracion = date('Y-m-d', strtotime("$FechaUltimoCalibracion + $Sumar"));    
                               }else{
                                   
                                    $nuevafechaCalibracion = $Fecha_Marcha;
                                }
                                    $diasProximaCalibracion=(strtotime($nuevafechaCalibracion) - strtotime($fecharegistro))/86400;
                                    $diasCalibracion=abs($diasProximaCalibracion);
                                    $diasCalibracion=floor($diasProximaCalibracion);
                                    if($diasCalibracion<0){
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Calibracion. VENCIDA desde: ".$nuevafechaCalibracion."</p>";
                                }else if(isset($nuevafechaCalibracion) && $nuevafechaCalibracion!="0000-00-00" && $diasCalibracion<=30){
                                    echo $respuestaCalibracion="<p style='color:black;padding:0px;margin:0px;'>Calibración en: ".$diasCalibracion." dias</p>";
                                }else {
                                    $respuestaCalibracionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
                             }
                             
                             
    // CALIFICACION: ALERTA BUSCADOR
                           if(isset($Calificacion) && $Calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha!="0000-00-00" && $Calificacion>$Fecha_Marcha){
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
                                    echo "<p style='color:red;padding:0px;margin:0px;'>Calificación. VENCIDA desde: ".$nuevafechaCalificacion."</p>";
                                }else if(isset($nuevafechaCalificacion) && $nuevafechaCalificacion!="0000-00-00" && $diasCalificacion<=30){
                                    echo $respuestaCalificacion="<p style='color:black;padding:0px;margin:0px;'>Calificación en: ".$diasCalificacion." dias</p>";
                                }else {
                                    $respuestaCalificacionGreen="<p style='color:black;padding:0px;margin:0px;'>Vigente</p>";
                                }
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
