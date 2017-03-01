<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proximas intervenciones</title>
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="EstilosProximasIntervenciones.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script src="CrearOrdenTrabajo.js"></script>
        <script>
    
    // Enviar Formulario para reportar Intervencion
        
//        $("#botonirIntervencion").click(function(){
//            $("#formularioirIntervencion").submit();    
//        });
        
        function FiltrarPorVigencia(){
        $("#FormularioVigenciaEquipo").submit();
        }
        
        function enviarFomularioOrden(){
            
            
    
        }
        
        </script>
    </head>
    <body id="cuerpo">
        <div id="franjaColores" style="margin-top: 0px;">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        <br/>
        <br/>
        
        <a href='Menu.php' style='float: right;margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        <?php
            include ('./conexion.php');
            $con= conectar();
            ?>
            <div id="contorno1">
            <!--background: #5cb85c-->
            <div class="page-header" id="encabezadoinicio" style="border-bottom: 1px solid #a3a3a3;">
            <h1><label id="Titulos">PROXIMAS INTERVENCIONES</label></h1>
            </div>
            <br/> 
            
<!--              <button type="button"><img src="images/GenerarPDF1.jpg"></button>
              <button type="button"><img src="images/DescargarExcel.jpg"></button>-->
           <div id="respuestaPlaneacion"></div>
           <!-- IDENTIFICAR LOS EQUIPOS PROXIMOS A INTERVENIR --> 
           <?php
           session_start();
           $time=  time();
           $fecharegistro=date("Y-m-d", $time);
           // Viene desde EstadoIntervenciones.php
        if(isset($_POST['proximas'])){
            //$DiasProximasIntervenciones=$_POST['proximas']; 
            $_SESSION['proximas']=$_POST['proximas'];
            $DiasProximasIntervenciones=$_SESSION['proximas']; 
        }else{
            $DiasProximasIntervenciones=30;
            //$DiasProximasIntervenciones=$_SESSION['proximas'];
        
            
        }      
        // Identifica desde que estado de vigencia del documento se consulta (menu.php)
        // desde vencido viene con filtro VENCIDO
        if(isset($_POST['desdeVencidos'])){
        $desdeVencidos=$_POST['desdeVencidos'];
        }
        if(isset($_POST['desdeProximos'])){
        $desdeProximos=$_POST['desdeProximos'];
        }
        // filtro de vigencia seleccionado
        if(isset($_POST['FiltroVigenciaSeleccionado'])){
            $filtroVigencia=$_POST['FiltroVigenciaSeleccionado'];
        }else if(isset($_POST['desdeVencidos'])){
            $filtroVigencia=$desdeVencidos;
        }else{
            $filtroVigencia="PROXIMAMENTE";
        }
        
        $Sumar=$DiasProximasIntervenciones." day";
        $nuevafecha = date('Y-m-d', strtotime("$fecharegistro + $Sumar"));
        
        $MaximaProximaFechaIntervencionControlar=$nuevafecha;
        
      // SELECCION VENCIDOS Y VIGENTES POR FILTROS  
        $queryIntervencionEquipoxVigencia= "SELECT
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
        IF(t.Fecha_Programada IS null, '','PROGRAMADO') as Estado,
	IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        ), IF(r.Fecha_Intervencion is NULL AND i.Aplica_Desde='Puesta en marcha',p.Fecha_Marcha,(DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        )))) AS PROXIMA_FECHA,
        IF(DATEDIFF(IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	), 
            IF(r.Fecha_Intervencion is NULL AND i.Aplica_Desde='Puesta en marcha',p.Fecha_Marcha,(DATE_ADD(
            r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        )))),                
        '$fecharegistro')>=0,'PROXIMAMENTE','VENCIDO') AS 'VIGENCIA'
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
        (IF(r.Fecha_Intervencion is NULL AND i.Aplica_Desde='Puesta en marcha',p.Fecha_Marcha,(DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	))))),
        '$fecharegistro')>=0,'PROXIMAMENTE','VENCIDO')='$filtroVigencia'
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
           
        
        
        
        
    // SELECCION PARA FILTRADOS POR Todos
        
        $queryIntervencionEquipoTotales= "SELECT
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
        IF(t.Fecha_Programada IS null, '','PROGRAMADO') as Estado,
	IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        ), IF(r.Fecha_Intervencion is NULL AND i.Aplica_Desde='Puesta en marcha',p.Fecha_Marcha,(DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        )))) AS PROXIMA_FECHA,
        IF(DATEDIFF(IF(r.Fecha_Intervencion IS NOT null AND r.Fecha_Intervencion>=p.Fecha_Marcha,
        DATE_ADD(
		r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY
	), 
            IF(r.Fecha_Intervencion is NULL AND i.Aplica_Desde='Puesta en marcha',p.Fecha_Marcha,(DATE_ADD(
            r.Fecha_Intervencion, INTERVAL i.Frecuencia DAY 
        )))),                
        '$fecharegistro')>=0,'PROXIMAMENTE','VENCIDO') AS 'VIGENCIA'
