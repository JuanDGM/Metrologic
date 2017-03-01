<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Principal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosRevisionInformes.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css" media="screen">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script src="EnviardatosModalSatisfaccion.js"></script>
        <script src="EvaluacionSatisfaccionUsuario.js"></script>
        <script src="GuardarIntervencionesRevisadas.js"></script>
        
    </head>
    <body id="cuerpo">
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        <div id="MenuRevision">
            
           <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div> 
            
        </div>
        <div id="detalleRevision">
            <div id="encabezado" class="page-header" style="width: 100%;height: 100px;border-bottom: 1px solid #a3a3a3;">
                <a href='Menu.php' style='float: right;margin-right: 30px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
                <h1 style="font-weight: bold;margin-left:5%;">REVISIÓN Y APROBACIÓN DE INFORMES</h1>
            </div>
            <br/>
            <br/>
            <?php
            include ('./conexion.php');
            $con=  conectar();
            
            $queryIntervencionesPorAprobar="SELECT 
                                                    r.No_Intervencion, 
                                                    r.HV_Equipo,
                                                    h.Nombre_Equipo,
                                                    r.Tipo_Intervencion, 
                                                    r.Descripcion, 
                                                    r.Fecha_Esperada, 
                                                    r.Fecha_Intervencion, 
                                                    r.Nombre_Proveedor,
                                                    r.Nombre_Tecnico
                                            FROM 
                                                    reportes_intervencion AS r LEFT JOIN hoja_vida AS h ON r.HV_Equipo=h.No_HV 
                                            WHERE 
                                                    Tipo_Intervencion<>'Mantenimiento correctivo' && Estado_Intervencion<>'Aprobado'";
            
            $conexionIntervencionesPorAprobar=mysql_query($queryIntervencionesPorAprobar, $con);
            ?>
            
            <script type="text/javascript">
                $(document).ready(function(){
                $("#TablaIntervencionesPorRevisar").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            
            }
            
                });
            });
            </script>
            
            
            <table id="TablaIntervencionesPorRevisar" class="table table-bordered"  style="width: 95%;margin: auto;">
                <thead>    
                    <tr>
                        <td style="width: 30px;vertical-align: middle;text-align: center;font-size: 10px;font-weight: bold;">COD REPORTE</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">COD EQUIPO</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">NOMBRE EQUIPO</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">TIPO INTERVENCION</td>
                        <td style="width: 200px;vertical-align: middle;text-align: center;">DESCRIPCION</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">FECHA ESPERADA</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">FECHA EJECUTADO</td>
                        <td style="width: 60px;vertical-align: middle;text-align: center;">PROVEEDOR</td>
                        <td style="width: 70px;vertical-align: middle;text-align: center;">FACTOR CORRECCIÓN</td>
                        <td style="width: 50px;vertical-align: middle;text-align: center;">ENCUESTA</td>
                        <td style="width: 50px;vertical-align: middle;text-align: center;">ESTADO</td>
                    </tr>
                </thead>
                <tbody>
                    
            <?php
            $i=0;
            while($arrayIntervencionesPorAprobar=mysql_fetch_array($conexionIntervencionesPorAprobar)){
               $i+=1;
                if($arrayIntervencionesPorAprobar['Tipo_Intervencion']=="Calibracion"){
                   $readonly="";
                   $texto="Factor Corrección";
               }else{
                   $readonly="readonly";
                   $texto="No Aplica";
               }
               
               $identificadorFormulario="formularioIntervencionesRealizadas".$i
               ?>
                
                <tr>
                <form id="<?php echo $identificadorFormulario; ?>" method="POST">
                <td><?php echo $arrayIntervencionesPorAprobar['No_Intervencion']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['HV_Equipo']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Nombre_Equipo']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Tipo_Intervencion']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Descripcion']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Fecha_Esperada']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Fecha_Intervencion']; ?></td>
                <td><?php echo $arrayIntervencionesPorAprobar['Nombre_Proveedor']; ?></td>
                <td><?php echo "<input type='text' class='form-control' placeholder='$texto' style='width:100%;' $readonly name='factorCorreccion'>"; ?></td>
                
                <td><?php 
                
                    $p='"'.$arrayIntervencionesPorAprobar['Nombre_Proveedor'].'"';
                    //$T='"'.$tecnicoEncuesta.'"';
                    $x=$p;
                    $y='"'.$arrayIntervencionesPorAprobar['Nombre_Tecnico'].'"';
                    $s='"'.$arrayIntervencionesPorAprobar['Tipo_Intervencion'].'"';
                    echo "<button type='button' class='btn btn-defauld btn-sm' data-toggle='modal' data-target='#myModal' name='btnModal' id='btnModal' value='".$arrayIntervencionesPorAprobar['No_Intervencion']."' onclick='trarDatos(this.value);traerCodReporteGuardar(this.value,$x,$y,$s);'>";
                    echo "<span class='glyphicon glyphicon-list-alt' style='color:red;'></span>";
                    echo "</button>";
                
                ?></td>
                
                <td><?php echo "<select class='form-control' style='margin:5px;' name='EstadoSeleccionado'>
                                <option value='0'>Seleccione</option>
                                <option value='Aprobado'>Aprobado</option>
                                <option value='Retener'>Retener</option>
                                </select>"; ?>
                    <input type="hidden" value="<?php echo $arrayIntervencionesPorAprobar['No_Intervencion']; ?>" name="Cod_Reporte">
                    <input type="hidden" value="<?php echo $arrayIntervencionesPorAprobar['HV_Equipo']; ?>" name="Cod_Equipo">
                    <input type="hidden" value="<?php echo $arrayIntervencionesPorAprobar['Tipo_Intervencion']; ?>" name="Tipo_Intervencion">
                    
                    
                    <button type="submit" class="btn btn-success btn-xs" id="<?php echo $i; ?>" name="guardarAprobacion" value="<?php echo $i; ?>" onclick="IntervencionesRevisadas(this.value);">Guardar<?php echo $i; ?></button>
                </td>
                </form>
                </tr>
                
                <?php
                }
                ?>
                
                    
                </tbody>
                
            </table>
                
        </div>
        
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
          <input type="hidden" value="" name="proveedorEvaluar" id="proveedorEvaluarModal">  
          <input type="hidden" value="" name="tecnicoEvaluar" id="tecnicoEvaluarModal">  
          <input type="hidden" value="" name="intervencionEvaluar" id="intervencionEvaluarModal">  
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
                  <td style="padding: 5px;"><button id="bueno1" type="button" onclick="PrimerPregunta(this.value,x,p,l,i)" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio1" type="button" onclick="PrimerPregunta(this.value,x,p,l,i)" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Reparación resuelta eficaz</td>
                  <td id="respuesta2" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i)" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i)" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio2" type="button" onclick="SegundaPregunta(this.value,x,p,l,i)" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Actitud del técnico</td>
                  <td id="respuesta3" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente3" type="button" onclick="TercerPregunta(this.value,x,p,l,i)" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno3" type="button" onclick="TercerPregunta(this.value,x,p,l,i)" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio3" type="button" onclick="TercerPregunta(this.value,x,p,l,i)" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
              </tr>
              <tr style="display: inline-block">
                  <td style="font-size: 20px;width: 400px;">-Competencia del tecnico</td>
                  <td id="respuesta4" style="width: 30px;color: royalblue"></td>
                  <td style="padding: 5px;"><button id="excelente4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i)" value="5"><span class="glyphicon glyphicon-ok" style="color: green;"></span></button></td>
                  <td style="padding: 5px;"><button id="bueno4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i)" value="3"><span class="glyphicon glyphicon-minus" style="color: orange;"></span></button></td>
                  <td style="padding: 5px;"><button id="insatisfactorio4" type="button" onclick="CuartaPregunta(this.value,x,p,l,i)" value="1"><span class="glyphicon glyphicon-remove" style="color: red;"></span></button></td>
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
</div>

    </body>
</html>

