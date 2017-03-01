<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ficha Equipo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosHojaVida.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="validacionHv.js"></script>
        <script src="crearhvajax.js"></script>   
        <script src="editarHV.js"></script>   
        <script src="cargarImagenEquipo.js"></script>   
        <script src="asignarCodigo.js"></script>
        <script src="SeleccionUbicacionEquipos.js"></script>
        <!--<script src="SeleccionSenalizacionRiesgos.js"></script>-->
        <!--<script src="GuardarRiesgos.js"></script>-->
        <!--<script src="ProgramarIntervencionEspecifica.js"></script>-->
        <script type="text/javascript">
        
        function editar(){
            // Habilita los campos cuando se requiere editar la HV             
            //$("#nohoja").removeAttr("disabled");
            $("#tipoequipo").removeAttr("disabled");
            $("#nombreequipo").removeAttr("disabled");
            $("#nombreproveedor").removeAttr("disabled");
            $("#modelo").removeAttr("disabled");
            $("#serie").removeAttr("disabled");
            $("#marca").removeAttr("disabled");
            $("#voltaje").removeAttr("disabled");
            $("#amperaje").removeAttr("disabled");
            $("#potencia").removeAttr("disabled");
            $("#caracteristicas").removeAttr("disabled");
            $("#razonSocialProveedor").removeAttr("disabled");
            $("#nitProveedor").removeAttr("disabled");
            $("#CiudadProveedor").removeAttr("disabled");
            $("#Direccion").removeAttr("disabled");
            $("#telefono").removeAttr("disabled");
            $("#celular").removeAttr("disabled");
            $("#registroInvima").removeAttr("disabled");
            $("#inversion").removeAttr("disabled");
            $("#edadEquipo").removeAttr("disabled");
            $("#VidaContable").removeAttr("disabled");
            $("#dispSoporteRepuestos").removeAttr("disabled");
            $("#DispoSoporteConsumibles").removeAttr("disabled");
            $("#DispoSoporteRepuestos").removeAttr("disabled");
            $("#CiudadUbicacion").removeAttr("disabled");
            $("#txtSede").removeAttr("disabled");
            $("#txtArea").removeAttr("disabled");
            $("#fecha_marcha").removeAttr("disabled");
            $("#fecha_descarte").removeAttr("disabled");
            $("#f_manto").removeAttr("disabled");
            $("#f_verificacion").removeAttr("disabled");
            $("#f_calibracion").removeAttr("disabled");
            $("#f_calificacion").removeAttr("disabled");
            $("#f_otro").removeAttr("disabled");
            $("#otro_cual").removeAttr("disabled");
            $("#inicioIntervencionManto").removeAttr("disabled");
            $("#inicioIntervencionVerificacion").removeAttr("disabled");
            $("#inicioIntervencionCalibracion").removeAttr("disabled");
            $("#inicioIntervencionCalificacion").removeAttr("disabled");
            $("#inicioIntervencionOtro").removeAttr("disabled");
            $("#dispSoporteRepuestos").removeAttr("disabled");
            $("#DispoSoporteConsumibles").removeAttr("disabled");
            $("#DispoSoporteRepuestos").removeAttr("disabled");
            $("#invasividad").removeAttr("disabled");
            $("#equipoPorTipoRiesgo").removeAttr("disabled");
            };
            
        // Habilita los campos Cuando se abre la hoja de vida para crear HV
        function guardar(){
            $("#nohoja").removeAttr("readonly");
            $("#tipoequipo").removeAttr("disabled");
            $("#nombreequipo").removeAttr("disabled");
            $("#nombreproveedor").removeAttr("disabled");
            $("#modelo").removeAttr("disabled");
            $("#serie").removeAttr("disabled");
            $("#marca").removeAttr("disabled");
            $("#voltaje").removeAttr("disabled");
            $("#amperaje").removeAttr("disabled");
            $("#potencia").removeAttr("disabled");
            $("#caracteristicas").removeAttr("disabled");
            $("#razonSocialProveedor").removeAttr("disabled");
            $("#nitProveedor").removeAttr("disabled");
            $("#CiudadProveedor").removeAttr("disabled");
            $("#Direccion").removeAttr("disabled");
            $("#telefono").removeAttr("disabled");
            $("#celular").removeAttr("disabled");
            $("#registroInvima").removeAttr("disabled");
            $("#inversion").removeAttr("disabled");
            $("#edadEquipo").removeAttr("disabled");
            $("#VidaContable").removeAttr("disabled");
            $("#dispSoporteRepuestos").removeAttr("disabled");
            $("#DispoSoporteConsumibles").removeAttr("disabled");
            $("#DispoSoporteRepuestos").removeAttr("disabled");
            $("#CiudadUbicacion").removeAttr("disabled");
            $("#txtSede").removeAttr("disabled");
            $("#txtArea").removeAttr("disabled");
            $("#fecha_marcha").removeAttr("disabled");
            $("#fecha_descarte").removeAttr("disabled");
            $("#f_manto").removeAttr("disabled");
            $("#f_verificacion").removeAttr("disabled");
            $("#f_calibracion").removeAttr("disabled");
            $("#f_calificacion").removeAttr("disabled");
            $("#f_otro").removeAttr("disabled");
            $("#otro_cual").removeAttr("disabled");
            $("#inicioIntervencionManto").removeAttr("disabled");
            $("#inicioIntervencionVerificacion").removeAttr("disabled");
            $("#inicioIntervencionCalibracion").removeAttr("disabled");
            $("#inicioIntervencionCalificacion").removeAttr("disabled");
            $("#inicioIntervencionOtro").removeAttr("disabled");
            $("#dispSoporteRepuestos").removeAttr("disabled");
            $("#DispoSoporteConsumibles").removeAttr("disabled");
            $("#DispoSoporteRepuestos").removeAttr("disabled");
            $("#invasividad").removeAttr("disabled");
            $("#equipoPorTipoRiesgo").removeAttr("disabled");
            }
        
        function enviarFormularioReporte(){
        $("#FormularioCodHV").submit();
        }
        $(document).ready(function(){
        $("#barraExpancion1").click(function(){
        $("#collapseOne").toggle();
        });
        $("#barraExpancion2").click(function(){
        $("#collapseTwo").toggle();
        });
        $("#barraExpancion3").click(function(){
        $("#collapseThree").toggle();
        });
        $("#barraExpancion4").click(function(){
        $("#collapseFour").toggle();
        });
        $("#barraExpancion5").click(function(){
        $("#collapseFive").toggle();
        });
        $("#barraExpancion6").click(function(){
        $("#collapseSix").toggle();
        });
        $("#barraExpancion7").click(function(){
        $("#collapseSeven").toggle();
        });
//        $("#barraExpancion8").click(function(){
//        $("#collapseEight").toggle();
//        });
        });
                
            $(document).ready(function()
            {
             var x= $("#nohoja").val();
              
              //$("#contornoHV").html(alert(x));
              
              if(x==""){
        
        $("#myModal").modal("show");
              }
    });
            
     // Funcion para desplegar cada barra de datos       
      function desglegarFormulario(){
          
        $("#collapseOne").attr("class","panel-collapse collapse in");
        $("#collapseTwo").attr("class","panel-collapse collapse in");
        $("#collapseThree").attr("class","panel-collapse collapse in");
        $("#collapseFour").attr("class","panel-collapse collapse in");
        $("#collapseFive").attr("class","panel-collapse collapse in");
        $("#collapseSix").attr("class","panel-collapse collapse in");
        $("#collapseSeven").attr("class","panel-collapse collapse in");
        //$("#collapseEight").attr("class","panel-collapse collapse in");
        $("#desplegar").attr("style","display:none");
        $("#contraer").attr("style","display:block;cursor: pointer;");
    }
      
      function contraerFormulario(){
          
        // if( $(".panel panel-default").hasClass("panel-collapse collapse in"){
          
        $("#collapseOne").attr("class","panel-collapse collapse");
        $("#collapseTwo").attr("class","panel-collapse collapse");
        $("#collapseThree").attr("class","panel-collapse collapse");
        $("#collapseFour").attr("class","panel-collapse collapse");
        $("#collapseFive").attr("class","panel-collapse collapse");
        $("#collapseSix").attr("class","panel-collapse collapse");
        $("#collapseSeven").attr("class","panel-collapse collapse");
        //$("#collapseEight").attr("class","panel-collapse collapse");
        $("#desplegar").attr("style","display:block;cursor: pointer;");
        $("#contraer").attr("style","display:none");
        //});
       
    }
    
    
    // Funcion para programacion especifica de intervenciones metrologicas
    
    
