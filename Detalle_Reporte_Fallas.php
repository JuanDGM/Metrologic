<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reportes de Fallas</title>
        <link rel="stylesheet" href="EstilosDetalleFallaReportadas.css">
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        
        <script>
    
    // Enviar Formulario para reportar Intervencion
        
        $("#botonirIntervencion").click(function(){
            $("#formularioirIntervencion").submit();    
        });
        
       
        
        function FiltrarPorVigencia(){
        $("#FormularioVigenciaEquipo").submit();
        }
        
        </script>
    </head>
    <body id="cuerpoDetalleFalla">
        <div id="franjaColores" style="margin-top: 0px;">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        <br/>
        <br/>
        
        <?php
            //include('./regresar.php');
            include ('./conexion.php');
            //Regresar();
        echo "<a href='Menu.php' style='float: right;margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>";    
            
            $con= conectar();
            ?>
        <div id="contorno1">
            <!--background: #5cb85c-->
            
            <div class="page-header" id="encabezadoinicio" style="border-bottom: 1px solid #a3a3a3;">
            <h1><label id="titulo">EQUIPOS CON FALLAS REPORTADAS</label></h1>
            </div>
            <br/> 
           
           <?php

           $time=  time();
           $fecharegistro=date("Y-m-d", $time);
        
      // EQUIPOS REPORTADOS  
        $queryIntervencionEquipoxVigencia= "SELECT 
	f.HV_Equipo, 
	p.Sede, 
	p.Area, 
	p.SubArea, 
	f.Estado_Equipo, 
	f.Fecha_Fallo_Equipo, 
	f.Fecha_Reporte, 
	f.Descripcion, 
	f.Nombre_Reporta, 
	f.Prioridad, 
	f.Cod_Reporte 
FROM 
	reporte_fallas_equipos AS f 
	JOIN puesta_marcha AS p ON f.HV_Equipo = p.No_HV 
WHERE 
	f.Fecha_Ejecutado = '0000-00-00' && p.Fecha_Descarte='0000-00-00' && IF(
		f.HV_Equipo IS NOT null, 
		1, 
		concat(p.No_HV, p.Version) in (
			SELECT 
				concat(
					p.No_HV, 
					MAX(p.Version)
				) 
			FROM 
				reporte_fallas_equipos AS f 
				JOIN puesta_marcha AS p ON f.HV_Equipo = p.No_HV 
			GROUP BY 
				p.No_HV
		)) 
		GROUP BY 
			 f.HV_Equipo";
                
        $conexionIntervencionEquipoxVigencia=mysql_query($queryIntervencionEquipoxVigencia, $con);
        
           
           ?>
           
           </tr>
       </table>    
           <br/>
           <form method="POST" id="FormularioSolicitudProgramacion" action="OrdenTrabajoProveedor.php">
           <!-- PROGRAMAR ORDEN DE TRABAJO AL PROVEEDOR  -->
           
           <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="barraExpancion">
      <h4 class="panel-title">
          <a role="button" data-toggle="collapse" id="enlanceAcordeon" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
              <label style="text-align: center;">CREAR ORDEN DE TRABAJO AL PROVEEDOR</label><span class="glyphicon glyphicon-triangle-bottom"></span><span class="glyphicon glyphicon-triangle-top"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    <!--<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
      <div class="panel-body">
           <div>
               <table style="margin: auto;">
                    <tr>
                        <td>
                            <div class="form-group">
                               <label>NOMBRE PROVEEDOR</label>
                               <input type="text" name="nombreProveedor" class="form-control" placeholder="">
                            </div>
                            </td>
                            <td style="width: 20px;"></td>
                            <td>
                                <div class="form-group">
                                 <label>FECHA SOLICITUD</label>
                                 <input type="date" name="fechasolicitud" class="form-control" placeholder="">
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
                    
                        <td><button type="submit" name="enviarcheck" class="btn btn-primary">Crear Orden de trabajo</button></td>
                    </tr>
               </table>
           </div>
      </div>
    </div>
  </div>
  </div>
           
           
           
           <script type="text/javascript">
                $(document).ready(function(){
                $("#tablaBuscada1").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
                 
                });
            });
            </script>
            
            <br/>
            <table id="tablaBuscada1" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td style="vertical-align: middle;text-align: center;font-weight: bold;">UBICACIÓN</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">IMAGEN EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">CODIGO EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">NOMBRE EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">FECHA FALLO EQUIPO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">FECHA REPORTE</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">DESCRIPCIÓN</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">ESTADO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">PRIORIDAD</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">REPORTADO POR</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">COD REPORTE</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">PROGRAMAR</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">ESTADO PROGRAMADO</td>
                   <td style="vertical-align: middle;text-align: center;font-weight: bold;">REPORTAR</td>
                </tr>
                </thead>
                <tbody>   
                <?php 
                $i=0;
                
                while($arrayIntevencionEquipoxVigencia= mysql_fetch_assoc($conexionIntervencionEquipoxVigencia)){
                    $code=json_encode($arrayIntevencionEquipoxVigencia);
                    
               ?> 
                <tr>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Area'];?></td>
                    <td></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['HV_Equipo'];?></td>
                    <td></td>
                    
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Fecha_Fallo_Equipo'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Fecha_Reporte'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Descripcion'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Estado_Equipo'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Prioridad'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Nombre_Reporta'];?></td>
                    <td><?php echo $arrayIntevencionEquipoxVigencia['Cod_Reporte'];?></td>
                
                        
                        <?php
                    
                echo "<td><input type='checkbox' value='$code' name='check[]' style='width:90px;'></td>";
                
                
                // Control para especificar el estado de programacion de la intervencion
                //echo "<td>";
                
                //$queryVigenciaProgramacion="SELECT Fecha_Realizacion FROM programacion_intervencion WHERE Fecha_Realizacion<>'0000-00-00'";
                
                $queryMaxCodServicio="SELECT MAX(Cod_Servicio)FROM programacion_intervencion WHERE HV_Equipo='".$arrayIntevencionEquipoxVigencia['HV_Equipo']."'";
                $ConexionMaxCodServicio=mysql_query($queryMaxCodServicio, $con);
                
                while($arrayMaxCodServicio=mysql_fetch_array($ConexionMaxCodServicio)){
                    $codigoHVProgramacion=$arrayMaxCodServicio['MAX(Cod_Servicio)'];
                  }
                
                $queryEstadoProgramacion="SELECT Fecha_Realizacion FROM programacion_intervencion WHERE HV_Equipo='".$arrayIntevencionEquipoxVigencia['HV_Equipo']."' && Cod_Servicio='$codigoHVProgramacion'";
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
                        echo "<input type='hidden' value='".$arrayIntevencionEquipoxVigencia['HV_Equipo']."' name='codHVencidos'>";
                        echo "<input type='hidden' value='Mantenimiento correctivo' name='IntervencionVencida'>";
                        echo "<input type='hidden' value='$codigoHVProgramacion' name='Cod_Reporte_Falla'>";
                        echo "<td><button input='submit' id='botonirIntervencion' class='btn btn-primary'><span class='glyphicon glyphicon-wrench'></span></button></td>";
                    echo "</form>";
                }
                
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            
           ?>
        </div>
    </body>
</html>