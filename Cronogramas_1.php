<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cronogramas</title>
        <link rel="stylesheet" href="EstilosCronogramas.css">
        <!--<link rel="stylesheet" href="estilos.css">-->
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript">
        </script>
    </head>
    <body>
        
         <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        <div class="page-header" id="encabezadoinicio" style="border-bottom: 1px solid #a3a3a3;">
            <div style="float: left">
            <h1><label>CRONOGRAMAS</label> <small style="color: white"></small></h1>
            </div>
            <div style="float: right;margin-right: 30px;margin-top: 30px;">
                <a href='Menu.php'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        </div>
        </div>
       
        <div style="width: 95%;margin: auto;">
        
        <?php
        include('./conexion.php');
        include('./ModalDetalleCronograma.php');
        $con=  conectar();
        $time=  time();
        $fecharegistro=date("Y-m-d", $time);
        $año=date("Y",$time);
        
        ?>
       <div style="width: 100%;margin: auto;" class="form-inline">
        
           <?php
           
            if(isset($_POST['generar'])){
                $filtroAño=$_POST['txtAnio'];
                $filtroTipoIntervencion=$_POST['TipoIntervencion'];
                $filtroHV=$_POST['Cod_Equipo'];
                $filtroCiudad=$_POST['Ciudad'];
                $filtroSede=$_POST['Sede'];
                $filtroArea=$_POST['Area'];
                $filtroTipoEquipo=$_POST['tipoEquipo'];
                
            }else{
                $filtroAño=$año;
                $filtroTipoIntervencion="Todos";
                $filtroHV="";
                $filtroCiudad="Todos";
                $filtroSede="Todos";
                $filtroArea="Todos";
                $filtroTipoEquipo="Todos";
            }
                
            if($filtroTipoIntervencion=="Todos" || $filtroTipoIntervencion==""){
                $FTIMAnto="display:block";
                $FTIVerificacion="display:block";
                $FTICalibracion="display:block";
                $FTICalificacion="display:block";
                $FTIOtro="display:block";
                
            }else if($filtroTipoIntervencion=="Manto Preventivo"){
                $FTIMAnto="display:block";
                $FTIVerificacion="display:none";
                $FTICalibracion="display:none";
                $FTICalificacion="display:none";
                $FTIOtro="display:none";
                
            }else if($filtroTipoIntervencion=="Verificacion"){
                $FTIMAnto="display:none";
                $FTIVerificacion="display:block";
                $FTICalibracion="display:none";
                $FTICalificacion="display:none";
                $FTIOtro="display:none";
                
            }else if($filtroTipoIntervencion=="Calibracion"){
                $FTIMAnto="display:none";
                $FTIVerificacion="display:none";
                $FTICalibracion="display:block";
                $FTICalificacion="display:none";
                $FTIOtro="display:none";
                
            }else if($filtroTipoIntervencion=="Calificacion"){
                $FTIMAnto="display:none";
                $FTIVerificacion="display:none";
                $FTICalibracion="display:none";
                $FTICalificacion="display:block";
                $FTIOtro="display:none";
                
            }else if($filtroTipoIntervencion=="Otros") {
                $FTIMAnto="display:none";
                $FTIVerificacion="display:none";
                $FTICalibracion="display:none";
                $FTICalificacion="display:none";
                $FTIOtro="display:block";
            }
            
            
            if($filtroHV!=""){
                
                $CondicionalHV="No_HV='$filtroHV'";
                $FHV=$filtroHV;
                
            }else{
                $CondicionalHV=1;
                $FHV="";
            }
            
            
            if($filtroCiudad!="Todos"){
                $queryFiltroCiudad="Sede='$filtroCiudad'";
            }else{
                $queryFiltroCiudad=1;
            }
            
            if($filtroSede!="Todos"){
                $queryFiltroSede="Area='$filtroSede'";
            }else{
                $queryFiltroSede=1;
            }
            
            if($filtroArea!="Todos"){
                $queryFiltroArea="SubArea='$filtroArea'";
            }else{
                $queryFiltroArea=1;
            }
            
            if($filtroTipoEquipo!="Todos"){
                $queryFiltroTipoEquipo="Tipo_Equipo='$filtroTipoEquipo'";
            }else{
                $queryFiltroTipoEquipo=1;
            }
            
        
            //$equiposProgramados="SELECT h.No_HV,h.Nombre_Equipo FROM hoja_vida AS h WHERE $CondicionalHV && GROUP BY No_HV";
        
            $equiposProgramados="SELECT 
                                        h.No_HV, 
                                        h.Nombre_Equipo,
                                        h.Tipo_Equipo,
                                        p.Fecha_Marcha 
                                FROM 
                                        hoja_vida AS h 
                                        LEFT JOIN puesta_marcha AS p ON h.No_HV = p.No_HV
                                        
                                WHERE 
                                        1 && CONCAT(p.No_HV, p.Version) IN (
                                                SELECT 
                                                        CONCAT(
                                                                p.No_HV, 
                                                                MAX(p.Version)
                                                        ) 
                                                FROM 
                                                        puesta_marcha AS p 
                                                WHERE 
                                                        $CondicionalHV && $queryFiltroCiudad && $queryFiltroSede && $queryFiltroArea && $queryFiltroTipoEquipo
                                        GROUP BY p.No_HV
                                        ) GROUP BY h.No_HV";
            
            $conexionSeleccionEquipos=mysql_query($equiposProgramados, $con);
            
            
           ?>
           
           <div id="panel1" class="panel panel-default">
    <div class="panel-heading" role="tab" id="barraExpancion">
        <h4 class="panel-title" style="text-align: center;">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 21px;">
                OPCIONES DE BÚSQUEDA DE EQUIPOS <span class="glyphicon glyphicon-triangle-bottom"></span><span class="glyphicon glyphicon-triangle-top"></span>
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">    
<form id="formBuscador" method="POST" action="Cronogramas.php">
    
    <div class="form-group" id="anio">
                
        <!--<div class="form-group" id="campoAnio">-->
                <label class="lblFiltros">AÑO CRONOGRAMA</label>
                <input type="text" name="txtAnio" id="txtAnio" class="form-control" value="<?php echo $filtroAño; ?>" placeholder="<?php echo $filtroAño; ?>">
        <!--</div>-->
    </div>
    
        
        <div class="form-group" id="ciudad">
                <?php
                if(isset($_POST['Ciudad'])){
                  $c=$_POST['Ciudad'];
                  $display="display:block";
                }else{
                  $c="Todos";
                  $display="display:none";
                }
                
                $querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                
                
                ?>
        <!--<div class="form-group" id="campoSede">-->
        <!--<div class="form-group" id="campoCiudad">-->       
        <label class="lblFiltro_Sede" style="width: 100px;">CIUDAD</label>
                <!--<input type="text" name="sede" id="txtSede" class="form-control" value="<?php //echo $s; ?>" placeholder="<?php //echo $s; ?>">-->
                <select class="form-control" name="Ciudad" id="txtCiudad">
                    <option value="<?php echo $c; ?>"><?php echo $c; ?></option> 
                    <?php
                   
                   while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                   
                    echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                }
                   ?>
                   </select>
    
    </div>
    
            <div class="form-group" id="campoArea">
    
                <?php
                if(isset($_POST['Sede'])){
                  $s=$_POST['Sede'];  
                }else{
                  $s="Todos";  
                }
                
                $querySeleccionSede="SELECT Area FROM ubicaciones WHERE 1 GROUP BY Area";
                $conexionSeleccionSede=mysql_query($querySeleccionSede, $con);
                
                ?>   
                
                <label class="lblFiltros" style="width: 100px;">SEDE</label>
                <!--<input type="text" name="area" id="txtArea" class="form-control" value="<?php //echo $a; ?>" placeholder="<?php //echo $a; ?>">-->
                <select class="form-control" name="Sede" id="txtSede">
                    <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                    <option value="Todos">Todos</option>
                   <?php
                   while($arraySeleccionSede=mysql_fetch_array($conexionSeleccionSede)){
                   
                    echo "<option>".$arraySeleccionSede['Area']."</option>";
                }
                   ?>
                   </select>
            
            
            </div>
    
    <div class="form-group" id="CampoSub_area">
         <?php
                if(isset($_POST['Area'])){
                  $sa=$_POST['Area'];  
                }else{
                  $sa="Todos";  
                }
                
                $querySeleccionArea="SELECT Sub_Area FROM ubicaciones GROUP BY Sub_Area";
                $conexionSeleccionArea=mysql_query($querySeleccionArea, $con);
                
                ?>        
        
        <label class="lblFiltros" style="width: 100px;">AREA</label>
                <!--<input type="text" name="subarea" id="txtSubArea" class="form-control" value="<?php //echo $sa; ?>" placeholder="<?php //echo $sa; ?>">-->
            
            <select class="form-control" name="Area" id="txtArea">
                <option value="<?php echo $sa; ?>"><?php echo $sa; ?></option> 
                <option value="Todos">Todos</option> 
                   <?php
                   while($arraySeleccionArea=mysql_fetch_array($conexionSeleccionArea)){
                    echo "<option>".$arraySeleccionArea['Sub_Area']."</option>";
                }
                   ?>
                   </select>
    </div>
    
    <div class="form-group" id="campoTipo_equipo">
        <?php
                if(isset($_POST['tipoEquipo'])){
                  $t=$_POST['tipoEquipo'];  
                }else{
                  $t="Todos";  
                }
                
                $querySeleccionTipoEquipo="SELECT 
                                                    Tipo_Equipo 
                                            FROM 
                                                    tipo_equipo 
                                            WHERE 
                                                    1";
                
                $conexionSeleccionTipoEquipo=  mysql_query($querySeleccionTipoEquipo, $con);
                
                ?>        
        
        <label class="lblFiltros">TIPO EQUIPO</label>
                <!--<input type="text" id="txtTipoEquipo" name="tipoEquipo" class="form-control" value="<?php// echo $t; ?>" placeholder="<?php //echo $t; ?>">-->
        <select class="form-control" name="tipoEquipo" id="txtTipoEquipo">
                <option value="<?php echo $t; ?>"><?php echo $t; ?></option> 
                <option value="Todos">Todos</option> 
                   <?php
                   while($arraySeleccionTipoEquipo=mysql_fetch_array($conexionSeleccionTipoEquipo)){
                    echo "<option>".$arraySeleccionTipoEquipo['Tipo_Equipo']."</option>";
                }
                   ?>
        </select>
        
        
        </div>
    
    <div class="form-group" id="campoCod_HV">
        <?php
                if(isset($FHV)){
                  $ch=$FHV;  
                }else{
                  $ch="";  
                }
                ?>        
        
        <label class="lblFiltros" style="width: 100px;">No EQUIPO</label>
                <input type="text" id="txtCodEquipo" name="Cod_Equipo" class="form-control" value="<?php echo $ch; ?>" placeholder="<?php echo $ch; ?>">
            </div>
    <div class="form-group" id="campoCod_HV">
        <?php
                if(isset($filtroTipoIntervencion)){
                  $ti=$filtroTipoIntervencion;  
                }else{
                  $ti="Todos";  
                }
                ?>        
        
        <label class="lblFiltros">TIPO INTERVENCION</label>
                
                <select  id="idTipoIntervencion" name="TipoIntervencion" class="form-control">
                    <option value="<?php echo $ti; ?>"><?php echo $ti; ?></option>
                    <option value="Todos">Todos</option>
                    <option value="Manto Preventivo">Manto Preventivo</option>
                    <option value="Verificacion">Verificacion</option>
                    <option value="Calibracion">Calibracion</option>
                    <option value="Calificacion">Calificacion</option>
                    <option value="Otros">Otros</option>
                  </select>    
            </div>
    <br/>
    <div id="campobtn">
    
    <button type="submit" name="generar" id="idGenerar" class="btn btn-primary">Generar</button>
    </div>
    </form>
        </div>
        </div>
