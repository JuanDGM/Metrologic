<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Orden Intervencion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosOrdenProveedor.css">
        <script src="jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="EliminarEquipoOrden.js"></script>
        <script>
            $(document).ready(function(){
                
                $("#editar").click(function(){
                    $("#btnNombreProveedorNoEditable").attr("style","display: none");
                    $("#btnNombreProveedor").attr("style","display: block;width: 250px;");
                    $("#btnFechaSolicitudNoEditable").attr("style","display: none");
                    $("#btnFechaSolicitud").attr("style","display: block;width: 180px;");
                    $("#btnFechaProgramadaNoEditable").attr("style","display: none");
                    $("#btnFechaProgramada").attr("style","display: block;width: 180px;");
                    $("#btnObservacionNoEditable").attr("style","display: none");
                    $("#btnObservacion").attr("style","display: block;width: 700px;");
                    $("#campoClickEliminar").attr("style","display: block;");
                    $(".btnEliminar").attr("style","display: block;");
                    $("#campoClickReportar").attr("style","display: none;");
                    $(".botonesReporte").attr("style","display: none;");
                    $("#Guardar").attr("style","display: inline;");
                    $("#pdf").attr("style","display: none;width: 120px;");
                });
            });
            
            function GuardarCambios(){
//                $("#formularioEdicion").submit();
                    $("#btnNombreProveedorNoEditable").attr("style","display: block");
                    $("#btnNombreProveedor").attr("style","display: none;width: 250px;");
                    $("#btnFechaSolicitudNoEditable").attr("style","display: block");
                    $("#btnFechaSolicitud").attr("style","display: none;width: 180px;");
                    $("#btnFechaProgramadaNoEditable").attr("style","display: block");
                    $("#btnFechaProgramada").attr("style","display: none;width: 180px;");
                    $("#btnObservacionNoEditable").attr("style","display: block");
                    $("#btnObservacion").attr("style","display: none;width: 700px;");
                    $("#campoClickEliminar").attr("style","display: none;");
                    $(".btnEliminar").attr("style","display: none;");
                    $("#campoClickReportar").attr("style","display: block;");
                    $(".botonesReporte").attr("style","display: block;");
                    $("#Guardar").attr("style","display: none;");
                    $("#pdf").attr("style","display: inline;width: 120px;");
            }
            
            $("#botonirIntervencion").click(function(){
            $("#formularioirIntervencion").submit();    
        });
            
        </script>
    </head>
    <body id="cuerpo">
        
        <div id="franjaColores" style="margin-top:0px;">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        
        <!--<span id="resp"></span>-->
    <?php
        include('./conexion.php');
        
        $con= conectar();

        $time=  time();
        $fecharegistro=date("Y-m-d", $time);
        
        echo "<div style='float:right;margin-right:30px;width:200px;'>";
        include('./regresar.php');
        Regresar();
        echo "</div>";
        // vienes desde DetalleEstadoVigente.php con la creación una orden de trabajo 
        if(isset($_POST['enviarcheck'])){
        
        $nProveedor=$_POST['nombreProveedor'];
        $numeroOrden=$_POST['noOrden'];
        $fSolicitud=$_POST['fechasolicitud'];
        $fProgramada=$_POST['fechaprogramada'];
        $Observacion=$_POST['observacion'];
        
         if(isset($_POST['check'])!=""){   
            
             if(is_array($_POST['check'])){
                 
             while(list($key,$value)=each($_POST['check'])){
                    $d= json_decode($value);
                    $codigoOrden=$numeroOrden;
                    $hvquipo=$d->No_HV;
                    $VersionOrden=1;
                    $versionIntervencion=$d->Version_Intervencion;
                    if(isset($versionIntervencion)){
                    $versionIntervencion1=$d->Version_Intervencion+1;
                    }else{
                     $versionIntervencion1=1;   
                    }
                    $TipoSolicitud=$d->Tipo_Intervencion;
                    $FechaSolicitud=$fSolicitud;
                    $echaProgramada=$fProgramada;
                    $nombreProveedor=$nProveedor;
                    $fechaSistema=$fecharegistro;
               
                    // sentencia para asegurar que una programacion no se repita
                 $queryVerificarCodOrden="SELECT HV_Equipo FROM programacion_intervencion WHERE HV_Equipo='$hvquipo' && Cod_Servicio='$codigoOrden' && Tipo_Intervencion='$TipoSolicitud' && Fecha_Programada='$echaProgramada'";   
                 $conexionVerificarOrden=mysql_query($queryVerificarCodOrden, $con);   
                    
                 while($arrayVerificarOrden=mysql_fetch_array($conexionVerificarOrden)){
                     
                     $ExisteReporte=$arrayVerificarOrden['HV_Equipo'];
                 }
                 
                 // insertar la programacion
                 if(isset($ExisteReporte)==""){
                      $queryInsertarOrden="INSERT INTO programacion_intervencion (Cod_Servicio,HV_Equipo,Version_Programacion,Version_Intervencion,Tipo_Intervencion,Fecha_Solicitud,Fecha_Programada,Nombre_Proveedor,Observacion,Fecha_Sistema,Fecha_Realizacion,Estado) VALUES ('$codigoOrden','$hvquipo','$VersionOrden','$versionIntervencion1','$TipoSolicitud','$FechaSolicitud','$echaProgramada','$nombreProveedor','$Observacion','$fechaSistema','0000-00-00','Pendiente')";
                        mysql_query($queryInsertarOrden, $con);  
                  }
                }    
               }
             }
           } 
        
           // Viene desde DetalleEstadoVigente.php, cuando se da click en el numero de orden
           
           
           if(isset($_GET['id'])){
           $codigoOrden=$_GET['id'];
           $queryDetalleOrden="SELECT DISTINCT Nombre_Proveedor,Observacion,Fecha_Solicitud,Fecha_Programada FROM programacion_intervencion WHERE Cod_Servicio='$codigoOrden'";
           $conexionDetalleOrden=mysql_query($queryDetalleOrden, $con);
           
           while($arrayDetalleOrden=mysql_fetch_array($conexionDetalleOrden)){
               
               $nombreProveedor=$arrayDetalleOrden['Nombre_Proveedor'];
               $Observacion=$arrayDetalleOrden['Observacion'];
               $fSolicitud=$arrayDetalleOrden['Fecha_Solicitud'];
               $fProgramada=$arrayDetalleOrden['Fecha_Programada'];
               }
           
               $querySeleccionarOrden="SELECT HV_Equipo,Tipo_Intervencion FROM programacion_intervencion WHERE Cod_Servicio='$codigoOrden'";
               $conexionSeleccionarOrden=mysql_query($querySeleccionarOrden, $con);
               
               while($arraySeleccionarOrden=mysql_fetch_array($conexionSeleccionarOrden)){
                   $hvquipo=$arraySeleccionarOrden['HV_Equipo'];
                   //echo $arraySeleccionarOrden['Tipo_Intervencion'];
               }
            }
            
            // viene desde BuscadorOrdenesTrabajo.php
            
            if(isset($_GET['id'])){
           $codigoOrden=$_GET['id'];
           $queryDetalleOrden="SELECT DISTINCT Nombre_Proveedor,Observacion,Fecha_Solicitud,Fecha_Programada FROM programacion_intervencion WHERE Cod_Servicio='$codigoOrden'";
           $conexionDetalleOrden=mysql_query($queryDetalleOrden, $con);
           
           while($arrayDetalleOrden=mysql_fetch_array($conexionDetalleOrden)){
               
               $nombreProveedor=$arrayDetalleOrden['Nombre_Proveedor'];
               $Observacion=$arrayDetalleOrden['Observacion'];
               $fSolicitud=$arrayDetalleOrden['Fecha_Solicitud'];
               $fProgramada=$arrayDetalleOrden['Fecha_Programada'];
               }
           
               $querySeleccionarOrden="SELECT HV_Equipo,Tipo_Intervencion FROM programacion_intervencion WHERE Cod_Servicio='$codigoOrden'";
               $conexionSeleccionarOrden=mysql_query($querySeleccionarOrden, $con);
               
               while($arraySeleccionarOrden=mysql_fetch_array($conexionSeleccionarOrden)){
                   $hvquipo=$arraySeleccionarOrden['HV_Equipo'];
                   //echo $arraySeleccionarOrden['Tipo_Intervencion'];
               }
            }
           
            ?>
        <br/>
        <br/>
        
            <div style="display: inline" id="displayBotones">
                <!--<form>-->
                    
                <button id="editar" type="button" class="btn btn-info">Editar</button>
                    
                <button id="Guardar" type="button" onclick="GuardarCambios();" class="btn btn-success" style="display: none;">Guardar</button>
                    
                <!--</form>-->
                <!--<img src="images/GenerarPDF.jpg" style="width: 120px;" id="pdf">-->
                <a href="OrdenPDF.php?id=<?php echo $codigoOrden; ?>"><img src="images/GenerarPDF.jpg" style="width: 120px;" id="pdf"></a>
            </div>
            <div class="container">
                <h1 id="titulo" style="text-align: center;font-weight: bold;">ORDEN DE SERVICIO INTERVENCION A EQUIPOS</h1>
            
                <br/>
                
                <div id="CantenedorTablaOrdenador">
                <form method="POST" action="#" id="formularioEdicion">
                    <table>
                <tr>
                    <td style="width: 300px;">NOMBRE PROVEDOR:</td>
                    <td id="btnNombreProveedorNoEditable" style="display: block"><?php if(isset($nombreProveedor)){echo $nombreProveedor;} ?></td>
                    <td id="btnNombreProveedor" style="display: none"><input type="text" class="form-control" value="<?php echo $nombreProveedor; ?>" placeholder=" <?php echo $nombreProveedor ?>"></td>
                    <!--<td style="width: 200px;"></td>-->
                    <td style="width:00px;"></td>
                    <td id="CeldaNoOrden">No ORDEN: </td>
                    <td style="width: 10px;"><strong><?php if(isset($codigoOrden)){echo $codigoOrden;}else{ echo "No seleccionó equipos";}?></strong></td>
                </tr>
                <tr>
                    <td>FECHA SOLICITUD:</td>
                    <td id="btnFechaSolicitudNoEditable" style="display: block;width: 200px;"><?php if(isset($hvquipo) && isset($fSolicitud)){echo $fSolicitud;} ?></td>
                    <td id="btnFechaSolicitud" style="display: none"><input type="date" class="form-control" value="<?php echo $fSolicitud; ?>" placeholder=""></td>
                </tr>
                <tr>
                    <td>FECHA ESPERADA EJECUCIÓN:</td>
                    <td id="btnFechaProgramadaNoEditable" style="display: block;"><?php if(isset($codigoOrden) && isset($fProgramada)){echo $fProgramada;} ?></td>
                    <td id="btnFechaProgramada" style="display: none"><input type="date" class="form-control" value="<?php echo $fProgramada; ?>" placeholder="<?php echo $fProgramada; ?>"></td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td id="btnObservacionNoEditable" style="display: block;width: 700px;"><?php if(isset($codigoOrden) && isset($Observacion)){echo $Observacion;} ?></td>
                    <td colspan="4" ><textarea id="btnObservacion"style="display:none" class="form-control" rows="3" value="<?php echo $Observacion; ?>"><?php echo $Observacion; ?></textarea></td>
                </tr>
                
            </table>
                </form>
                
                <br/>
                <br/>
                <h3 style="text-align: center;border: #eee 1px solid;margin: 0px;padding: 5px;">EQUIPOS A INTERVENIR</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>UBICACIÓN</td>
                            <td>COD EQUIPO</td>
                            <td>NOMBRE EQUIPO</td>
                            <td>TIPO INTERVENCION</td>
                            <td>FECHA PRESUPUESTADA</td>
                            <td>FECHA EJECUCIÓN</td>
                            <td>ESTADO</td>
                            <td id="campoClickEliminar" style="display:none;">Click eliminar intervención</td>
                            <td id="campoClickReportar">Click reportar intervención</td>
                        </tr>
                    </thead>
            <?php
           
           if(isset($hvquipo)){
               
           $queryMaxVersionIntervencion="SELECT MAX(Version) FROM puesta_marcha WHERE No_HV='$hvquipo'";
           $conexionMaxVersionIntervencion=mysql_query($queryMaxVersionIntervencion, $con);        
            
           while($arrayMaxVersionIntervencion=mysql_fetch_array($conexionMaxVersionIntervencion)){
           $versionUbicacion=$arrayMaxVersionIntervencion['MAX(Version)'];
           } 
            
           $queryMostrarOrden="SELECT p.Area,i.HV_Equipo, i.Tipo_Intervencion,h.Nombre_Equipo,i.Fecha_Programada,i.Fecha_Realizacion FROM programacion_intervencion as i JOIN puesta_marcha as p ON p.No_HV=i.HV_Equipo JOIN hoja_vida as h ON i.HV_Equipo=h.No_HV WHERE Cod_Servicio='$codigoOrden' && p.Version='$versionUbicacion'";
           $conexionQueryOrden=mysql_query($queryMostrarOrden, $con);        
            
           $i=0;
           while($arrayMostrarOrden=mysql_fetch_array($conexionQueryOrden)){
               $i++;
               
               echo "<tbody>";
               
               echo "<tr id='fila$i'>";
               echo "<form method='POST' id='formulario$i'>";
               echo "<td>".$arrayMostrarOrden['Area']."</td>";
               echo "<td>".$arrayMostrarOrden['HV_Equipo']."</td>";
               echo "<td>".$arrayMostrarOrden['Nombre_Equipo']."</td>";
               echo "<td>".$arrayMostrarOrden['Tipo_Intervencion']."</td>";
               echo "<td>".$arrayMostrarOrden['Fecha_Programada']."</td>";
               
               if(isset($arrayMostrarOrden['Fecha_Realizacion']) && $arrayMostrarOrden['Fecha_Realizacion']=="0000-00-00"){
                   $Fecha_Realizacion="";
                   
               }else{
                   $Fecha_Realizacion=$arrayMostrarOrden['Fecha_Realizacion'];
               }
               
               echo "<td>".$Fecha_Realizacion."</td>";
               
               
               if($Fecha_Realizacion==""){
                   
                   $Estado="<label style='color:red'>Pendiente</label>";
                   $ocultarbtn="display:block";
               }else{
                   $Estado="<label style='color:green'>Ejecutado</label>";
                   $ocultarbtn="display:none";
               }
               
               echo "<td>".$Estado."</td>";
               
              echo "<input type='hidden' value='".$arrayMostrarOrden['Area']."' name='area'>";
              echo "<input type='hidden' value='".$arrayMostrarOrden['HV_Equipo']."' name='hv'>";
              echo "<input type='hidden' value='".$arrayMostrarOrden['Nombre_Equipo']."' name='nombreequipo'>";
              echo "<input type='hidden' value='".$arrayMostrarOrden['Tipo_Intervencion']."' name='tipointervencion'>";
              echo "<input type='hidden' value='$codigoOrden' name='NoOrden'>";
              //echo "<input type='hidden' value='$i' name='NoOrden'>";
               
              
               echo "<td class='btnEliminar' style='display:none;'>";
              echo "<button type='submit' class='btn btn-danger' value='$i' onclick='EliminarIntervencionOrden(this.value);' style='$ocultarbtn;'>";
              echo "<div class='glyphicon glyphicon-remove'></div>";
             echo "</td>";
               echo "</form>";
               
               // Lleva a diligenciar el reporte
               echo "<td  style='display:none;'>";
                    echo "<form method='POST' id='formularioirIntervencion' action='reporteIntervencion.php'>";
                        echo "<input type='hidden' value='".$arrayMostrarOrden['HV_Equipo']."' name='codHVencidos'>";
                        echo "<input type='hidden' value='".$arrayMostrarOrden['Tipo_Intervencion']."' name='IntervencionVencida'>";
                        echo "<input type='hidden' value='".$codigoOrden."' name='codigoOrden'>";
                        echo "<td class='botonesReporte'><button input='submit' id='botonirIntervencion' class='btn btn-primary' style='$ocultarbtn'><span class='glyphicon glyphicon-wrench'></span></button></td>";
                    echo "</form>";
               echo "</td>";
               echo "</tr>";
               
           echo "</tbody>";
               }
               }
            ?>
            </table>
                
                <br/>
                <br/>
                
                <p>SOLICITUD REALIZADA POR:<strong><u><?php echo $_SESSION['usuario']; ?></u></strong></p>
                <br/>
                <br/>
            </div>
        </div>
            
            <!--DISPLAY PARA MOVIL-->
            
            <div id="DisplayTablaMovil">
                
                <form method="POST" action="#" id="formularioEdicion">
                    <table class="table table-bordered">
                <tr>
                    <td id="CeldaNoOrden">No ORDEN: </td>
                    <td style="width: 10px;"><strong><?php echo $codigoOrden;?></strong></td>
                </tr>
                <tr>
                    <td>NOMBRE PROVEDOR:</td>
                    <td id="btnNombreProveedorNoEditable" style="display: block"><?php echo $nombreProveedor; ?></td>
                    <td id="btnNombreProveedor" style="display: none"><input type="text" class="form-control" value="<?php echo $nombreProveedor; ?>" placeholder=" <?php echo $nombreProveedor ?>"></td>
                </tr>    
                
                <tr>
                    <td>FECHA SOLICITUD:</td>
                    <td id="btnFechaSolicitudNoEditable" style="display: block;width: 80px;"><?php echo $fSolicitud; ?></td>
                    <td id="btnFechaSolicitud" style="display: none"><input type="date" class="form-control" value="<?php echo $fSolicitud; ?>" placeholder=""></td>
                </tr>
                <tr>
                    <td>FECHA ESPERADA EJECUCIÓN:</td>
                    <td id="btnFechaProgramadaNoEditable" style="display: block"><?php echo $fProgramada; ?></td>
                    <td id="btnFechaProgramada" style="display: none"><input type="date" class="form-control" value="<?php echo $fProgramada; ?>" placeholder="echo $fProgramada"></td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td id="btnObservacionNoEditable" style="display: block"></td>
                    <td colspan="4" id="btnObservacion" style="display: none"><textarea class="form-control" rows="3" value="<?php echo $nombreProveedor; ?>" placeholder=" <?php echo $nombreProveedor ?>"></textarea></td>
                </tr>
                
            </table>
                </form>
              
                
        <?php 
        
        
        if(isset($_GET['id'])){
           $codigoOrden=$_GET['id'];
           $queryDetalleOrden="SELECT p.Nombre_Proveedor,p.Fecha_Solicitud,p.Fecha_Programada, p.Cod_Servicio, p.HV_Equipo, p.Tipo_Intervencion,p.Fecha_Realizacion,h.Nombre_Equipo FROM programacion_intervencion as p JOIN hoja_vida as h ON p.HV_Equipo=h.No_HV WHERE Cod_Servicio='$codigoOrden'";
           $conexionDetalleOrden=mysql_query($queryDetalleOrden, $con);
           
           
           echo "<div class='list-group'>";
           while($arrayDetalleOrden=mysql_fetch_array($conexionDetalleOrden)){
               
               $nombreProveedor=$arrayDetalleOrden['Nombre_Proveedor'];
               $fSolicitud=$arrayDetalleOrden['Fecha_Solicitud'];
               $fProgramada=$arrayDetalleOrden['Fecha_Programada'];
               $CodEquipo=$arrayDetalleOrden['HV_Equipo'];
               $TipoIntervencion=$arrayDetalleOrden['Tipo_Intervencion'];
               $NombreEquipo=$arrayDetalleOrden['Nombre_Equipo'];
               
               if($arrayDetalleOrden['Fecha_Realizacion']=="0000-00-00"){
                   $FechaRealizado="Pendiente";
               }else{
                   $FechaRealizado=$arrayDetalleOrden['Fecha_Realizacion'];
               }
               
               
           
                   echo "<a href='#' class='list-group-item'>";
        echo "<h5 class='list-group-item-heading'>Cod equipo:<strong>".$CodEquipo."</strong> INTERVENCIÓN: <strong>".$TipoIntervencion."</strong></h5>";
        echo "<p class='list-group-item-text'><label>Nombre: </label>".$NombreEquipo."<label>Ubicacion</label>Bio</p>";    
        echo "<p class='list-group-item-text'><label>Estado: </label><label>".$FechaRealizado."</label></p>";    
        echo "</a>";
                   
               }
              echo "</div>";
            }

        ?>        
            </div>    
        </body>
</html>