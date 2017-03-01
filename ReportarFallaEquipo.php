<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Reportar Falla</title>
        <link rel="stylesheet" href="EstilosReporteFalla.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script src="buscarReporte.js"></script>
        <script src="Buscar_Proveedor.js"></script>
        <script src="BuscarReporteFalla.js"></script>
        <script src="EnviardatosModalSatisfaccion.js"></script>
        <script src="EvaluacionSatisfaccionUsuario.js"></script>
        <script>
            
            function ocultarReporteFalla(){
                document.getElementById("nohoja").value="";        
                document.getElementById("nombreequiporeporte").value="";        
                document.getElementById("Areareporte").value="";        
                var i=document.getElementById("Imagen_Del_Equipo");
                i.setAttribute("src","");
                document.getElementById("estadoActual").selectedIndex=0;
                document.getElementById("fechaFalla").value="";        
                document.getElementById("descripcion").value="";        
                document.getElementById("prioridad").selectedIndex=0;
    }
    
    function recargarPagina(){
        $("#cuerpo").load("ReportarFallaEquipo.php");
    }
    
        </script>
    </head>    
<body id="cuerpo">
    <?php
        session_start();
        include('./conexion.php');
        $con=  conectar();
        $time=  time();
        $fechahoy=date('Y-m-d',$time);
        //Esta es el id del campo Tipo Intervencion para que aplique el jquey cuando viene directamente desde
        // El ingreso o desde la edicion, o desde Vencidos...
        //$selectdata='selectdata';
        // Cuando desde Editar se va a reportar intervencion
        if(isset($_POST['codigoHojavida'])){
            $hojaVida=$_POST['codigoHojavida'];
            }
                
        // Cuando desde Vencidos se va a reportar Intervencion        
        if(isset($_POST['codHVencidos'])){
        $hojaVida=$_POST['codHVencidos'];
        $tipoIntervencionVencida=$_POST['IntervencionVencida'];
        $selectdata="";
        //$disabled="Disabled";
        $disabled="";
                
        }else{
                   $selectdata='selectdata';
                   $disabled="";
                }
                
                
//       $querySelectImagenEquipo="SELECT Ruta FROM imagenes_equipos WHERE No_HV='HV2'";         
//       $conexionSelectImagenEquipo=mysql_query($querySelectImagenEquipo, $con);        
//       
//       while($arraySelectImagenEquipo=mysql_fetch_array($conexionSelectImagenEquipo)){
//           $imagen=$arraySelectImagenEquipo['Ruta'];
//           
//       }
           
       //$imagen="ImagenEquipos/Buscar.jpg";
        ?>
        
    <!--<div id="contorno">-->
      
    <div id="franjaColores" style="margin: auto;">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
    </div>
    
    <div id="bordeBlanco">
        <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div>
   <?php
   // IDENTIFICA EL ESTADO DE LOS REPORTES DE FALLAS DE EQUIPOS REALIZADOS POR EL USUARIO.
   
   $queryEstadoEquiposFallasReportadas="SELECT 
	f.Cod_Reporte, 
	f.HV_Equipo, 
	f.Fecha_Reporte, 
	f.Fecha_Ejecutado, 
	IF(
		f.Fecha_Ejecutado = '0000-00-00', '', 
		'f.Fecha_Ejecutado'
	) AS Fecha_Solucion, 
	IF(
		f.Fecha_Ejecutado = '0000-00-00', 'Pendiente', 
		'Ejecutado'
	) AS Estado 
FROM 
	reporte_fallas_equipos AS f 