</div>
           
            
           </div>
        <br/>
             
        
        <script type="text/javascript">
$(document).ready(function(){
    $("#tablaCronograma").DataTable({
        "language":{
            "search": "Búsqueda Rápida",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "emptyTable": "No existen datos disponibles",
            },
            "ordering": false,
            
    });
});
</script>
        
        
        <table id="tablaCronograma" class="table table-bordered" style="width: 100%;margin: auto;">
            
            <thead>
            <tr style="text-align:center;background: #C9D6DF;font-weight: bold;">
                <td style="font-size: 17px;vertical-align: middle;">No HV</td>
                <td style="font-size: 17px;vertical-align: middle;">NOMBRE EQUIPO</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Ene</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Feb</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Mar</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Abr</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">May</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Jun</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Jul</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Ago</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Sep</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Oct</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Nov</td>
                <td style="width: 110px;font-size: 20px;vertical-align: middle;">Dic</td>
            </tr>
            </thead>
            <tbody>
            
            <?php
            
            $i=0;
            
            while($arraySeleccionDocumentos=mysql_fetch_array($conexionSeleccionEquipos)){
            
            echo "<tr id='FilaDatos'>";
                echo "<td id='btnModal'>";
                    echo $arraySeleccionDocumentos['No_HV'];
                    //$modaCronograma=modalCronogramas();
                echo "</td>";
            
                echo "<td>";
                    echo $arraySeleccionDocumentos['Nombre_Equipo'];
                echo "</td>";
            
                if(isset($_POST['generar'])){
                    
                    $añoFiltroCronograma=$_POST['txtAnio'];
                }else{
                    $añoFiltroCronograma=$año;
                    
                }
                
                $time=time();
                $FechaSistema=date("Y-m-d",$time);
                
                
                // Fecha puesta en marcha del equipo
                
                $queryPuestaMarcha="SELECT MAX(Fecha_Marcha) FROM puesta_marcha WHERE No_HV='".$arraySeleccionDocumentos['No_HV']."'";
                $conexionPuestaMarcha=mysql_query($queryPuestaMarcha, $con);
                while($arrayPuestaMarcha=  mysql_fetch_array($conexionPuestaMarcha)){
                   $FechaPuestaMarcha=$arrayPuestaMarcha['MAX(Fecha_Marcha)'];
                }
                
                echo "<td>";
                // Mes: enero
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-01";
                echo "<div id='limiteManto' style='$FTIMAnto;'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                
                      echo "<td>";
                // Mes: FEBRERO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-02";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        echo "</td>";
                        
                        
                        echo "<td>";
                // Mes: MARZO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-03";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                        
                      
                       echo "<td>";
                // Mes: ABRIL
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-04";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                        
                       echo "<td>";
                // Mes: MAYO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-05";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                       echo "<td>";
                // Mes: JUNIO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-06";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                       echo "<td>";
                // Mes: JULIO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-07";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                       echo "<td>";
                // Mes: AGOSTO
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-08";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                      
                       echo "<td>";
                // Mes: SEPTIEMBRE
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-09";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                       echo "<td>";
                // Mes: OCTUBRE
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-10";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                       echo "<td>";
                // Mes: NOVIEMBRE
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-11";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                      
                      
                       echo "<td>";
                // Mes: DICIEMBRE
                // Mantenimiento preventivo
                
                $periodoCronograma="$añoFiltroCronograma-12";
                echo "<div id='limiteManto' style='$FTIMAnto'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Mantenimiento preventivo'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Manto Preventivo<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Manto Preventivo <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxManto="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Mantenimiento preventivo'";
                   
                   $conexionMaxFechaManto=mysql_query($querySeleccionarMaxManto, $con); 
                   
                   while($arrayMaxFechaManto=mysql_fetch_array($conexionMaxFechaManto)){
                    $fechaUltimoManto=$arrayMaxFechaManto['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaManto="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Mantenimiento preventivo' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaManto=mysql_query($frecuenciaManto, $con);
               while($arrayFrecuenciaManto=  mysql_fetch_array($conexionFrecuenciaManto)){
                 $FrecuenciaEquipo=$arrayFrecuenciaManto['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoManto) && date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoManto + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaMantosProyectadoalperiodo=0;
                $CuentasMantosVencidos=0;
                $CuentasMantosProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasMantosVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasMantosProyectadosVigentes+=1;
                        }
                        
                        if($CuentasMantosVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Manto Preventivo <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasMantosProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Manto Preventivo;<br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                 
                        // VERIFICACION
                        
                        echo "<div id='limiteVerificacion' style='$FTIVerificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Verificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Verificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Verificación<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Verificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxVerificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Verificacion'";
                   
                   $conexionMaxFechaVerificacion=mysql_query($querySeleccionarMaxVerificacion, $con); 
                   
                   while($arrayMaxFechaVerificacion=mysql_fetch_array($conexionMaxFechaVerificacion)){
                    $fechaUltimoVerificacion=$arrayMaxFechaVerificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaVerificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Verificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaVerificacion=mysql_query($frecuenciaVerificacion, $con);
               while($arrayFrecuenciaVerificacion=  mysql_fetch_array($conexionFrecuenciaVerificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaVerificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoVerificacion) && date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoVerificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaVerificacionProyectadoalperiodo=0;
                $CuentasVerificacionVencidos=0;
                $CuentasVerificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasVerificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasVerificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasVerificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Verificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasVerificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Verificación <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // CALIBRACIÓN
                        
                        echo "<div id='limiteCalibracion' style='$FTICalibracion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calibracion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calibracion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calibración <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalibracion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calibracion'";
                   
                   $conexionMaxFechaCalibracion=mysql_query($querySeleccionarMaxCalibracion, $con); 
                   
                   while($arrayMaxFechaCalibracion=mysql_fetch_array($conexionMaxFechaCalibracion)){
                    $fechaUltimoCalibracion=$arrayMaxFechaCalibracion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalibracion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calibracion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalibracion=mysql_query($frecuenciaCalibracion, $con);
               while($arrayFrecuenciaCalibracion=  mysql_fetch_array($conexionFrecuenciaCalibracion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalibracion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalibracion) && date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalibracion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalibracionProyectadoalperiodo=0;
                $CuentasCalibracionVencidos=0;
                $CuentasCalibracionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalibracionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalibracionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalibracionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calibración <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalibracionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calibración <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        // CALIFICACIÓN
                        
                        echo "<div id='limiteCalificacion' style='$FTICalificacion'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion='Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion='Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-Calificación <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                   $querySeleccionarMaxCalificacion="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='Calificacion'";
                   
                   $conexionMaxFechaCalificacion=mysql_query($querySeleccionarMaxCalificacion, $con); 
                   
                   while($arrayMaxFechaCalificacion=mysql_fetch_array($conexionMaxFechaCalificacion)){
                    $fechaUltimoCalificacion=$arrayMaxFechaCalificacion['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaCalificacion="SELECT 
                                            Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion = 'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaCalificacion=mysql_query($frecuenciaCalificacion, $con);
               while($arrayFrecuenciaCalificacion=  mysql_fetch_array($conexionFrecuenciaCalificacion)){
                 $FrecuenciaEquipo=$arrayFrecuenciaCalificacion['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoCalificacion) && date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoCalificacion + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaCalificacionProyectadoalperiodo=0;
                $CuentasCalificacionVencidos=0;
                $CuentasCalificacionProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasCalificacionVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasCalificacionProyectadosVigentes+=1;
                        }
                        
                        if($CuentasCalificacionVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- Calificación <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasCalificacionProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- Calificacion <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        // OTROS
                        
                        echo "<div id='limiteOtro' style='$FTIOtro'>"; // este es limite para el color por tipo de intervencion
                $querySeleccionarProgramacionesRealizadas="SELECT 
                                                                    Fecha_Esperada,
                                                                    Fecha_Intervencion,
                                                                    Tipo_Intervencion
                                                            FROM 
                                                                    reportes_intervencion 
                                                            WHERE 
                                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                                    Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                
                $conexionSeleccionProgramadasRealizadas=mysql_query($querySeleccionarProgramacionesRealizadas, $con);
                $CuentaIntervencionesTardes=0;
                $CuentaIntervencionesOportunas=0; // el valor 2 se coloca como una clave, para que no sea cero.
                //$i=0;
                while($arraySeleccionProgramadaRealizadas=mysql_fetch_array($conexionSeleccionProgramadasRealizadas)){
                    
                    $Fecha_Esperada=$arraySeleccionProgramadaRealizadas['Fecha_Esperada'];
                    $Fecha_Intervencion=$arraySeleccionProgramadaRealizadas['Fecha_Intervencion'];
                    $IntervencionOtroReportado=$arraySeleccionProgramadaRealizadas['Tipo_Intervencion'];
                    $PeriodoIntervencion=date('Y-m',  strtotime($Fecha_Intervencion));       
                    $PeriodoIntervencionProgramado=date('Y-m',  strtotime($Fecha_Esperada));       
                    
                    // Proyeccion de fechas vencidas entre Efecucion y programadas  
                        $queryFrecuenciaVersionIntervencion="SELECT 
                                        i.Frecuencia 
                                    FROM 
                                        reportes_intervencion AS r 
                                        RIGHT JOIN intervenciones AS i ON r.HV_Equipo = i.HV_Equipo && r.Version_Intervencion = i.Version_Intervencion 
                                    WHERE 
                                        i.HV_Equipo='".$arraySeleccionDocumentos['No_HV']."' &&
                                        r.Tipo_Intervencion<>'Mantenimiento preventivo' && r.Tipo_Intervencion<>'Verificacion' && r.Tipo_Intervencion<>'Calibracion' && r.Tipo_Intervencion<>'Calificacion'    
                                    GROUP BY 
                                        i.HV_Equipo, 
                                        i.Tipo_Intervencion";
                        
                        $conexionFrecuenciaVersionIntervencion=mysql_query($queryFrecuenciaVersionIntervencion, $con);
                    
                    
                    
                    // Coloca la fecha programada vencida
                    if($PeriodoIntervencionProgramado==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){
                        
                                            echo "<p>- $IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$Fecha_Esperada."</p>";
                        
                    }  
                        
                      // Identifica la frecuencia parametrizada vigente de la intervencion del equipo, cuando se realizo la intervencion  
                        while($arrayFrecuencia=mysql_fetch_array($conexionFrecuenciaVersionIntervencion)){
                            $frecuencia=$arrayFrecuencia['Frecuencia'];
                        }
                        
                        
                        $dias=(strtotime($Fecha_Intervencion)-strtotime($Fecha_Esperada))/86400;
                        $dias 	= abs($dias); $dias = floor($dias);		
                        $dias1=$dias;
                        
                        $IntervencionesVencidas=floor($dias1/$frecuencia);
                    
                        for($i=1;$i<=$IntervencionesVencidas;$i++){
                            $diasProyectados=$frecuencia*$i;
                            $FechaVencida=date("Y-m-d",strtotime("$Fecha_Esperada + $diasProyectados day"));
                            $periodo=date("Y-m",strtotime($FechaVencida));
                            $Fecha_Programada= date("Y-m-d",strtotime("$Fecha_Esperada + $frecuencia days"));
                           
                        if($periodo==$periodoCronograma && $Fecha_Programada!=$Fecha_Intervencion){  
                            
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$FechaVencida."</p>";     
                        }
                        }
                        
                    if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada<$Fecha_Intervencion){    
                        
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:orange'></span><br/>".$Fecha_Intervencion."</p>";
                    }else if($PeriodoIntervencion==$periodoCronograma && isset($Fecha_Intervencion) && $Fecha_Esperada>=$Fecha_Intervencion){
                        echo "<p>-$IntervencionOtroReportado <span class='glyphicon glyphicon-ok' style='color:green'></span><br/>".$Fecha_Intervencion."</p>";
                    }
                   
                }
                   
                
                
                    //////////////////////////////////////
                // Inicio de codigo para proyeccion de intervenciones.  
                // Fecha de ultima intervencion.
                
                if(isset($IntervencionOtroReportado)){
                    
                    $IntervencionOtroReportado;
                    
                }else{
                    
                    $IntervencionOtroReportado="";
                }
                
                
                
                $querySeleccionarMaxOtro="SELECT 
                                                    MAX(Fecha_Intervencion)
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' &&
                                                    Tipo_Intervencion='$IntervencionOtroReportado'";
                   
                   $conexionMaxFechaOtro=mysql_query($querySeleccionarMaxOtro, $con); 
                   
                   while($arrayMaxFechaOtro=mysql_fetch_array($conexionMaxFechaOtro)){
                    $fechaUltimoOtro=$arrayMaxFechaOtro['MAX(Fecha_Intervencion)'];
                    }
                    
                    // Determinar la frecuencia de la intervencion
                    $frecuenciaOtro="SELECT 
                                        Tipo_Intervencion,    
                                        Frecuencia 
                                    FROM 
                                            intervenciones 
                                    WHERE 
                                            HV_Equipo = '".$arraySeleccionDocumentos['No_HV']."' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion' && CONCAT(
                                                    HV_Equipo, Tipo_Intervencion, Version_Intervencion
                                            ) IN (
                                                    SELECT 
                                                            CONCAT(
                                                                    HV_Equipo, 
                                                                    Tipo_Intervencion, 
                                                                    MAX(Version_Intervencion)
                                                            ) 
                                                    FROM 
                                                            intervenciones 
                                                    GROUP BY 
                                                            HV_Equipo, 
                                                            Tipo_Intervencion
                                            )";
               
               $FrecuenciaEquipo=0;     
               $conexionFrecuenciaOtro=mysql_query($frecuenciaOtro, $con);
               while($arrayFrecuenciaOtro=  mysql_fetch_array($conexionFrecuenciaOtro)){
                 $IntervencionOtroReportado=$arrayFrecuenciaOtro['Tipo_Intervencion'];
                   $FrecuenciaEquipo=$arrayFrecuenciaOtro['Frecuencia'];
                }
                
                
                if($FrecuenciaEquipo=="null" || $FrecuenciaEquipo=="" || $FrecuenciaEquipo==0){
                   // Frecuencias en 0, fin del ciclo.
                
                }else if($FrecuenciaEquipo!="" && $FrecuenciaEquipo>0 && isset($fechaUltimoOtro) && date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"))>=$FechaPuestaMarcha){
                   $fechaProximaIntervencion=date("Y-m-d",strtotime("$fechaUltimoOtro + $FrecuenciaEquipo days"));
                }else{
                   $fechaProximaIntervencion=$FechaPuestaMarcha;
                }
                    
                 // Algoritmo proyeccion Intervenciones a programar
                if(isset($fechaProximaIntervencion) && $FrecuenciaEquipo>0 && $fechaProximaIntervencion!="" && $fechaProximaIntervencion!="0000-00-00"){
                    
                 //Fecha final del cronograma visualizado en pantalla.      
                    $FechaFinCronogramaVisualizado="$añoFiltroCronograma-12-31";   
                   $fechaProximaIntervencion;
                    $TotalDias=(strtotime($FechaFinCronogramaVisualizado)-strtotime($fechaProximaIntervencion))/86400;    
                    
                    $NumeroIntervenciones=floor($TotalDias/$FrecuenciaEquipo);
                
                $cuentaOtroProyectadoalperiodo=0;
                $CuentasOtroVencidos=0;
                $CuentasOtroProyectadosVigentes=0;
                
                for($i=0;$i<=$NumeroIntervenciones;$i++){
                    $i; 
                    $dias=$FrecuenciaEquipo*$i;
                    
                    $ProgramacionesProyectadas=date("Y-m-d", strtotime("$fechaProximaIntervencion + $dias days"));
                    $ProgramacionesProyectadasAplicaPeriodo=date("Y-m", strtotime("$fechaProximaIntervencion + $dias days"));
                    
                    if($ProgramacionesProyectadasAplicaPeriodo==$periodoCronograma){
                        
                        
                        // Cierre For
                        if($ProgramacionesProyectadas<$FechaSistema){
                           $CuentasOtroVencidos+=1; 
                        }
                        
                        if($ProgramacionesProyectadas>=$FechaSistema){
                            $CuentasOtroProyectadosVigentes+=1;
                        }
                        
                        if($CuentasOtroVencidos>0 && $ProgramacionesProyectadas<$FechaSistema){
                              echo "<p id='msjAlerta'>- $IntervencionOtroReportado<span class='glyphicon glyphicon-remove' style='color:red'></span><br/>".$ProgramacionesProyectadas."</p>";    
                            }
                        if($CuentasOtroProyectadosVigentes>0){
                            echo "<p id='msjProximas'>- $IntervencionOtroReportado <br/>".$ProgramacionesProyectadas."</p>";    
                        }
                        
                        }  
                           
                        }
                        
                        }
                        echo "</div>"; // este el cierre del limite
                        
                        
                        
                        
                      echo "</td>";
                //fin meses  
            echo "</tr>";   
                
                }
            ?>
                </tbody>
        </table>
    </div>
        </body>
</html>    