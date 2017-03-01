<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Reporte Falla</title>
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="EstilosReporteFalla.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="buscarReporte.js"></script>
        <script src="Buscar_Proveedor.js"></script>
    </head>    
    <body>
        <?php
        session_start();
        include('./conexion.php');
        include('./regresar.php');
        $con=  conectar();
        Regresar();
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
        
    <div class="page-header" id="encabezadoinicio" style="color: white;">
            <h1 id="titulo"><span class="glyphicon glyphicon-wrench"></span> REPORTE DE FALLA DEL EQUIPO<small></small></h1>
    </div>
    
    <form style="padding: 20px" id="formularioReporte" method="POST">
        <div id="Fila1"><!-- primer fila  -->
                            
            <div id="Primeros3btn">
            
            
            <div class="form-group" id="contenedorCodigoHv">
                <div class="glyphicon glyphicon-search"></div>
                <label>No HOJA DE VIDA</label>
                <input type="text" id="nohoja" name="nohoja" class="form-control" onkeyup="buscarReporte(this.value);" onfocus="buscarReporte(this.value);" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>
                <!--<input type="text" name="nohoja" class="form-control"onchange="buscarReporte(this.value);" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>-->
            </div>
                        
            <div class="form-group" id="contenedornombreEquipo">
                <label>NOMBRE DEL EQUIPO</label>
                <input type="text" id="nombreequiporeporte"  class="form-control" placeholder="" disabled>
            </div>
                        
            <div class="form-group" id="contenedorArea">
                <label>AREA</label>
                <input type="text" id="Areareporte" class="form-control" placeholder="" disabled>
            </div>
            
                </div>
            
            <br/>
            <br/>
            
            <div id="imgenResponsive" style="margin:0 auto;">
                
            <div id="contenedorImagenEquipo">            
            <div alt='...' class='img-thumbnail' id="imagen">
                <img src="" id="Imagen_Del_Equipo" class="img-responsive" alt="No tiene imagen">
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
        
                        <input type="hidden" value="<?php echo $nuevoCodigoReporte; ?>" name="Noreporte">    
            </div>
            </div>
                        
    </div>  <!-- Primer fila pantalla laptop -->        
                            
    <div id="Fila2">
            <div class="form-group" id="contenedorEstadoActual">
                <label>ESTADO ACTUAL</label>

                <select name='Estado' id='estadoActual' class='form-control'>

                    <option value='Fuera de uso'>--Seleccione--</option>
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
                         
    </div><!-- Fin fila 2 -->
              
                              
               <div id="Fila3">                
                <div class="form-group" id="ContenedorDescripcion">
                      <label>DESCRIPCIÓN DEL EVENTO</label>
                      <!--<input type="date" id="fechaFalla" name="FechaFallaEquipo" class="form-control" value="<?php echo $fechahoy ?>">-->
                <textarea id="descripcion" class="form-control" name="descripcion" rows="3"></textarea>
                </div>
                </div>
                                
                
                <div id="Fila4">
                    <button type="submit" name='enviarReporte' class="btn btn-danger" style="margin-right: 20px;">Enviar reporte</button>
                </div>
            </form>
           
        <!--</div> fin contorno-->
        
<!--        <form method="POST" action="Menu.php" id="formularioRegresar">
            
        </form>-->
        
        <?php
        
        // ENVIAR EL REPORTE AL ADMINISTRADOR
        if(isset($_POST['enviarReporte'])){

            $HV=$_POST['nohoja'];
            
            $queryEquipoReportado="SELECT HV_Equipo FROM reporte_fallas_equipos WHERE HV_Equipo='$HV' && Fecha_Ejecutado='0000-00-00'";
            $conexionEquipoReportado=mysql_query($queryEquipoReportado, $con);
            
            while($arrayEquipoReportado=mysql_fetch_array(($conexionEquipoReportado))){
                
                $CodigoEncontrado=$arrayEquipoReportado['HV_Equipo'];
            }
            
            if($HV!=$CodigoEncontrado){
            
            $hv=$_POST['nohoja'];    
            $estado=$_POST['Estado'];   
            $descripcion=$_POST['descripcion'];
            $FechaFalla=$_POST['FechaFallaEquipo'];  
            $Prioridad=$_POST['Prioridad'];   
            $NombreReporta=$_POST['nombreReporta'];
            $codReporte=$_POST['Noreporte'];
          
        // Verificar que el codigo Exista
            
            $queryVerificarExisteCodigo="SELECT No_HV FROM hoja_vida WHERE No_HV='$hv'";
            $conexionVerificarExisteCodigo=mysql_query($queryVerificarExisteCodigo, $con);
            
            while($arrayVerificarExisteCodigo=mysql_fetch_array($conexionVerificarExisteCodigo)){
                $HVExiste=$arrayVerificarExisteCodigo['No_HV'];
               }
            if(isset($HVExiste) && $HVExiste==$hv){
            
            $queryVerificarReportePendiente="SELECT 
	HV_Equipo, 
	Cod_Reporte 
FROM 
	reporte_Fallas_Equipos 
WHERE 
	BINARY HV_Equipo = '$hv' && Fecha_Ejecutado = '0000-00-00'";
            $conexionVerificarReportePendiente=mysql_query($queryVerificarReportePendiente, $con);
            
            while($arrayReportePendiente=mysql_fetch_array($conexionVerificarReportePendiente)){
                $HVReportadaPendiente=$arrayReportePendiente['HV_Equipo'];
                $arrayReportePendiente['Cod_Reporte'];
            }
            
            if($HVReportadaPendiente==$hv){
                ?>
                <script>
                   alert("Equipo ya reportado");
                </script>
                <?php
            }else{
                
            
            $queryInsertarReporteFalla="INSERT INTO reporte_fallas_equipos (HV_Equipo,Estado_Equipo,Descripcion,Fecha_Reporte,Fecha_Fallo_Equipo,Nombre_Reporta,Prioridad,Cod_Reporte,Fecha_Ejecutado) VALUES ('$hv','$estado','$descripcion','$fechahoy','$FechaFalla','$NombreReporta','$Prioridad','$codReporte','0000-00-00')";
            $conexionReportarFalla=mysql_query($queryInsertarReporteFalla, $con);
            
            if(isset($conexionReportarFalla)){
               ?> 
                <script>
                    window.location.href = "MensajeEnvioExitosoFallaEquipo.html";
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
            }else{
                ?>
                <script>
                    alert("Codigo de Equipo No existe");
                </script>
                <?php
            }    
        }else{
            ?>
                <script>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Warning!</strong> Better check yourself, you're not looking too good.
                    </div>
                </script>    
            <?php
        }
        }
        ?>
    </body>
</html>