WHERE 
	f.Nombre_Reporta = '".$_SESSION['usuario']."'
        ORDER BY
        f.Cod_Reporte ASC";
   
   $conexionEstadoEquiposFallasReportadas=  mysql_query($queryEstadoEquiposFallasReportadas, $con);
   
   
  
   ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          ESTADO DE EJECUCIÓN<br/>MIS REPORTES REALIZADOS
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
      
          <script type="text/javascript">
                $(document).ready(function(){
                $("#EstadoIntervencionesReportadas").DataTable({
                    "searching": true,
                    "lengthChange": false,
                    "language":{
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "search": "Buscar",
                    "emptyTable": "No existen fallas reportadas",
            }
                });
            });
            </script>
        
    <table id="EstadoIntervencionesReportadas" class="table" style="width: 95%;margin: auto;">
        <thead>
        <tr style="text-align: center;font-weight: bold;font-size: 10px;width: 100%;">
            <td style="width: 10px;">No REPORTE</td>
            <td>HV EQUIPO</td>
            <td>FECHA REPORTE</td>
            <td>FECHA EJECUCIÓN</td>
            <td>ESTADO EJECUCIÓN</td>
        </tr>
        </thead>
        <tbody>
        <?php
        while($arrayEstadoEquiposFallasReportadas=mysql_fetch_array($conexionEstadoEquiposFallasReportadas)){
            ?>
                <tr>
                <td>
                    <button id="btnReporteFallaRealizado" type="button" value="<?php echo $arrayEstadoEquiposFallasReportadas['Cod_Reporte']; ?>" onmouseover="mostrarReporteFalla(this.value);" onmouseout="ocultarReporteFalla()">
                        <?php echo $arrayEstadoEquiposFallasReportadas['Cod_Reporte']; ?>
                    </button>
                </td>
                    <td><?php echo $arrayEstadoEquiposFallasReportadas['HV_Equipo']; ?></td>
                    <td><?php echo $arrayEstadoEquiposFallasReportadas['Fecha_Reporte'];?></td>
                    <td><?php echo $arrayEstadoEquiposFallasReportadas['Fecha_Ejecutado'];?></td> 
                <td>
                    <?php
                    $codigoReporte=$arrayEstadoEquiposFallasReportadas['Cod_Reporte'];
                    ?>
                    <form method="POST" action="EncuestaSatisfaccionUsuarioProveedor.php" id="FormularioDatosEncuesta">
                    <input type="hidden" value="<?php echo $codigoReporte; ?>" name="CodReporte">
                    </form>   
                <?php
                    $queryEvaluacionSatisfaccionCompleta="SELECT 
                                                                    COUNT(Cod_Reporte) AS Cuenta 
                                                            FROM 
                                                                    encuestasatisfaccionfallareportada
                                                            WHERE 
                                                                    Cod_Reporte='".$arrayEstadoEquiposFallasReportadas['Cod_Reporte']."'";
                    
                    $conexionEvaluacionSatisfaccionCompleta=mysql_query($queryEvaluacionSatisfaccionCompleta, $con);
                    while($arraySatisfaccionCompleta=mysql_fetch_array($conexionEvaluacionSatisfaccionCompleta)){
                        $cantPreguntasEncuestaGrabadas=$arraySatisfaccionCompleta['Cuenta'];
                        }
                    
                echo $arrayEstadoEquiposFallasReportadas['Estado'];
                if($arrayEstadoEquiposFallasReportadas['Estado']=='Pendiente'){
                    echo "<span class='glyphicon glyphicon-remove' style='color:red;'></span>";
                    
                }else if($cantPreguntasEncuestaGrabadas!=4){ 
                    // sentencia para identificar datos que se incluyen en la encuesta de satisfacción
   
  $queryIdentificaDatosIntervencionEncuesta="SELECT 
                                                    Nombre_Proveedor, 
                                                    Nombre_Tecnico, 
                                                    Nombre_Recibe_Trabajo 
                                            FROM 
                                                    reportes_intervencion 
                                            WHERE 
                                                    Cod_Reporte_Falla = '".$arrayEstadoEquiposFallasReportadas['Cod_Reporte']."' && Tipo_Intervencion='Mantenimiento correctivo'"; 
 
  $conexionIdentificaDatosIntervencionEncuesta=mysql_query($queryIdentificaDatosIntervencionEncuesta, $con);
  
  while($arrayIdentificaDatosIntervencionEncuesta=mysql_fetch_array($conexionIdentificaDatosIntervencionEncuesta)){
      $proveedorEncuesta=$arrayIdentificaDatosIntervencionEncuesta['Nombre_Proveedor'];
      $tecnicoEncuesta=$arrayIdentificaDatosIntervencionEncuesta['Nombre_Tecnico'];
      $recibidoPorEncuesta=$arrayIdentificaDatosIntervencionEncuesta['Nombre_Recibe_Trabajo'];
  }
                    $p='"'.$proveedorEncuesta.'"';
                    $T='"'.$tecnicoEncuesta.'"';
                    $y=$T;
                    $x=$p;
                    $r='"Falla equipo"';
                    echo "<span class='glyphicon glyphicon-ok' style='color:green;'></span>"; 
                    echo "<button type='button' class='btn btn-defauld btn-sm' data-toggle='modal' data-target='#myModal' name='btnModal' id='btnModal' value='$codigoReporte' onclick='trarDatos(this.value);traerCodReporteGuardar(this.value,$x,$y,$r);'>";
                    echo "<span class='glyphicon glyphicon-list-alt' style='color:red;'></span>";
                    echo "</button>";
                }else{
                    echo "<div style='display:inline-block'>";
                    echo "<span class='glyphicon glyphicon-ok' style='color:green;'></span>";
                    echo "<span class='glyphicon glyphicon-ok' style='color:green;'></span>";
                    echo "</div>";
                }
                            ?>
                    </form>
                </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
      </div>
    </div>
  </div>
  </div>
        
    </div>
    
    <div id="contenedorFormulario">
    <div class="page-header" id="encabezadoinicio">
        <a href='Menu.php' style='float: right;margin-right: 30px;width: 200px;margin-top: -20px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        <h2 id="titulo">REPORTE DE FALLA DEL EQUIPO</h2>
            <!--<div style="float:right;">-->
     
    <!--</div>-->
    </div>
        
        <form id="formularioReporte" method="POST">
            
            <div class="form-group" id="contenedorCodigoHv">
                <div class="glyphicon glyphicon-search"></div>
                <label>No HOJA DE VIDA</label>
                <input type="text" id="nohoja" name="nohoja" class="form-control" onkeyup="buscarReporte(this.value);" onfocus="buscarReporte(this.value);" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>
                <!--<input type="text" name="nohoja" class="form-control"onchange="buscarReporte(this.value);" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>-->
            </div>
                        
            <div class="form-group" id="contenedornombreEquipo">
                <label>NOMBRE DEL EQUIPO</label>
                <input type="text" id="nombreequiporeporte" class="form-control" placeholder="" disabled>
            </div>
                        
            <div class="form-group" id="contenedorArea">
                <label>AREA</label>
                <input type="text" id="Areareporte" class="form-control" placeholder="" disabled>
            </div>
            
            <?php
                            
                            $querySelectMaxCodReporte="SELECT MAX(Cod_Reporte) FROM reporte_fallas_equipos WHERE 1";
                            $conexionSelectMaxReporte=mysql_query($querySelectMaxCodReporte, $con);
                            
                            while($arraySelectMaxReporte=  mysql_fetch_array($conexionSelectMaxReporte)){
                                $maxCodReporte=$arraySelectMaxReporte['MAX(Cod_Reporte)'];
                            }
                            $nuevoCodigoReporte=$maxCodReporte+1;
                        ?>    
                        <h2 id="lblCodReporte">Cod Reporte:<?php echo $nuevoCodigoReporte; ?></h2>
                
            <div id="imgenResponsive">
                
            <div id="contenedorImagenEquipo">            
            <div alt='...' class='img-thumbnail' id="imagen">
                    
                <img src="./images/EquipoSinImagen/no_image.png" id="Imagen_Del_Equipo" class="img-responsive" alt=" ">
                        <input type="hidden" value="<?php echo $nuevoCodigoReporte; ?>" name="Noreporte">    
            </div>
            </div>
                
            </div>
            </br>
            <div class="form-group" id="contenedorEstadoActual">
                <label>ESTADO ACTUAL</label>
   
                <select name='Estado' id='estadoActual' class='form-control'>
                    <option value='1'>--Seleccione--</option>
                    <option value='Fuera de uso'>Fuera de uso</option>
                    <option value='Bajo rendimiento'>Bajo rendimiento</option>
                </select>
            </div>
                    
            <div class="form-group" id="contenedorFechaEquipo">
                <label>FECHA FALLA EQUIPO</label>
                <input type="date" id="fechaFalla" name="FechaFallaEquipo" class="form-control" value="<?php echo $fechahoy ?>">
            </div>
                    
            <div class="form-group" id="contenedorPrioridaAtencion">
                <label>PRIORIDAD DE ATENCIÓN</label>
                <select name='Prioridad' id='prioridad' class='form-control'>
                        <option value='1'>--Seleccione--</option>
                        <option value='Alta'>Alta</option>
                        <option value='Media'>Media</option>
                        <option value='Baja'>Baja</option>
                </select>
            </div>  
        <div class="form-group" id="contenedorNombreReporta">
            <label>REPORTADO POR</label>
            <input type="text" id="nombreReporta" name="nombreReporta" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" placeholder="<?php echo $_SESSION['usuario']; ?>">
        </div>
                <div class="form-group" id="ContenedorDescripcion">
                      <label>DESCRIPCIÓN DEL EVENTO</label>
                      <!--<input type="date" id="fechaFalla" name="FechaFallaEquipo" class="form-control" value="<?php echo $fechahoy ?>">-->
                <textarea id="descripcion" class="form-control" name="descripcion" rows="5"></textarea>
                <br/>
                <button type="submit" name='enviarReporte' id="btnEnviarReporte" class="btn btn-primary">Enviar reporte</button>
                </div>
            </form>
         </div>  
        <!--</div> fin contorno-->
        
<!--        <form method="POST" action="Menu.php" id="formularioRegresar">
            
        </form>-->
        
        <?php
        
        // ENVIAR EL REPORTE AL ADMINISTRADOR
        if(isset($_POST['enviarReporte'])){

            $HV=$_POST['nohoja'];
        
            
            // Verificar que el codigo Exista
            
            $queryVerificarExisteCodigo="SELECT No_HV FROM hoja_vida WHERE No_HV='$HV'";
            $conexionVerificarExisteCodigo=mysql_query($queryVerificarExisteCodigo, $con);
            
            while($arrayVerificarExisteCodigo=mysql_fetch_array($conexionVerificarExisteCodigo)){
                $HVExiste=$arrayVerificarExisteCodigo['No_HV'];
               }
               
            $queryEquipoReportado="SELECT HV_Equipo FROM reporte_fallas_equipos WHERE HV_Equipo='$HV' && Fecha_Ejecutado='0000-00-00'";
            $conexionEquipoReportado=mysql_query($queryEquipoReportado, $con);
            
            while($arrayEquipoReportado=mysql_fetch_array(($conexionEquipoReportado))){
                
                $CodigoEncontrado=$arrayEquipoReportado['HV_Equipo'];
            }   
                
            if($HVExiste==""){
                ?>

            <script>
                alert("El equipo no existe");
            </script>            
                <?php
                }else if($HVExiste!="" && $CodigoEncontrado!=""){
                ?>

            <script>
                alert("Equipo ya reportado");
            </script>            
                <?php
                
            }else if($HVExiste!="" && $CodigoEncontrado!=$HV){
            
            $hv=$_POST['nohoja'];    
            $estado=$_POST['Estado'];   
            $descripcion=$_POST['descripcion'];
            $FechaFalla=$_POST['FechaFallaEquipo'];  
            $Prioridad=$_POST['Prioridad'];   
            $NombreReporta=$_POST['nombreReporta'];
            $codReporte=$_POST['Noreporte'];
            $AnioFallaEquipo=date("Y",  strtotime($FechaFalla));    
            $MesFallaEquipo=date("M",  strtotime($FechaFalla));    
                
            $queryInsertarReporteFalla="INSERT INTO reporte_fallas_equipos (HV_Equipo,Estado_Equipo,Descripcion,Fecha_Reporte,Fecha_Fallo_Equipo,Nombre_Reporta,Prioridad,Cod_Reporte,Fecha_Ejecutado,Anio_Reporte,Mes_Reporte) VALUES ('$HVExiste','$estado','$descripcion','$fechahoy','$FechaFalla','$NombreReporta','$Prioridad','$codReporte','0000-00-00','$AnioFallaEquipo','$MesFallaEquipo')";
            $conexionReportarFalla=mysql_query($queryInsertarReporteFalla, $con);
            
            if(isset($conexionReportarFalla)){
               ?> 
                <script>
                    //window.location.href = "MensajeEnvioExitosoFallaEquipo.html";
                
    
    
                    if(confirm("FALLA REPORTADA EXITOSAMENTE,\n DESEA REPORTAR OTRA FALLA!!")){
                        $("#cuerpo").load("ReportarFallaEquipo.php");
                    }else{
                        location.href="Menu.php"; 
                    }
                
                </script>
        
               <?php
            }else{
                ?>
                <script>
                    alert("Fallas en la conexion");
                </script>
                <?php
            }
            }
            }
        ?>
                
                <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="myModalLabel" style="font-weight: bold;">ENCUESTA DE SATISFACCIÓN DE ATENCIÓN DEL SERVICIO</h4>
      </div>
        <div class="modal-body" id="cuerpoModalCompleto" style="">
          
          <div id="encuestaCompleta" style="font-size: 35px;text-align: center;font-weight: bold;color: white"></div>
          <!--  Esta variable es cuando se graba en el formulario -->
           
          <input type="hidden" value="" name="codigoReporte" id="codigoReporteModal">  
          <script>
            function traerCodReporteGuardar(c,r,t,s){
              x=c;
              p=r;
              l=t;
              i=s;
            }
          </script>
         
          <table id="TablaEncuesta">
              <tr>
                  <td></td>
                  <!--<td style="font-size: 23px;font-weight: bold;">RESPUESTA</td>-->
              <td></td>
              <td></td>
              <td></td>
              </tr>
              <tr style="display: inline-block;">
                  <td style="font-size: 20px;width: 400px;">-Oportunidad en la reparación
                  <td id="respuesta1" style="width: 30px;color: royalblue"></td>    
                  <td style="padding: 5px;"><button id="excelente1" type="button" onclick="PrimerPregunta(this.value,x,p,l,i);" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno1" type="button" onclick="PrimerPregunta(this.value,x,p,l,i);" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio1" type="button" onclick="PrimerPregunta(this.value,x,p,l,i);" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Reparación resuelta eficaz</td>
                  <td id="respuesta2" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i);" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i);" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i);" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Actitud del técnico</td>
                  <td id="respuesta3" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente3" type="button" onclick="TercerPregunta(this.value,x,p,l,i);" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno3" type="button" onclick="TercerPregunta(this.value,x,p,l,i);" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio3" type="button" onclick="TercerPregunta(this.value,x,p,l,i);" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Competencia del tecnico</td>
                  <td id="respuesta4" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i);" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i);" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i);" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
          </table>
      </div>
      <div class="modal-footer">
          <div style="text-align: center;">
          <span class="glyphicon glyphicon-ok" style="color: green;padding: 5px;"></span><label>Satisfactorio (5).</label>    
          <span class="glyphicon glyphicon-minus" style="color: orange;padding: 5px;"></span><label>Regular (3).</label>
          <span class="glyphicon glyphicon-remove" style="color: red;padding: 5px;"></span><label>Insatisfactorio (1).</label>
          <button id="bntCerrar" style="display:none;" type="submit" class="btn btn-default" data-dismiss="modal" onclick="recargarPagina()">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
      </div>
    </div>
  </div>
</div
                
                
    </body>
</html>