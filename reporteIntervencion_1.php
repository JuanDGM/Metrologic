<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reporte Intervencion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosReporteIntervencion.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="buscarReporte.js"></script>
        <script src="Buscar_Proveedor.js"></script>
        <script src="GuardarReporte.js"></script>
        <script src="descargarReportesIntervencion.js"></script>
        <script src="GuardarArchivosIntervencion.js"></script>
        <script src="BuscarImagenEquipoReporteIntervencion.js"></script>
        <script>
            $(document).ready(function(){
                $("#barraExpancion").click(function(){
                    $("#documentosAdjuntos").toggle();
                });
            });
        </script>
    </head>    
    <body id="cuerpo">
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        <?php
        include('./conexion.php');
        include('./regresar.php');
        $con=  conectar();
        session_start();
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
                
        // Cuando desde Vencidos se va a reportar Intervencion (detalleEstadoVigente.php)       
        if(isset($_POST['codHVencidos'])){
        $hojaVida=$_POST['codHVencidos'];
        $tipoIntervencionVencida=$_POST['IntervencionVencida'];
        
        if(isset($_POST['CodHVProgramado'])){
        $ProveedorProgramado=$_POST['CodHVProgramado'];
        }else if(isset($_POST['codigoOrden'])){
            
        $ProveedorProgramado=$_POST['codigoOrden'];    
        }
        
        $selectdata="";
        //$disabled="Disabled";
        $disabled="";
                
        }else{
                   $selectdata='selectdata';
                   $disabled="";
                }
        ?>
        
        <div id="resp"></div>
        
    <div id="contorno">
        <div class="page-header" id="encabezado">
            <h1 id="titulo"><span class="glyphicon glyphicon-wrench"></span> REPORTE DE INTERVENCION AL EQUIPO<small></small></h1>
        </div>
        <form style="padding: 20px" id="formularioReporte" method="POST" class="form-group">
            <div id="Elemento1">
                    <div class="form-group" id="contenedorCodHv">
                        <label>No HOJA DE VIDA <div class="glyphicon glyphicon-search"></div></label>
                        <input type="text" id="nohoja" name="nohoja" class="form-control" onkeyup="buscarReporte(this.value);buscarImagenEquipo(this.value)" onfocus="buscarReporte(this.value);buscarImagenEquipo(this.value)" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>
                        <!--<input type="text" name="nohoja" class="form-control"onchange="buscarReporte(this.value);" value="<?php if(isset($hojaVida)){ echo $hojaVida;}   ?>" placeholder="" autofocus>-->
                    </div>
                    <div class="form-group" id="contenedorNombreEquipo">
                        <label>NOMBRE DEL EQUIPO</label>
                        <input type="text" id="nombreequiporeporte"  class="form-control" placeholder="" disabled>
                    </div>
                    <div class="form-group" id="contenedorArea">
                        <label>AREA</label>
                        <input type="text" id="Areareporte" class="form-control" placeholder="" disabled>
                    </div>
                </div>
            <div id="Elemento2">
                            <?php
                            $querySelectMaxIntervencion="SELECT MAX(No_Intervencion) FROM reportes_intervencion WHERE 1";
                            $conexionSelectMaxIntervencion=mysql_query($querySelectMaxIntervencion, $con);
                            
                            while($arraySelectMaxIntervencion=  mysql_fetch_array($conexionSelectMaxIntervencion)){
                                $maxCodIntervencion=$arraySelectMaxIntervencion['MAX(No_Intervencion)'];
                            }
                            $nuevoCodigoIntervencion=$maxCodIntervencion+1;
                        ?>    
                            <p id="etiquetaCodigoEquipo">No Intervención:<?php echo $nuevoCodigoIntervencion; ?></p>
                            <input type="hidden" value="<?php echo $nuevoCodigoIntervencion; ?>" name="NoIntervencion">
                            <img id="ImagenEquipo" src="./images/archivo.jpg">
            </div>                 
            <div id="Elemento3">                
                            
                        <div class="form-group">
                            <label>INTERVENCIÓN</label>
                            <?php
                            echo "<select id='$selectdata' style='width:200px;' name='intervencion' class='form-control' $disabled>";
                                if(isset($tipoIntervencionVencida) && $tipoIntervencionVencida!=""){ 
                                    echo "<option value='$tipoIntervencionVencida'>".$tipoIntervencionVencida."</option>";
                                    }
                            echo "</select>";
                             ?>
                        </div>
            
                           
                        <div class="form-group" id="contenedorFechaIntervencion">
                            <label>FECHA INTERVENCIÓN</label>
                            <input type="date" name="FechaIntervencion" id="FechaIntervencion" class="form-control" value="<?php echo $fechahoy;?>">
                        </div>
                               
                            <?php
                            // desde DetalleEstadoVigente.php
                            
                            if(isset($ProveedorProgramado)){
                                
                               $np=$ProveedorProgramado;
                               $queryNombreProveedorProgramado="SELECT DISTINCT
                                                                        Nombre_Proveedor 
                                                                FROM 
                                                                        programacion_intervencion 
                                                                WHERE 
                                                                        Cod_Servicio='$np'";

                          $conexionNombreProveedorProgramado=mysql_query($queryNombreProveedorProgramado, $con);
                          while($arrayNombreProveedorProgramado=mysql_fetch_array($conexionNombreProveedorProgramado)){
                                    $nproveedor=$arrayNombreProveedorProgramado['Nombre_Proveedor'];
                               }
                            }else{
                                    $nproveedor=""; 
                            }
                            ?>
                
                        <div class="form-group">
                            <label>NOMBRE PROVEEDOR</label>
                            <input type="text" name="nombreproveedor" id="nombreproveedor" class="form-control" value="<?php if(isset($nproveedor)){echo $nproveedor;} ?>" placeholder="<?php if(isset($nproveedor)){echo $nproveedor;} ?>">
                        </div>
                    
                        <div class="form-group" id="contenedorNombreTecnico">
                            <label>NOMBRE DEL TÉCNICO</label>
                            <input type="text" name="tecnico" id="tecnico" class="form-control" placeholder="">
                        </div>
                    
                    
                        <div class="form-inline" >
                            <label>ESTADO DEL EQUIPO</label>
                            <select name="estadointervencion" class="form-control" id="ListaEstadoEquipo">
                                <option value="Intervencion efectiva">Intervencion efectiva</option>
                                <option value="Equipo fuera de uso">Equipo fuera de uso</option>
                           </select>
                        </div>
                    
                 <div class="form-group" id="contenedorNombreRecibe">
                            <label>NOMBRE RECIBE</label>
                            <input type="text" name="nombrerecibe" id="tecnico" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" placeholder="<?php $_SESSION['usuario']; ?>">
                        </div>
                
            </div>    
                
            <div id="panel1" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            ADJUNTAR DOCUMENTOS
                                        </a>
                                    </h4>
                                </div>
                                
            
            
                <div id="documentosAdjuntos" class="panel-collapse collapse"> 
            
            <div class="caja">
                    <?php

                    $queryMostrarDocumento="SELECT * FROM documentos_intervencion WHERE 1";
                    $conexionMostrarDocumento=mysql_query($queryMostrarDocumento, $con);
                    
                    $i=1;
                    while($f=mysql_fetch_array($conexionMostrarDocumento)){
                        
                        $i++;
                        //echo $f['No_HV'];
                        //echo $f['Tipo_Intervencion'];
                        //echo $f['Nombre_Archivo'];
                        //echo "<img src='".$f['Nombre_Archivo']."'>";
                      
                    
                        echo "<form method='POST' id='formularioDescargarArchivo' enctype='multipart/form-data'>";
                //<!--<input type="file" name="descargar">-->
                        echo "<input type='hidden' name='position' value='$i'>";    
                        echo "<input type='hidden' name='archivo' value='".$f['Nombre_Archivo']."'>";    
                        echo "<input type='submit' onclick='descargarReporte();' value='".$f['Nombre_Archivo']."'>";
                        echo "</form>";
                    }
                    ?>
        </div>
            
                <div class="form-inline" style="margin: 5px;">
                <input type="file" multiple="multiple" id="archivos" name="reporte">
                <input type="button" id="guardarDocumentosIntervencion" value="Guardar documento">
                </div>
                <br/>
                <div class="mensajeAdjunto"></div>
            
        </div>        
                </div>
                
                <div class="form-group">
                    <label>DETALLE DEL REPORTE</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                </div>
            
                
               <!--<button type="button" class="btn btn-primary" style="margin-right: 20px;">Agregar categoria</button>--> 
                
                
                <br/>
                <div style="display: inline;">
                    
                <button type="submit" class="btn btn-danger" onclick="guardarReporte();" style="margin-right: 20px;">Guardar</button>
                
            
                
        </div>
           </form>
        </div>
                
        <!-- Adjuntar archivo -->
        
        
        <?php
        
       //$formatosPermitidos=array('jpg','png','doc','xlsx','pptx');
        
        
        
//       if(isset($_POST['Guardar_archivo'])){
//           $directorio='./Reportes_Adjunto/';
//           //@opendir($directorio);
//           $nombreArchivo=$_FILES['reporte']['name'];
//           $destinoArchivo=$directorio.$_FILES['reporte']['name'];
//           $nombreTemporalArchivo=$_FILES['reporte']['tmp_name'];
//           //$ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
//           move_uploaded_file($nombreTemporalArchivo,$destinoArchivo);               
//       
//           $queryInsertarDocumento="INSERT INTO documentos_intervencion VALUES ('','HV 1','Calibracion','$destinoArchivo')";
//           mysql_query($queryInsertarDocumento, $con);
//           
//       }  
        
        ?>
        
    </body>
    
</html>