//    function TipoProgramacionManto(t){
//        var respuesta=t;
//        
//        if(respuesta=="Fecha especifica"){
//            
//            $("#displayFrecuenciaManto").attr("style","display:none");
//            $("#displayFechaEspecificaManto").attr("style","display:block");
//            
//        }else{
//            $("#displayFrecuenciaManto").attr("style","display:block");
//            $("#displayFechaEspecificaManto").attr("style","display:none");
//            
//        }
//        
//        
//        
//        
//    }
    
    
    // boton para crear riesgos
    
//    $(document).ready(function(){
//           
//        $("#btnRiesgos").click(function(){
//            
//            $("#displayAgregarRiesgos").toggle();
//            
//        });
//        
//    });
    
    
    
    
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
        require_once './conexion.php';    
        $con=  conectar();
        require_once './regresar.php';
        crearHojavida();
        
        
// FORMATO DE HOJA DE VIDA.
        function crearHojavida() {
            ?>
        <div class="page-header" id="encabezado">
                    <div style="float:left">
                        <h1 id="titulo" style="font-weight: bold;margin-left: 30px;">HOJA DE VIDA DEL EQUIPO</h1>
                    </div>
                    <div style="float: right;margin-right: 30px;width: 200px;">
                        <?php
                            Regresar();
                        ?>
                    </div>
        </div>
        <div id="contornoHV">
            <?php
            function FormularioModal(){
                       $con=  conectar();
                   $queryTipoEquipos="SELECT Tipo_Equipo FROM tipo_equipo";
                    $conexionTipoEquipo=mysql_query($queryTipoEquipos, $con);
            ?>    
<form method="POST" action="hojaVida.php" id="formularioAsignacionCodigo">
        <div id="margen">
              <table>   
                <tr>
                    <td>TIPO EQUIPO</td>
                    <td>
                        <select class="form-control" name="seleccionTipoEquipo" id="listaTipoEquipos" onchange="proponerCodigoEquipo(this.value);">    
                <option>-- Seleccione --</option>
                <?php
                
                    while($arrayTipoEquipo=mysql_fetch_array($conexionTipoEquipo)){
                ?>
                            <option value="<?php echo $arrayTipoEquipo['Tipo_Equipo']; ?>"><?php echo $arrayTipoEquipo['Tipo_Equipo']; ?></option>
                        
                <?php
                    }
                ?>
                     </select>   
                    </td>
                <tr>
                    <td>CÓDIGO ASIGNADO</td>
                    <td>
                        <div id="txtAsignado">
                            <!-- Viene de asignarCodigo.js -->
                            <input type="text" id="inputModificar" class="form-control" name="CodHVEnviado" readonly>
                        </div>
                    </td>
                </tr>
                <tr style="height: 10px;">
                    
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" id="btnCrear" name="CrearEquipo" class="btn btn-primary">Crear</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </td>
                
                </tr>
            </table>
        </div>
        
        </form>



        <?php
            }
                // traer el valor de codigo de hoja de vida asignado, para almacenar cuando se guarde la imagen
                if(isset($_POST['CrearEquipo'])){
                $codigoHojaVida=$_POST['CodHVEnviado'];
                }
                $con=  conectar();
                $querySeleccionarPerfilUsuario="SELECT 
                                                Tipo_Usuario 
                                        FROM 
                                                usuarios_creados 
                                        WHERE 
                                                Usuario = '".$_SESSION['usuario']."'";
        
        $conexionSeleccionarPerfilUsuario=mysql_query($querySeleccionarPerfilUsuario, $con);
        
        while($ArraySeleccionarPerfilUsuario=mysql_fetch_array($conexionSeleccionarPerfilUsuario)){
            $tipoDeUsuario=$ArraySeleccionarPerfilUsuario['Tipo_Usuario'];
            }
                
            if($tipoDeUsuario=="Consulta"){
                $displayBtnGuardarImagen="display:none";
            }else{
                $displayBtnGuardarImagen="display:block";
            }
            
                ?>
            <form method="POST" id="formularioImagenesEquipos" enctype="multipart/form-data" style="<?php echo $displayBtnGuardarImagen;  ?>">
                <!--<input type="file" multiple="multiple" id="archivosSeleccionados" style="margin: 5px">-->
                <input type="file" id="archivosSeleccionados" name="archivo" style="margin: 5px;display: block;">
                <!--<input type="hidden" id="codigoHojaVida" name="cdhv" value="HV 123" style="margin: 5px">-->
                
                <!--<button input="submit" id="enviar" style="margin: 5px">Guardar Imagen</button>-->
                </form>
            <form id="formulariohv" method="POST">
              
                    <span id="resp"></span>
                    <?php
                        // INICIO CONTROLADOR PARA MOSTRAR BOTONES Y EQUIPO BUSCADO
                        if(isset($_POST['desdebuscador']) || isset($_POST['desInventario'])){
                       $con=  conectar();
                        ?>
                    <script type="text/javascript">
                        function editar1(){
                            addEventListener("click",editar,false);
                    }
                    </script>
                    <!--  Controlador para colocar atributo disabled -->    
                    <?php
                        $querySeleccionarPerfilUsuario="SELECT 
                                                Tipo_Usuario 
                                        FROM 
                                                usuarios_creados 
                                        WHERE 
                                                Usuario = '".$_SESSION['usuario']."'";
        
        $conexionSeleccionarPerfilUsuario=mysql_query($querySeleccionarPerfilUsuario, $con);
        
        while($ArraySeleccionarPerfilUsuario=mysql_fetch_array($conexionSeleccionarPerfilUsuario)){
            $tipoDeUsuario=$ArraySeleccionarPerfilUsuario['Tipo_Usuario'];
            }
                    
                       if($tipoDeUsuario=="Consulta"){
                           
                        $idseleccionado=$_POST['idseleccionado1'];
                        $displaycrear="display: none";
                        $displayeditar="display: none";
                        $disabledHV="disabled";
                        $disabledOtros="disabled";
                        $displayHistorial="";
                            
                        }else{
                        $idseleccionado=$_POST['idseleccionado1'];
                        $displaycrear="display: none";
                        $displayeditar="display: block";
                        $disabledHV="disabled";
                        $disabledOtros="disabled";
                        $displayHistorial="";
                        }
                        
                        $queryequipobuscado="SELECT * FROM hoja_vida WHERE Id='$idseleccionado'";
                        $conexionequipobuscado= mysql_query($queryequipobuscado,$con);
                        //$i=0;
                        while($arrayequipobuscado=mysql_fetch_array($conexionequipobuscado)){
                            
                            $id=$arrayequipobuscado[0];
                            $codHV=$arrayequipobuscado[1];
                            $version=$arrayequipobuscado[2];
                            $TipoEquipo=$arrayequipobuscado[3];
                            $NombreEquipo=$arrayequipobuscado[4];
                            $NombreProveedor=$arrayequipobuscado[5];
                            $Modelo=$arrayequipobuscado[6];
                            $NoSerie=$arrayequipobuscado[7];
                            $Marca=$arrayequipobuscado[8];
                            $Voltaje=$arrayequipobuscado[9];
                            $Amperaje=$arrayequipobuscado[10];
                            $potencia=$arrayequipobuscado[11];
                            $caracteristicas=$arrayequipobuscado[12];
                            $RazonSocialProveedor= $arrayequipobuscado[13];
                            $nitProveedor= $arrayequipobuscado[14];
                            $CiudadProveedor= $arrayequipobuscado[15];
                            $DireccionProveedor= $arrayequipobuscado[16];
                            $telefonoProveedor= $arrayequipobuscado[17];
                            $CelularProveedor= $arrayequipobuscado[18];
                            $registroInvima= $arrayequipobuscado[19];
                            $inversion= $arrayequipobuscado[20];
                            $edadEquipo= $arrayequipobuscado[21];
                            $VidaContable= $arrayequipobuscado[22];
                            $dispSoporteRepuestos= $arrayequipobuscado[23];
                            $DispoSoporteConsumibles= $arrayequipobuscado[24];
                            $DispoSoporteTecnicoRepuestos= $arrayequipobuscado[25];
                            
                        }
                        
                        
                        if($dispSoporteRepuestos==""){
                            $dispSoporteRepuestosL="-- Seleccione --";
                        }else if($dispSoporteRepuestos==65){
                            $dispSoporteRepuestosL="Entre 5 y 7 años";
                        }else if($dispSoporteRepuestos==30){
                            $dispSoporteRepuestosL="Entre 5 y 7 años";
                        }else if($dispSoporteRepuestos==1){
                            $dispSoporteRepuestosL="Más 7 años";
                        }else if($dispSoporteRepuestos==100){
                            $dispSoporteRepuestosL="No tiene soporte de respuestos";
                        }
                           
                        
                        if($DispoSoporteConsumibles==""){
                            $DispoSoporteConsumiblesL="No requiere consumibles";
                        }else if($DispoSoporteConsumibles==100){
                            $DispoSoporteConsumiblesL="No tiene soporte de consumibles";
                        }else if($DispoSoporteConsumibles==65){
                            $DispoSoporteConsumiblesL="De 1 a 4 años";
                        }else if($DispoSoporteConsumibles==30){
                            $DispoSoporteConsumiblesL="De 5 a 7 años";
                        }else if($DispoSoporteConsumibles==1){
                            $DispoSoporteConsumiblesL="Mayor a 7 años";
                        }
                        
                        if($DispoSoporteTecnicoRepuestos==""){
                            $DispoSoporteTecnicoRepuestosL="-- Seleccione --";
                        }else if($DispoSoporteTecnicoRepuestos==1){
                            $DispoSoporteTecnicoRepuestosL="Con fábrica";
                        }else if($DispoSoporteTecnicoRepuestos==50){
                            $DispoSoporteTecnicoRepuestosL="Otro proveedor";
                        }else if($DispoSoporteTecnicoRepuestos==100){
                            $DispoSoporteTecnicoRepuestosL="No existe soporte técnico";
                        }
                        
                        
                        
                        // identificar la maxima version de ubicacion y puesta en marcha del equipo
                        
                        $queryMaxVersionUbicacion="SELECT MAX(Version) FROM puesta_marcha WHERE No_HV='$codHV'";
                        $ConexionVersionUbicacion=mysql_query($queryMaxVersionUbicacion, $con);
                        
                        while($arrayMaxVersionUbicacion=  mysql_fetch_array($ConexionVersionUbicacion)){
                            $MaxVersionUbicacion=$arrayMaxVersionUbicacion['MAX(Version)'];
                        }
                        
                        $queryequipobuscadoubicacion="SELECT Sede,Area,SubArea, Fecha_Marcha,Fecha_Descarte FROM puesta_marcha WHERE No_HV='$codHV' && Version='$MaxVersionUbicacion'";  
                        $conexionequipobuscadoUbicacion= mysql_query($queryequipobuscadoubicacion,$con);
                        
                        while($arrayequipobuscado=  mysql_fetch_array($conexionequipobuscadoUbicacion)){
                            $Sede=$arrayequipobuscado['Sede'];
                            $Area=$arrayequipobuscado['Area'];
                            $SubArea=$arrayequipobuscado['SubArea'];
                            $Fecha_Marcha=$arrayequipobuscado['Fecha_Marcha'];
                            $Fecha_Descarte=$arrayequipobuscado['Fecha_Descarte'];
                        }
                        
                        // maxima version de frecuencia de intervencion definida para el equipo
                        
                        $maxVersionFrecuenciaIntervencion="SELECT MAX(Version_Intervencion) FROM intervenciones WHERE HV_EQUIPO='$codHV' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $conexionMaximaVersionFrecuenciaIntervencion=mysql_query($maxVersionFrecuenciaIntervencion, $con); 
                        while($arrayMaxVersionIntervencion=  mysql_fetch_array($conexionMaximaVersionFrecuenciaIntervencion)){
                            $MaxVersionIntervencion=$arrayMaxVersionIntervencion['MAX(Version_Intervencion)'];
                        }
                        
                        $queryequipobuscadoPreventivo = "SELECT Frecuencia,Aplica_Desde FROM intervenciones as i WHERE i.HV_Equipo='$codHV' && i.Tipo_Intervencion='Mantenimiento preventivo' && Version_Intervencion='$MaxVersionIntervencion'";
                    
                        //$queryequipobuscadoPreventivo = "SELECT Frecuencia FROM intervenciones WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Mantenimiento preventivo'";
                        $queryequipobuscadoVerificacion = "SELECT Frecuencia,Aplica_Desde FROM intervenciones WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Verificacion'";
                        $queryequipobuscadoCalibracion = "SELECT Frecuencia,Aplica_Desde FROM intervenciones WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Calibracion'";
                        $queryequipobuscadoCalificacion = "SELECT Frecuencia,Aplica_Desde FROM intervenciones WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Calificacion'";
                        
                        $queryequipobuscadoOtro=
                        "SELECT 
                            Tipo_Intervencion, Frecuencia,Aplica_Desde 
                        FROM 
                            intervenciones 
                        WHERE 
                            HV_Equipo = '$codHV' && Tipo_Intervencion <> 'Mantenimiento preventivo' && Tipo_Intervencion <> 'Verificacion' && Tipo_Intervencion <> 'Calibracion' && Tipo_Intervencion <> 'Calificacion'";
                        
                        $conexionequipobuscadoPreventivo= mysql_query($queryequipobuscadoPreventivo,$con);
                        $conexionequipobuscadoVerificacion= mysql_query($queryequipobuscadoVerificacion,$con);
                        $conexionequipobuscadoCalibracion= mysql_query($queryequipobuscadoCalibracion,$con);
                        $conexionequipobuscadoCalificacion= mysql_query($queryequipobuscadoCalificacion,$con);
                        $conexionequipobuscadoOtro= mysql_query($queryequipobuscadoOtro,$con);
                        
                        while($arrayequipobuscadoPreventivo=  mysql_fetch_array($conexionequipobuscadoPreventivo)){
                            $mantoPreventivo= $arrayequipobuscadoPreventivo['Frecuencia'];
                            $DesdeMantoPreventivo= $arrayequipobuscadoPreventivo['Aplica_Desde'];
                            }
                        while($arrayequipobuscadoVerificacion=  mysql_fetch_array($conexionequipobuscadoVerificacion)){
                            $verificacion= $arrayequipobuscadoVerificacion['Frecuencia'];
                            $DesdeVerificacion= $arrayequipobuscadoVerificacion['Aplica_Desde'];
                        }
                        while($arrayequipobuscadoCalibracion=  mysql_fetch_array($conexionequipobuscadoCalibracion)){
                            $calibracion= $arrayequipobuscadoCalibracion['Frecuencia'];
                            $DesdeCalibracion= $arrayequipobuscadoCalibracion['Aplica_Desde'];
                            }
                        while($arrayequipobuscadoCalificacion=  mysql_fetch_array($conexionequipobuscadoCalificacion)){
                            $calificacion= $arrayequipobuscadoCalificacion['Frecuencia'];
                            $DesdeCalificacion= $arrayequipobuscadoCalificacion['Aplica_Desde'];
                            }
                        while($arrayequipobuscadoOtro=  mysql_fetch_array($conexionequipobuscadoOtro)){
                            $TipoOtro= $arrayequipobuscadoOtro['Tipo_Intervencion'];
                            $FrecuenciaOtro= $arrayequipobuscadoOtro['Frecuencia'];
                            $DesdeOtro= $arrayequipobuscadoOtro['Aplica_Desde'];
                            }
                           
                        } else {
                            $displaycrear="display: block";
                            $displayeditar="display: none";
                        ?>
                            <script>
                                $(document).ready(function(){
                                    guardar();
                                    });
                            </script>
                    <?php        
                        
                    
                        }
                        // FIN CONTROLADO MOSTRAR 
                       
                        
                        // VENTANA MODAL
                        ?>
                          
                        <!--<a data-toggle="modal" data-target="#myModal" href="#example" class="btn btn-primary btn-large">Abrir ventana modal</a>-->    
                        
                        
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" id="myModal">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                  <strong><h4 class="modal-title" style="margin: 0 auto;text-align: center;">ASIGNA EL CÓDIGO AUTOMATICO AL EQUIPO</h4></strong>
                                </div>
                                <div class="modal-body">
                                  <?php
                                        FormularioModal();    
                                    ?>
                                </div>
                                <div class="modal-footer">
                                </div>
                              </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
    
                          
                          
                          <div id="BotonesOcultarPerfilConsulta" style="display: inline-block;">
                              <div style="<?php echo $displaycrear; ?>">
                            <button type="submit" onclick="enviar()" class="btn btn-primary btn-sm">Crear</button>    
                            <button type="submit" class="btn btn-default btn-sm">Cancelar</button>    
                        </div>
                            
                              
                              
                        <div style="<?php echo $displayeditar; ?>">
                            <button type="button" id="editar" name="editar" onclick="editar1();" class="btn btn-primary btn-sm">Editar</button>    
                            <button type="submit" id="guardarcambios" onclick="guardarCambios();" class="btn btn-primary btn-sm">Guardar Cambios</button><!-- este boton remite a editarHV.js donde se ejecuta la funcion -->    
                            <a href="PDFhojaVida.php?id=<?php echo "$codHV"; ?>"><img src="images/GenerarPDF.jpg" style="width: 120px;" id="pdf"></a>
                            <button type="button" id="btnreporte" onclick="enviarFormularioReporte()" class="btn btn-primary btn-sm">Reportar Intervención</button>    
                            
                            <span id="respuesta"></span>
                        </div>
                          <div>
                          <span id="desplegar" style="display:block;cursor: pointer" class="glyphicon glyphicon-triangle-bottom" onclick="desglegarFormulario();"></span>
                          <span id="contraer" style="display:none;" class="glyphicon glyphicon-triangle-top" onclick="contraerFormulario();"></span>
                        </div>
                              </div>
                          <br/>    
                          <br/>    
                        <span id="respuesta"></span>
                        <div class="panel-group">
                            <div id="panel1" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" 
                                           >
                                            INFORMACIÓN GENERAL DEL EQUIPO
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body" id="contenedor1">
                                        <div id="contenedorImagen">
                                        
                                                
                                                     <?php  
                                                    
                                                    if(isset($codHV)){
                                                        
                                                        $codHV;
                                                    
                                                        $querySeleccionarImagenEquipo="SELECT Ruta FROM imagenes_equipos WHERE No_HV='$codHV'";
                                                        $conexionSeleccionarImagenEquipo=mysql_query($querySeleccionarImagenEquipo, $con);
                                                        
                                                        while($arraySeleccionarImagenEquipo=mysql_fetch_array($conexionSeleccionarImagenEquipo)){
                                                              $ruta=$arraySeleccionarImagenEquipo['Ruta'];
                                                        }
                                                        }
                                                    ?>
                                                    
                                                    
                                                    <span id="RecuadroImagenEquipo" alt='...' class='img-thumbnail'>
                                                        <?php if(isset($_POST['desdebuscador']) || isset($_POST['desInventario'])){
                                                        
                                                            if(isset($ruta)){
                                                            echo "<img id='imagen' src='$ruta'>";
                                                        
                                                            }else{
                                                                
                                                            echo "<img id='imagen' src=''>";    
                                                            }
                                                            
                                                            
                                                        }else{
                                                            
                                                            echo "<img id='imagen1' src='./images/EquipoSinImagen/no_image.png'>";
                                                            echo "<input type='hidden' name='nombreRuta' id='hiddenRutaIngresar' value=''>";
                                                            
                                                        } ?>
                                                    </span>      
                                            </div>                      
                                                <?php
                                                
                                                
                                                        // DESDE EL ASIGNADOR DE AsignacionCodigosEquipo.php
                        
                                                        if(isset($_POST['CrearEquipo'])){

                                                        $CodigoEquipo=$_POST['CodHVEnviado'];    
                                                        $tipoEquipo=$_POST['seleccionTipoEquipo'];    
                                                        }
                                                ?>
                                        <div id="RespuestaGuardarHV"></div>
                                        <div id="InformacionGeneral">        
                                                    <div id="campocodhv" class="form-group">
                                                        <label class="control-label" for="inputSuccess2">N° HOJA DE VIDA</label>
                                                        <input type="text" id="nohoja" name="nohoja" class="form-control" onkeyup="datoEntrada(this.value)" aria-describedby="inputSuccess2Status" value="<?php  if(isset($codHV)){echo $codHV;}else if(isset($CodigoEquipo)){ echo $CodigoEquipo;} ?>" readonly> <!-- readonly para hacer un inmodificable--> 
                                                        <span id="icon" class="" aria-hidden="true"></span>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="exampleInputName2">TIPO DE EQUIPO</label>
                                                        <input type="text" id="tipoequipo" name="tipoequipo" class="form-control" value="<?php  if(isset($TipoEquipo)){echo $TipoEquipo;}else if(isset($tipoEquipo)){echo $tipoEquipo;}  ?>" placeholder="" disabled> 
                                                    </div>
                                                    <div class="form-group"> 
                                                        <label for="exampleInputName2">NOMBRE DE EQUIPO</label>
                                                        <input type="text" id="nombreequipo" name="nombreequipo" class="form-control" value="<?php  if(isset($NombreEquipo)){echo $NombreEquipo;}  ?>" placeholder="" disabled> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName2">NOMBRE PROVEEDOR DEL EQUIPO</label>
                                                        <input type="text" id="nombreproveedor" name="nombreproveedor" class="form-control" value="<?php  if(isset($NombreProveedor)){echo $NombreProveedor;}  ?>" placeholder="" disabled> 
                                                    </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="panel2" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            ESPECIFICACIONES TÉCNICAS
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">

                                        <div class="row">  
                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">MODELO</label>
                                            <input type="text" id="modelo" name="modelo" class="form-control" id="exampleInputName2" value="<?php  if(isset($Modelo)){echo $Modelo;}  ?>" placeholder="" disabled>
                                        </div>

                                            
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">N° SERIE</label>
                                            <input type="text" id="serie" class="form-control" name="serie" id="exampleInputName2" value="<?php  if(isset($NoSerie)){echo $NoSerie;}  ?>" placeholder="" disabled>
                                        </div>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">MARCA</label>
                                            <input type="text" id="marca" class="form-control" name="marca" id="exampleInputEmail2" value="<?php  if(isset($Marca)){echo $Marca;}  ?>" placeholder="" disabled>

                                        </div>
                                      

                                   </div>

                                    <div class="row">

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">VOLTAJE</label>
                                            <input type="text" id="voltaje" class="form-control" name="voltaje" id="exampleInputName2" value="<?php  if(isset($Voltaje)){echo $Voltaje;}  ?>" placeholder="" disabled>
                                        </div>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">AMPERAJE</label>
                                            <input type="text" id="amperaje" class="form-control" name="amperaje" id="exampleInputName2" value="<?php  if(isset($Amperaje)){echo $Amperaje;}  ?>" placeholder="" disabled>
                                        </div>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">POTENCIA</label>
                                            <input type="text" id="potencia" class="form-control" name="potencia" id="exampleInputEmail2" value="<?php  if(isset($potencia)){echo $potencia;}  ?>" placeholder="" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 col-lg-12">
                                            <label id="labelTxtArea" for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">CARACTERISTICAS Y COMPONENTES DEL EQUIPO<br/></label>
                                            <textarea id="caracteristicas" name="caracteristicas" class="form-control" rows="5" value="<?php  if(isset($caracteristicas)){echo $caracteristicas;}?>" placeholder="" disabled><?php if(isset($caracteristicas)){echo $caracteristicas;}?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <!--Fin especificaciones tecnicas-->                            
                            
                        <div id="panel2" class="panel panel-default">
                                <div class="panel-heading" role="tab" id="barraExpancion7">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button">
                                            INFORMACIÓN DE LA COMPRA
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="panel-collapse collapse">
                                    <div class="panel-body">

                                        <div class="row">  
                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">RAZON SOCIAL DEL PROVEEDOR </label>
                                            <input type="text" name="razonSocialProveedor" class="form-control" id="razonSocialProveedor" value="<?php  if(isset($RazonSocialProveedor)){echo $RazonSocialProveedor;}  ?>" placeholder="" disabled>
                                        </div>
                                        <div class="form-group col-md-4 col-lg-4">

                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">NIT DEL PROVEEDOR</label>
                                            <input type="text" name="nitProveedor" class="form-control" id="nitProveedor" value="<?php  if(isset($nitProveedor)){echo $nitProveedor;}  ?>" placeholder="" disabled>
                                        </div>

                                            
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">CIUDAD</label>
                                            <input type="text" name="Ciudad" class="form-control" id="CiudadProveedor" value="<?php  if(isset($CiudadProveedor)){echo $CiudadProveedor;}  ?>" placeholder="" disabled>
                                        </div>

                                        
                                      

                                   </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DIRECCIÓN</label>
                                            <input type="text" name="Direccion" class="form-control" id="Direccion" value="<?php  if(isset($DireccionProveedor)){echo $DireccionProveedor;}  ?>" placeholder="" disabled>

                                        </div>
                                        
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">TELEFONO FIJO</label>
                                            <input type="text" name="telefono" class="form-control" id="telefono" value="<?php  if(isset($telefonoProveedor)){echo $telefonoProveedor;}  ?>" placeholder="" disabled>
                                        </div>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class=" col-sm-4 col-md-3 col-lg-12">CELULAR</label>
                                            <input type="text" name="celular" class="form-control" id="celular" value="<?php  if(isset($CelularProveedor)){echo $CelularProveedor;}  ?>" placeholder="" disabled>
                                        </div>

                                        </div>
                                        
                                        <div class="row">
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">NO REGISTRO INVIMA</label>
                                            <input type="text" name="registroInvima" class="form-control" id="registroInvima" value="<?php  if(isset($registroInvima)){echo $registroInvima;}  ?>" placeholder="" disabled>
                                        </div>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">VALOR INVERSIÓN EQUIPO</label>
                                            <input type="text" name="inversion" class="form-control" id="inversion" value="<?php  if(isset($inversion)){echo $inversion;}  ?>" placeholder="" disabled>
                                        </div>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">EDAD DEL EQUIPO</label>
                                            <input type="text" name="edadEquipo" class="form-control" id="edadEquipo" value="<?php  if(isset($edadEquipo)){echo $edadEquipo;}  ?>" placeholder="" disabled>
                                        </div>
                                            
                                    </div>
                                    
                                        <div class="row">
                                        
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">VIDA UTIL CONTABLE</label>
                                            <input type="text" name="VidaContable" class="form-control" id="VidaContable" value="<?php  if(isset($VidaContable)){echo $VidaContable;}  ?>" placeholder="" disabled>
                                        </div>
                                        
                                          <?php
                                            if(isset($dispSoporteRepuestosL)){
                                                $dispSoporteRepuestosL;
                                            }else{
                                                $dispSoporteRepuestosL="-- Seleccione --";
                                            }
                                          ?>  
                                            
                                            <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DISPONIBILIDAD DE SOPORTE DE REPUESTOS</label>
                                            <!--<input type="text" name="dispSoporteRepuestos" class="form-control" id="dispSoporteRepuestos" value="<?php // if(isset($dispSoporteRepuestos)){echo $dispSoporteRepuestos;}  ?>" placeholder="" disabled>-->
                                            <select class="form-control" name="dispSoporteRepuestos" id="dispSoporteRepuestos" disabled>
                                                
                                                <option value="<?php  if(isset($dispSoporteRepuestos)){echo $dispSoporteRepuestos;}  ?>"><?php  if(isset($dispSoporteRepuestosL)){echo $dispSoporteRepuestosL;}  ?></option>
                                                <option value="">-- Seleccione --</option>
                                                <option value="65">Entre 1 y 4 años</option>
                                                <option value="30">Entre 5 y 7 años</option>
                                                <option value="1">Más 7 años</option>
                                                <option value="100">No tiene soporte de respuestos</option>
                                            </select>    
                                        
                                        </div>
                                        </div>
                                        
                                        <?php
                                            if(isset($DispoSoporteConsumiblesL)){
                                                $DispoSoporteConsumiblesL;
                                            }else{
                                                $DispoSoporteConsumiblesL="-- Seleccione --";
                                            }
                                          ?>
                                        
                                        <div class="row">
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">DISPONIBILIDAD DE SOPORTES DE CONSUMIBLES</label>
                                            <!--<input type="text" name="DispoSoporteConsumibles" class="form-control" id="DispoSoporteConsumibles" value="<?php // if(isset($DispoSoporteConsumibles)){echo $DispoSoporteConsumibles;}  ?>" placeholder="" disabled>-->
                                        <select name="DispoSoporteConsumibles" id="DispoSoporteConsumibles" class="form-control" disabled>
                                            <option value="<?php  if(isset($DispoSoporteConsumibles)){echo $DispoSoporteConsumibles;}  ?>"><?php  if(isset($DispoSoporteConsumiblesL)){echo $DispoSoporteConsumiblesL;}  ?></option>
                                            <option value="">-- Seleccione --</option>
                                            <option value="">No requiere consumibles</option>
                                            <option value="100">No tiene soporte de consumibles</option>
                                            <option value="65">De 1 a 4 años</option>
                                            <option value="30">De 5 a 7 años</option>
                                            <option value="1">Mayor a 7 años</option>
                                        </select>
                                        
                                        
                                        </div>
                                            
                                            <?php
                                            if(isset($DispoSoporteTecnicoRepuestosL)){
                                                $DispoSoporteTecnicoRepuestosL;
                                            }else{
                                                $DispoSoporteTecnicoRepuestosL="-- Seleccione --";
                                            }
                                          ?>
                                            
                                            
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="exampleInputName2" class="col-sm-3 col-md-3 col-lg-12">PROVEEDOR SOPORTE TECNICO INCLUYE REPUESTOS</label>
                                            <!--<input type="text" name="DispoSoporteRepuestos" class="form-control" id="DispoSoporteRepuestos" value="<?php//  if(isset($DispoSoporteTecnicoRepuestos)){//echo $DispoSoporteTecnicoRepuestos;}  ?>" placeholder="" disabled>-->
                                            <select name="DispoSoporteRepuestos" id="DispoSoporteRepuestos" class="form-control" disabled>
                                                <option value="<?php  if(isset($DispoSoporteTecnicoRepuestos)){echo $DispoSoporteTecnicoRepuestos;}  ?>"><?php  if(isset($DispoSoporteTecnicoRepuestosL)){echo $DispoSoporteTecnicoRepuestosL;}  ?></option>
                                                <option value="">-- Seleccione --</option>
                                                <option value="1">Con fábrica</option>
                                                <option value="50">Otro proveedor</option>
                                                <option value="100">No existe soporte técnico</option>
                                            </select>
                                        
                                        </div>
                                        
                                        </div>
                                        
                                </div>
                            </div>
                            </div>
                        
                            <!--Fin información de la compra-->
                            
                            
                            
                        <div id="panel3" class="panel panel-default">
                            <div class="panel-heading" role="tab" id="barraExpancion3">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        UBICACIÓN Y PUESTA EN MARCHA
                                    </a>
                                </h4>
                            </div>
                            
                            <script>
                            
                            var query="<p></p>";
                            
                            </script>
                            
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    
                                                
                                                <?php
                                                require_once ('./conexion.php');
                                                $con=  conectar();
                                                        if(isset($Sede)){
                                                          $c=$Sede;  
                                                        }else{
                                                          $c="";  
                                                        }

                                                    $querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                                                    //$querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                                                    $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                                                ?>
                                    
                                    <div id="EjemploCiudad"></div>
                                    
                                    <div class="form-group" style="position: relative;float: left;margin-right: 30px;">
                                                    <label for="exampleInputName2">CIUDAD</label>
                                                    
                                                    <!--<input type="text" id="sede" name="sede" class="form-control" id="exampleInputName2" value="<?php  if(isset($Sede)){echo $Sede;}  ?>" placeholder="" disabled>-->
                                                    <select class="form-control" name="ciudad" id="CiudadUbicacion" style="width: 200px;" onchange="" disabled>
                                                            <option value="<?php echo $c; ?>"><?php echo $c; ?></option> 
                                                           <?php
                                                           while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                                                            echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                                                        }
                                                           ?>
                                                     </select>
                                                </div>

                                                <?php
                                                    if(isset($Area)){
                                                      $s=$Area;  
                                                    }else{
                                                      $s="Todos";  
                                                    }

                                                    $querySeleccionSede="SELECT Area FROM ubicaciones WHERE 1 GROUP BY Area";



                                                    $conexionSeleccionSede=mysql_query($querySeleccionSede, $con);

                                                    ?>   
                                    
                                    
                                    
                                    <div class="form-group" style="float: left;position: relative;margin-right: 30px;">
                                                    <label for="exampleInputName2">SEDE</label>
                                                    
                                                    <!--<input type="text" id="area" name="area" class="form-control" id="exampleInputName2" value="<?php // if(isset($Area)){echo $Area;}  ?>" placeholder="" disabled>-->
                                                 
                                                    <select class="form-control" name="Sede" id="txtSede" style="width: 200px;" disabled>
                                                    <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                    <?php
                                                    while($arraySeleccionSede=mysql_fetch_array($conexionSeleccionSede)){

                                                     echo "<option value='".$arraySeleccionSede['Area']."'>".$arraySeleccionSede['Area']."</option>";
                                                 }
                                                    ?>

                                                    </select>
                                                
                                                </div>
                                                    
                                                    <?php
                                                        if(isset($SubArea)){
                                                          $a=$SubArea;  
                                                        }else{
                                                          $a="";  
                                                        }

                                                        $querySeleccionArea="SELECT Sub_Area FROM ubicaciones GROUP BY Sub_Area";
                                                        $conexionSeleccionArea=mysql_query($querySeleccionArea, $con);
                                                        ?>
                                                    
                                                <div class="form-group" style="float: left;position: relative;">
                                                    <label for="exampleInputName2">AREA</label>
                                                    <!--<input type="text" id="subarea" name="subarea" class="form-control" id="exampleInputName2" value="<?php //if(isset($SubArea)){echo $SubArea;}  ?>" placeholder="" disabled>-->
                                                <select class="form-control" name="Area" id="txtArea" style="width: 200px;" disabled>
                                                    <option value="<?php echo $a; ?>"><?php echo $a; ?></option> 
                                                   <?php
                                                   while($arraySeleccionArea=mysql_fetch_array($conexionSeleccionArea)){
                                                    echo "<option value='".$arraySeleccionArea['Sub_Area']."'>".$arraySeleccionArea['Sub_Area']."</option>";
                                                }
                                                   ?>
                                                   </select>
                                                </div>

                                                <div class="form-group" style="float: left;position: relative;">
                                                  <table>
                                                      <tr>
                                                          <td><p style="width: 200px;margin-top: -5px;margin-left: 30px;font-weight: bold;">FECHA PUESTA MARCHA</p></td>
                                                          <td><p style="width: 200px;margin-top: -5px;margin-left: 30px;font-weight: bold;">FECHA DESCARTE</p></td>
                                                    </tr>
                                                    <tr>
                                                    <td><input type="date" class="form-control" name="fecha_marcha" id="fecha_marcha" style="width: 200px;" value="<?php  if(isset($Fecha_Marcha)){echo $Fecha_Marcha;}  ?>" placeholder="" disabled></td>
                                                    <td><input type="date" class="form-control" name="fecha_descarte" id="fecha_descarte" style="width: 200px;" value="" placeholder="" disabled></td>
                                                    <tr>
                                                  </table>
                                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                            
                            
                            <!--  CALCULAR LA PROXIMA FECHA DE REALIZACIÓN DE LA INTERVENCIÓN  ->
                            
                            <!-- Ultima fecha de intervencion -->
                            
                            <?php 
                            if(isset($_POST['desdebuscador'])){
                                 
                            $queryUltimaFechaIntervencionMantoPreventivo="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Mantenimiento preventivo'";
                            $queryUltimaFechaIntervencionVerificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Verificacion'";
                            $queryUltimaFechaIntervencionCalibracion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Calibracion'";
                            $queryUltimaFechaIntervencionCalificacion="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$codHV' && Tipo_Intervencion='Calificacion'";
                            $queryUltimaFechaIntervencionOtro="SELECT MAX(Fecha_Intervencion) FROM reportes_intervencion WHERE HV_Equipo='$codHV' && Tipo_Intervencion<>'Mantenimiento preventivo' && Tipo_Intervencion<>'Verificacion' && Tipo_Intervencion<>'Calibracion' && Tipo_Intervencion<>'Calificacion'";
                            
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
                            
                            $time=  time();
                            $fecharegistro=date("Y-m-d", $time);
                            
                            // Mostrar en la hoja de vida la proxima Fecha mantenimiento
                            if(isset($fechaUltimoManto) && $fechaUltimoManto==0 || $fechaUltimoManto=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00" && $DesdeMantoPreventivo="Puesta en marcha" && isset($mantoPreventivo) && $mantoPreventivo>0){
                                
                                $nuevafechaManto1=$Fecha_Marcha;
                                if($Fecha_Marcha<$fecharegistro){
                                    $nuevafechaManto=$nuevafechaManto1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                    $nuevafechaManto=$nuevafechaManto1;
                                }
                                
                            }else if(isset($fechaUltimoManto) && $mantoPreventivo>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$mantoPreventivo." day";
                                
                                $nuevafechaManto1 = date('Y-m-d', strtotime("$fechaUltimoManto + $Sumar"));
                                
                                if($nuevafechaManto1<$fecharegistro){
                                    $nuevafechaManto=$nuevafechaManto1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                    $nuevafechaManto=$nuevafechaManto1;
                                }
                            }else if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
                                $nuevafechaManto="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
                                }
                            else if(isset($mantoPreventivo) && $mantoPreventivo==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $nuevafechaManto="No aplica Intervención";
                            }else if(isset($mantoPreventivo) && $mantoPreventivo>0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$mantoPreventivo." day";
                                $nuevafechaManto1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                            if($nuevafechaManto1<$fecharegistro){
                                    $nuevafechaManto=$nuevafechaManto1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaManto=$nuevafechaManto1;
                                }
                             }else{
                                $nuevafechaManto="<p style='color:red;'>Equipo fuera de uso</p>";
                                }
                            
                            
                            // Mostrar en la hoja de vida la proxima Fecha Verificacion
                            
                            if(isset($FechaUltimoVerificacion) && $FechaUltimoVerificacion==0 || $FechaUltimoVerificacion=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00" && isset($verificacion) && $verificacion>0){
                                
                                $nuevafechaVerificacion1=$Fecha_Marcha;
                                if($Fecha_Marcha<$fecharegistro){
                                $nuevafechaVerificacion=$nuevafechaVerificacion1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                $nuevafechaVerificacion=$nuevafechaVerificacion1;    
                                }
                            }else    
                                
                            if(isset($FechaUltimoVerificacion) && $verificacion>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$verificacion." day";
                                $nuevafechaVerificacion1 = date('Y-m-d', strtotime("$FechaUltimoVerificacion + $Sumar"));
                                if($nuevafechaVerificacion1<$fecharegistro){
                                    $nuevafechaVerificacion=$nuevafechaVerificacion1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                    $nuevafechaVerificacion=$nuevafechaVerificacion1;
                                }
                            }else if(isset($verificacion) && $verificacion>0 && isset($Fecha_Marcha) &&$Fecha_Marcha=="0000-00-00"){
                                $nuevafechaVerificacion="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
                            }
                            else if(isset($verificacion) && $verificacion==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $nuevafechaVerificacion="No aplica Intervención";
                            }else if(isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00" && isset($verificacion)){
                                $Sumar=$verificacion." day";
                                $nuevafechaVerificacion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                            if($nuevafechaVerificacion1<$fecharegistro){
                                    $nuevafechaVerificacion=$nuevafechaVerificacion1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaVerificacion=$nuevafechaVerificacion1;
                                }
                             }else{
                                $nuevafechaVerificacion="<p style='color:red;'>Equipo fuera de uso</p>";
                            }
                            
                            
                            // Mostrar en la hoja de vida la proxima Fecha Calibración
                            if(isset($FechaUltimoCalibracion) && $FechaUltimoCalibracion==0 || $FechaUltimoCalibracion=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00" && isset($calibracion) && $calibracion>0){
                                
                                $nuevafechaCalibracion1=$Fecha_Marcha;
                                if($Fecha_Marcha<$fecharegistro){
                                $nuevafechaCalibracion=$nuevafechaCalibracion1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                $nuevafechaCalibracion=$nuevafechaCalibracion1;    
                                }
                                
                                }else
                            if(isset($FechaUltimoCalibracion) && $calibracion>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$calibracion." day";
                                $nuevafechaCalibracion1 = date('Y-m-d', strtotime("$FechaUltimoCalibracion + $Sumar"));
                                if($nuevafechaCalibracion1<$fecharegistro){
                                    $nuevafechaCalibracion=$nuevafechaCalibracion1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaCalibracion=$nuevafechaCalibracion1;
                                }
                            }else if(isset($calibracion) && $calibracion>0 && isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
                                $nuevafechaCalibracion="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
                            }
                            else if(isset($calibracion) && $calibracion==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $nuevafechaCalibracion="No aplica Intervención";
                            }else if(isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00" && isset($calibracion)){
                                $Sumar=$calibracion." day";
                                $nuevafechaCalibracion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                            if($nuevafechaCalibracion1<$fecharegistro){
                                    $nuevafechaCalibracion=$nuevafechaCalibracion1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaCalibracion=$nuevafechaCalibracion1;
                                }
                             }else{
                                $nuevafechaCalibracion="<p style='color:red;'>Equipo fuera de uso</p>";
                            }
                            
                            
                            // Mostrar en la hoja de vida la proxima Fecha Calificación
                            
                            if(isset($FechaUltimoCalificacion) && $FechaUltimoCalificacion==0 || $FechaUltimoCalificacion=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00" && isset($calificacion) && $calificacion>0){
                                
                                $nuevafechaCalificacion1=$Fecha_Marcha;
                                if($Fecha_Marcha<$fecharegistro){
                                $nuevafechaCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                $nuevafechaCalificacion=$nuevafechaCalificacion1;    
                                }
                                
                                }else
                            if(isset($FechaUltimoCalificacion) && $calificacion>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$calificacion." day";
                                $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$FechaUltimoCalificacion + $Sumar"));
                                if($nuevafechaCalificacion1<$fecharegistro){
                                    $nuevafechaCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaCalificacion=$nuevafechaCalificacion1;
                                }
                            }else if(isset($calificacion) && $calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
                                $nuevafechaCalificacion="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
                            }
                            else if(isset($calificacion) && $calificacion==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $nuevafechaCalificacion="No aplica Intervención";
                            }else if(isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00" && isset($calificacion)){
                                $Sumar=$calificacion." day";
                                $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                            if($nuevafechaCalificacion1<$fecharegistro){
                                    $nuevafechaCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaCalificacion=$nuevafechaCalificacion1;
                                }
                             }else{
                                $nuevafechaCalificacion="<p style='color:red;'>Equipo fuera de uso</p>";
                            }
                            
                            