FROM 
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
	LEFT JOIN intervenciones as i ON h.No_HV = i.HV_Equipo 
	LEFT JOIN reportes_intervencion as r ON h.No_HV = r.HV_Equipo 
	AND i.Tipo_Intervencion = r.Tipo_Intervencion
    LEFT JOIN programacion_intervencion as t ON h.No_HV = t.HV_Equipo AND i.Tipo_Intervencion=t.Tipo_Intervencion
WHERE
    CONCAT(p.No_HV,p.Fecha_Marcha) IN 
    (SELECT CONCAT(p.No_HV,MAX(p.Fecha_Marcha)) FROM puesta_marcha AS p GROUP BY p.No_HV)
    &&
    p.Fecha_Descarte='0000-00-00'
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
        
        if($filtroVigencia=="TODOS"){
        $queryIntervencionEquipo=$queryIntervencionEquipoTotales;
        }else{
        $queryIntervencionEquipo=$queryIntervencionEquipoxVigencia;    
        }
          
        //buscar proximo codigo de orden
        
        $querrMaxCodigoOrden="SELECT DISTINCT MAX(Cod_Servicio) FROM programacion_intervencion WHERE 1";
        $conexionMaxCodigoOrden=mysql_query($querrMaxCodigoOrden, $con);
        while($arrayMaxOrden=mysql_fetch_array($conexionMaxCodigoOrden)){
            $MaxCodigoOrden=$arrayMaxOrden[0];
            }
        $nuevoCodigoVersion=$MaxCodigoOrden+1;
        
           $conexionIntervencionEquipo=mysql_query($queryIntervencionEquipo, $con);
           if(isset($conexionIntervencionEquipo)){
               ?>   
           
           <div id="r"></div>
           
       <table>
           <tr>
               <td>
                   <label class="col-sm-2 control-label" style="padding: 0px;">VIGENCIA</label>
           </td>
           <?php
           
           if(isset($_POST['FiltroVigenciaSeleccionado'])){
               $filtroVigencia=$_POST['FiltroVigenciaSeleccionado'];
           } else {
                $filtroVigencia="--Seleccione--";
           }
           
           if(isset($desdeVencidos)){
               
               $filtroVigencia=$desdeVencidos;
           }
           
           
           ?>
           <td>
               <!-- Formulario para filtro por vigencia intervencion  -->
           <form method="POST" action="DetalleEstadoVigente.php" id="FormularioVigenciaEquipo" class="form-horizontal">
               <select class="form-control"  name="FiltroVigenciaSeleccionado" style="width: 180px;" onchange="this.form.submit();">
                <option><?php echo $filtroVigencia; ?></option>
                <option value="TODOS">TODOS</option>
                <option value="PROXIMAMENTE">PROXIMAMENTE</option>
                <option value="VENCIDO">VENCIDOS</option>
            </select>
       </form>
           </td>
           </tr>
       </table>    
           <br/>
           <form method="POST" id="FormularioSolicitudProgramacion" action="OrdenTrabajoProveedor.php">
           <!-- PROGRAMAR ORDEN DE TRABAJO AL PROVEEDOR  -->
           
           <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default" id="panelDefault">
    <div class="panel-heading" role="tab" id="barraExpancion">
      <h4 class="panel-title">
          <a role="button" data-toggle="collapse" id="enlanceAcordeon" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              CREAR ORDEN DE TRABAJO AL PROVEEDOR <span class="glyphicon glyphicon-triangle-bottom"></span><span class="glyphicon glyphicon-triangle-top"></span>
        </a>
      </h4>
    </div>
      
      <?php
      
        $querySeleccionarProveedores="SELECT 
                                            Nombre_Proveedor 
                                    FROM 
                                            informacion_proveedor 
                                    WHERE 
                                            1 
                                    GROUP BY 
                                            Nombre_Proveedor";

        $conexionSeleccionarProveedores=mysql_query($querySeleccionarProveedores, $con);
        
      ?>
      
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    <!--<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
    <div class="panel-body" style="padding: 0px;margin: 0px;">
           <div>
               <table id="tablaDatosProgramar">
                    <tr>
                        <td>
                            <div class="form-group">
                               <label>NOMBRE PROVEEDOR</label>
                               <!--<input type="text" name="nombreProveedor" class="form-control" placeholder="" required>-->
                           <select class="form-control" name="nombreProveedor" required>
                             <option></option>
                               <?php   
                            while($arraySeleccionarProveedores=mysql_fetch_assoc($conexionSeleccionarProveedores)){
                            ?>
                                
                                <option value="<?php echo $arraySeleccionarProveedores['Nombre_Proveedor']; ?>"><?php echo $arraySeleccionarProveedores['Nombre_Proveedor']; ?></option>
                            <?php
                            }
                            ?>
                                
                              </select>
                            
                            
                            </div>
                            </td>
                            <td style="width: 20px;"></td>
                            <td>
                                <div class="form-group">
                                 <label>FECHA SOLICITUD</label>
                                 <input type="date" name="fechasolicitud" class="form-control" placeholder="" value="<?php echo $fecharegistro; ?>" required>
                               </div>
                            </td>
                            <td style="width: 20px;"></td>
                            <td>
                                <div class="form-group">
                                 <label>FECHA PROGRAMADA</label>
                                 <input type="date" name="fechaprogramada" class="form-control" placeholder="">
                               </div>
                            </td>
                            <td style="width: 50px;"></td>
                            
                            <td>
                                <div class="form-group">
                                 <label>No ORDEN TRABAJO</label>
                                 <h1 style="text-align: center;"><?php if(isset($MaxCodigoOrden)!=""){echo $nuevoCodigoVersion;}else{ echo $nuevoCodigoVersion=1;} ?></h1>
                                 <input type="hidden" value="<?php if(isset($MaxCodigoOrden)!=""){echo $nuevoCodigoVersion;}else{ echo $nuevoCodigoVersion=1;} ?>" name="noOrden">
                               </div>
                            </td>
                            
                    </tr>
                   <tr>
                        <td  colspan="5">
                                <div class="form-group">
                                 <label>OBSERVACIONES</label>
                                 <textarea class="form-control" name="observacion" rows="2"></textarea>
                                </div>
                            </td>
                            <td></td>
                        
                    
                        <td><button type="submit" id="IdcrearOrden" name="enviarcheck" class="btn btn-primary" onclick="enviarFomularioOrden();">Crear Orden de trabajo</button></td>
                    </tr>
               </table>
           </div>
      </div>
    </div>
  </div>
  </div>
           </br>         
           
          
           
           <script type="text/javascript">
                $(document).ready(function(){
                $("#tablaBuscada1").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            
            
            },
            
            
            
                });
            });
            </script>
            
            
            <table id="tablaBuscada1" class="table table-bordered table-hover" style="width: 90%;margin: auto;">
                <thead>
                    <tr>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">UBICACIÓN</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">CODIGO EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">NOMBRE EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">FECHA ULTIMA INTERVENCION</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">TIPO INTERVENCION</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">FECHA PPTO EJECUTAR</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">VIGENCIA</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">PROGRAMAR</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">ESTADO PROGRAMADO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">REPORTAR</td>
                </tr>
                </thead>
                <tbody>   
                <?php 
                $i=0;
                
                while($arrayIntevencionEquipo= mysql_fetch_assoc($conexionIntervencionEquipo)){
                    $code=json_encode($arrayIntevencionEquipo);
                    
               ?> 
                <tr>
                    <td><?php echo $arrayIntevencionEquipo['Area'];?></td>
                    <td><?php echo $arrayIntevencionEquipo['No_HV'];?></td>
                    <td><?php echo $arrayIntevencionEquipo['Nombre_Equipo'];?></td>
                    <td><?php echo $arrayIntevencionEquipo['Fecha_Intervencion'];?></td>
                    <td><?php echo $arrayIntevencionEquipo['Tipo_Intervencion'];?></td>
                    <td><?php echo $arrayIntevencionEquipo['PROXIMA_FECHA'];?></td>
                <?php
                    
                $vigencia=$arrayIntevencionEquipo['VIGENCIA'];
                if($vigencia=="VENCIDO"){
                    $colorCeldaVigencia="red";
                    
                }else{
                    
                    $colorCeldaVigencia="blue";
                }
                
                echo "<td style='color:$colorCeldaVigencia;'>".$vigencia."</td>";
                
                echo "<td><input type='checkbox' value='$code' name='check[]' style='width:90px;'></td>";
                
                
                // Control para especificar el estado de programacion de la intervencion
                //echo "<td>";
                
                //$queryVigenciaProgramacion="SELECT Fecha_Realizacion FROM programacion_intervencion WHERE Fecha_Realizacion<>'0000-00-00'";
                
                $queryMaxCodServicio="SELECT MAX(Cod_Servicio)FROM programacion_intervencion WHERE HV_Equipo='".$arrayIntevencionEquipo['No_HV']."' && Tipo_Intervencion='".$arrayIntevencionEquipo['Tipo_Intervencion']."'";
                $ConexionMaxCodServicio=mysql_query($queryMaxCodServicio, $con);
                
                while($arrayMaxCodServicio=mysql_fetch_array($ConexionMaxCodServicio)){
                    $codigoHVProgramacion=$arrayMaxCodServicio['MAX(Cod_Servicio)'];
                  }
                
                $queryEstadoProgramacion="SELECT Fecha_Realizacion FROM programacion_intervencion WHERE HV_Equipo='".$arrayIntevencionEquipo['No_HV']."' && Tipo_Intervencion='".$arrayIntevencionEquipo['Tipo_Intervencion']."' && Cod_Servicio='$codigoHVProgramacion'";
                $ConexionEstadoProgramacion=mysql_query($queryEstadoProgramacion, $con);
                
                while($arrayEstadoProgramacion=mysql_fetch_array($ConexionEstadoProgramacion)){
                  //$codigoHVProgramacion=$arrayEstadoProgramacion['MAX(Cod_Servicio)'];
                  $FechaRealizacion=$arrayEstadoProgramacion['Fecha_Realizacion'];
                }
                
                if(isset($codigoHVProgramacion)!="" && $FechaRealizacion=='0000-00-00'){
                    echo "<td style='background: green;color:white;'>";
                    echo $Estado="<a href='OrdenTrabajoProveedor.php?id=$codigoHVProgramacion' style='color:white;'>Programado! No Orden:".$codigoHVProgramacion."</a>";
                    echo "</td>";
                    
                }else{
                    echo "<td style='background: red;color:white;'>";
                    echo $Estado="Sin Programación";
                    echo "</td>";
                }
                
                //echo "</td>";
                
                echo "</form>";
                    
                // Lleva a diligenciar el reporte
                    echo "<form method='POST' id='formularioirIntervencion' action='reporteIntervencion.php'>";
                        echo "<input type='hidden' value='".$arrayIntevencionEquipo['No_HV']."' name='codHVencidos'>";
                        echo "<input type='hidden' value='".$arrayIntevencionEquipo['Tipo_Intervencion']."' name='IntervencionVencida'>";
                        echo "<input type='hidden' value='".$codigoHVProgramacion."' name='CodHVProgramado'>";
                        echo "<td><button input='submit' id='botonirIntervencion' class='btn btn-primary'><span class='glyphicon glyphicon-wrench'></span></button></td>";
                    echo "</form>";
                }
                
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            }
            
            
           ?>
        </div>
    </body>
</html>