//                            if(isset($FechaUltimoCalificacion) && $FechaUltimoCalificacion==0 || $FechaUltimoCalificacion=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
//                                
//                                $nuevafechaCalificacion1=$Fecha_Marcha;
//                                $FechaUltimoCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'> Vencido</p>";
//                            }else
//                            if(isset($FechaUltimoCalificacion) && $calificacion>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
//                                $Sumar=$calificacion." day";
//                                $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$FechaUltimoCalificacion + $Sumar"));
//                                if($nuevafechaCalificacion1<$fecharegistro){
//                                    $nuevafechaCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'>Vencido</p>";
//                                }else{
//                                    $nuevafechaCalificacion=$nuevafechaCalificacion1;
//                                }
//                            }else if(isset($calificacion) && $calificacion>0 && isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
//                                $nuevafechaCalificacion="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
//                            }
//                            else if(isset($calificacion) && $calificacion==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
//                                $nuevafechaCalificacion="No aplica Intervención";
//                            }else if(isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00" && isset($calificacion)){
//                                $Sumar=$calificacion." day";
//                                $nuevafechaCalificacion1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
//                            if($nuevafechaCalificacion1<$fecharegistro){
//                                    $nuevafechaCalificacion=$nuevafechaCalificacion1."<br><p style='color:red;'>Vencido</p>";
//                                }else{
//                                    $nuevafechaCalificacion=$nuevafechaCalificacion1;
//                                }
//                             }else{
//                                $nuevafechaCalificacion="<p style='color:red;'>Equipo fuera de uso</p>";
//                            }
                            
                            // Mostrar en la hoja de vida la proxima Fecha Otro
                           
                            if(isset($FechaUltimoOtro) && $FechaUltimoOtro==0 || $FechaUltimoOtro=="" && isset($Fecha_Marcha) && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00" && isset($FrecuenciaOtro) && $FrecuenciaOtro>0){
                                
                                $nuevafechaOtro1=$Fecha_Marcha;
                                if($Fecha_Marcha<$fecharegistro){
                                $nuevafechaOtro=$nuevafechaOtro1."<br><p style='color:red;'> Vencido</p>";
                                }else{
                                $nuevafechaOtro=$nuevafechaOtro1;    
                                }
                                
                                }else
                            if(isset($FechaUltimoOtro) && isset($FrecuenciaOtro) && $FrecuenciaOtro>0 && $Fecha_Marcha!="" && $Fecha_Marcha!="0000-00-00"){
                                $Sumar=$FrecuenciaOtro." day";
                                $nuevafechaOtro1 = date('Y-m-d', strtotime("$FechaUltimoOtro + $Sumar"));
                                if($nuevafechaOtro1<$fecharegistro){
                                    $nuevafechaOtro=$nuevafechaOtro1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaOtro=$nuevafechaOtro1;
                                }
                            }else if(isset($FrecuenciaOtro) && $FrecuenciaOtro>0 && isset($Fecha_Marcha) && $Fecha_Marcha=="0000-00-00"){
                                $nuevafechaOtro="Aplica Intervención,<br><p style='color:red;'>Equipo fuera de de uso</p>";
                            }
                            else if(isset($FrecuenciaOtro) && $FrecuenciaOtro==0 && isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00"){
                                $nuevafechaOtro="No aplica Intervención";
                            }else if(isset($Fecha_Marcha)!="" && $Fecha_Marcha!="0000-00-00" && isset($FrecuenciaOtro)){
                                $Sumar=$FrecuenciaOtro." day";
                                $nuevafechaOtro1 = date('Y-m-d', strtotime("$Fecha_Marcha + $Sumar"));
                            if($nuevafechaOtro1<$fecharegistro){
                                    $nuevafechaOtro=$nuevafechaOtro1."<br><p style='color:red;'>Vencido</p>";
                                }else{
                                    $nuevafechaOtro=$nuevafechaOtro1;
                                }
                             }else{
                                $nuevafechaOtro="<p style='color:red;'>Equipo fuera de uso</p>";
                            }
                            }
                            ?>
                         
                            
                            <div id="panel4" class="panel panel-default">
                            <div class="panel-heading" role="tab" id="barraExpancion4">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        MANTENIMIENTOS E INTERVENCIONES METROLOGICAS
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
        
                                    <table class="table table-condensed table-responsive" id="tablaIntervenciones" style="width: 80%;">
                                        <tr style="background: #ccc;text-align: center;">
                                         
                                            <td class="celdaTitulo">TIPO INTERVENCIÓN</td>
                                            <td class="celdaTitulo">FRECUENCIA (dias)</td>
                                            <td class="celdaTitulo">APLICA DESDE</td>
                                            <td class="celdaTitulo">PROXIMAS FECHAS</td>
                                        </tr>
                                
                                        <tr>  
                                
                                <td>MANTENIMIENTO PREVENTIVO</td>
                                <td style="display: block;" id="displayFrecuenciaManto"><input type="text" id="f_manto" class="form-control" name="f_manto" value="<?php  if(isset($mantoPreventivo) && $mantoPreventivo!=0){echo $mantoPreventivo;}else if(isset($mantoPreventivo) && $mantoPreventivo==0){}  ?>" placeholder="" disabled></td>
                                
<!--                                <td style="display:none;" id="displayFechaEspecificaManto">
                                    <input type="date" id="FechaMantoEspecifica" name="FechaMantoEspecifica" style="width: 150px;" class="form-control" placeholder="">
                                    <button type="submit" class="btn-danger" onclick="GuardarProgramacionEspecifica();">Programar</button>
                                </td>-->
                                
                                <td>
                                    <select class="form-control" name="inicioManto" id="inicioIntervencionManto" style="width: 200px;" disabled>
                                    <option value="Puesta en marcha" selected>Puesta en marcha</option>
                                    <option value="Cumplimiento del ciclo">Cumplimiento del ciclo</option>
                                    <option value="Fecha especifica">Fecha especifica</option>
                                </select>
                                </td>    
                                <td id="FechaMantoProgramadaEspecifica"><?php  if(isset($mantoPreventivo) && isset($nuevafechaManto)){echo $nuevafechaManto;} ?></td>
                                    </tr>
                                    
                                <tr>
                                <td>VERIFICACIÓN</td>
                                <td><input type="text" id="f_verificacion" class="form-control" name="f_verificacion" value="<?php  if(isset($verificacion) && $verificacion!=0){echo $verificacion;}else if(isset($verificacion) && $verificacion==0){}  ?>" placeholder="" disabled></td>
                                <td>
                                    <select class="form-control" name="inicioVerificacion" id="inicioIntervencionVerificacion" style="width: 200px;" disabled>
                                    <option value="Puesta en marcha" selected>Puesta en marcha</option>
                                    <option value="Cumplimiento del ciclo">Cumplimiento del ciclo</option>
                                </select>
                                </td>    
                                <td>
                                     <?php  if(isset($verificacion) && isset($nuevafechaVerificacion)){echo "<p style='display:inline;width:20px;'>".$nuevafechaVerificacion."</p>";}?>
                                    </td>
                                    </tr>
                                    <tr>   
                                <td>CALIBRACIÓN</td>
                                <td><input type="text" id="f_calibracion" class="form-control" name="f_calibracion" value="<?php  if(isset($calibracion) && $calibracion!=0){echo $calibracion;}else if(isset($calibracion) && $calibracion==0){}  ?>" placeholder="" disabled></td>
                                <td>
                                    <select class="form-control" name="inicioCalibracion" id="inicioIntervencionCalibracion" style="width: 200px;" disabled>
                                    <option value="Puesta en marcha" selected>Puesta en marcha</option>
                                    <option value="Cumplimiento del ciclo">Cumplimiento del ciclo</option>
                                </select>
                                </td>
                                <td>
                                    <?php  if(isset($calibracion) && isset($nuevafechaCalibracion)){echo "<p style='display:inline;width:20px;'>".$nuevafechaCalibracion."</p>";} ?>
                                    </td>
                                    </tr>   
                                    <tr>
                                        <td>CALIFICACIÓN</td>
                                    <td><input type="text" id="f_calificacion" class="form-control" name="f_calificacion" value="<?php  if(isset($calificacion) && $calificacion!=0){echo $calificacion;}else if(isset($calificacion) && $calificacion==0){} ?>" placeholder="" disabled></td>
                                    <td>
                                        <select class="form-control" name="inicioCalificacion" style="width: 200px;" id="inicioIntervencionCalificacion" disabled>
                                    <option value="Puesta en marcha" selected>Puesta en marcha</option>
                                    <option value="Cumplimiento del ciclo">Cumplimiento del ciclo</option>
                                </select>
                                </td>
                                    <td>
                                    <?php  if(isset($calificacion) && isset($nuevafechaCalificacion)){echo $nuevafechaCalificacion;} ?>
                                    </td>
                            
                                    </tr>
                                    <tr>
                                 <td>   
                                <input type="text" style="width: 230px;" id="otro_cual" class="form-control" value="<?php  if(isset($TipoOtro) && $TipoOtro!=0){echo $TipoOtro;}else if(isset($TipoOtro) && $TipoOtro==0){}  ?>" name="otro_cual" placeholder="Otro, Cual? (escriba aca)" disabled>
                                 </td>
                                 <td>
                                 
                                <input type="text" id="f_otro" class="form-control" name="f_otro" value="<?php  if(isset($FrecuenciaOtro) &&$FrecuenciaOtro!=0){echo $FrecuenciaOtro;}else if(isset($FrecuenciaOtro) && $FrecuenciaOtro==0){}  ?>" disabled>
                                </td>
                                <td>
                                    <select class="form-control" name="inicioOtro" id="inicioIntervencionOtro" style="width: 200px;" disabled>
                                    <option value="Puesta en marcha" selected>Puesta en marcha</option>
                                    <option value="Cumplimiento del ciclo">Cumplimiento del ciclo</option>
                                </select>
                                </td> 
                                <td>
                                <?php  if(isset($FrecuenciaOtro) && isset($nuevafechaOtro)){echo "<p style='display:inline;width:20px;'>".$nuevafechaOtro."</p>";} ?>
                                </td>
                            </tr>
                                    </table>
                                </div>
                       <?php if(isset($_POST['desdebuscador'])){ ?> <?php }else{ ?> <div style="display:none"> <?php } ?>
                         
                                
                                </div>

                            </div>
                                
                        </div>
                               
                            <!-- HISTORIAL DE INTERVENCIONES -->
                            
                                                    
                            <!--Fin Caracterización del riesgo-->    
                            
                            <?php
                            
                            // Condicional para mostrar historial en edicion y no en creacion de hoja de vida
                            if(isset($displayHistorial)==""){
                                $atributoDisplay="none";
                            }else {
                                $atributoDisplay="";
                            }
                            
                            ?>
                            
                            <div style="display:<?php echo $atributoDisplay ?>">
                            
                                <div id="panel5" class="panel panel-default" style="margin-top:-14px;">
                            <div class="panel-heading" role="tab" id="barraExpancion5">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        HISTORIAL DE INTERVENCIONES
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">
                                 
                                    <?php
                                    include('./Historial_Intervenciones.php');
                                    historialIntervenciones($codHV);
                                    ?>
                                
                                </div>
                            </div>
                        </div>
                            
                            
                            <div id="panel6" class="panel panel-default" style="margin-top:-14px;">
                            <div class="panel-heading" role="tab" id="barraExpancion6">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button">
                                        HISTORIAL DE UBICACIÓN Y PUESTA EN MARCHA
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-body">
                                 
                                    <?php
                                    include('./Historial_ubicacion.php');
                                    historialUbicacion($codHV);
                                    ?>
                                
                                </div>
                            </div>
                        </div>
                </div> <!-- del compartidor para display-->

            </div>  
        
                
        </form>                                
            </div> 
                
                <form method="POST" id="FormularioCodHV" action="reporteIntervencion.php">
                    <input type="hidden" name="codigoHojavida" value="<?php echo $codHV; ?>">
                </form>
                
            <?php
        }
        
          
        ?>
    </body>
</html>
