<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Indice Obsolescencia</title>
        <link rel="stylesheet" href="EstilosIndiceObsolescencia.css">
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="DatosObsolescencia.js"></script>
        <script src="EstimarIndiceObsolescencia.js"></script>
        <script src="DistribucionCantidadEquiposObsolescencia.js"></script>
        <script>
        
//        document.getElementById("SegundoBtn").addEventListener("click",mostrarDetalleObsolescencia,false);
//        
//        
//        function mostrarDetalleObsolescencia(){
//            
//           $("$FormularioResumenObsolescencia").submit(); 
//            
//        }
        
//      $(document).ready(function(){
//          document.getElementById("idgrabar").addEventListenner("click",grabar,false);
//      });

//          function grabar(){
//              $("#Formulario").submit(); 
//            }  
        </script>
        
        
        
    </head>
    <body id="cuerpo">
         <?php
         include('./EquiposDisponiblesEstimacionObsolescencia.php');//Cantidad de equipos a los que les aplica la estimacion de obsolescencia.
         
                 
         ?>
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
                
        <div id="panel">
        <div id="panelLogo">
                <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div>
        </div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            CALCULAR INDICE DE OBSOLESCENCIA
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            
   
                            <form id="FormularioBuscador" method="POST">
                                
                                <label>Ciclo de obsolescencia a estimar: <span><?php echo CicloObsolescenciaaEstimar(); ?></span></label><br/>
                                <label>Cantidad de equipos a estimar: <span><?php echo NumeroIntervenciones(); ?></span></label><br/>
                                <label>Cantidad de equipos en inventario: <span><?php CantidadEquiposInventario(); ?></span></label><br/> <!-- EquiposDisponiblesEstimacionObsolescencia.php -->
                                    
                                <input type="hidden" name="claveIngreso" value="1">
                                <button type="submit" onclick="estimarIndice()" class="btn btn-primary">Estimar</button>

                            </form>
                            <br/>
                            <br/>

                            <form class="form-inline" id="FormularioResumenObsolescencia" method="POST" action="#">
                              <div class="form-group">
                                <label for="exampleInputName2">No ciclo estimación:</label>
                                <input type="text" name="cicloSeleccionado" class="form-control" id="campoTextoCiclo" value="<?php echo ultimoCicloEvaluado(); ?>" placeholder="" style="width: 30%;" onkeyup="distribucionObsolescencia(this.value)" onfocus="distribucionObsolescencia(this.value)" autofocus>
                              </div>
                                
                            <br/>
                            <br/>
                            
                            
                            <table class="table table-bordered">
                            <tr>
                                <td style="font-weight: bold;text-align: center;vertical-align: middle;">Indice Cualitativo</td>
                                <td style="font-weight: bold;text-align: center;vertical-align: middle;">Cant. Equipos</td>
                            </tr>
                                <tr>
                                    <td class="alert alert-success" style="font-weight: bold;width: 80%;">Tecnología NO requiere evaluación ni renovación</td>
                                    <td style="text-align: center;font-size: 17px;"><button type="submit" name="btn1" class="btn btn-default"><span id="respuestaVerde"></span></button></td>
                                </tr>
                                <tr>
                                    <td class="alert alert-info" style="font-weight: bold;">Evaluar tecnología en un año</td>
                                    <td style="text-align: center;font-size: 17px;"><button type="submit" name="btn2" class="btn btn-default"><span id="respuestaAzul"></span></button></td>
                                </tr>
                                <tr>   
                                    <td class="alert alert-warning" style="font-weight: bold;">Renovación de tecnología a la brevedad (Plazo inferior a un año)</td>
                                    <td style="text-align: center;font-size: 17px;"><button type="submit" name="btn3" class="btn btn-default"><span id="respuestaAmarillo"></span></button></td>
                                </tr>
                                <tr>
                                    <td class="alert alert-danger" style="font-weight: bold;">Reposición de tecnología (Inmediato)</td>
                                    <td style="text-align: center;font-size: 17px;"><button type="submit" name="btn4" class="btn btn-default"><span id="respuestaRojo"></span></button></td>
                                </tr>
                            </table>
                            </form>
                        </div>
                      </div>
                    </div>
                    </div>
        </div>
        
        <div id="contenedor">
        <div class="page-header" id="encabezadoinicio" style="border-bottom: 1px solid #a3a3a3;">
            <div style="float: left">
                <h1 style="margin-left: 30px;"><label>INDICE DE OBSOLESCENCIA</label></h1>
            </div>
            <div style="float: right;margin-right: 30px;margin-top: 30px;">
            <a href='Menu.php' style='vertical-align: middle;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        </div>
        </div>
            
            <?php
            $con=  conectar();
            
            $querMaxCicloObsolescencia="SELECT 
                                                MAX(Ciclo_Obsolescencia) 
                                        FROM 
                                                obsolescencia 
                                        WHERE 
                                                1";
            
            $conexionMaxCiclo=mysql_query($querMaxCicloObsolescencia, $con);
            
            while($ArrayMaxCiclo=mysql_fetch_array($conexionMaxCiclo)){
                $maxCiclo=$ArrayMaxCiclo['MAX(Ciclo_Obsolescencia)'];
            }
            
            
            $queryResumenIndiceObsolescencia="SELECT 
                                                    Indice_Cualitativo,
                                                    Indice_Obsolescencia,
                                                    COUNT(Indice_Cualitativo) AS cantidad 
                                            FROM 
                                                    obsolescencia 
                                            WHERE 
                                                    Ciclo_Obsolescencia = '$maxCiclo'
                                            GROUP BY 
                                                    Indice_Cualitativo";
            
            $conexionResumenIndiceObsolescencia=  mysql_query($queryResumenIndiceObsolescencia,$con);
            
        
//             while($arrayResumenIndiceObsolescencia=mysql_fetch_array($conexionResumenIndiceObsolescencia)){
//        ["<?php echo utf8_encode($arrayResumenIndiceObsolescencia['Indice_Cualitativo']);  ?> <?php //echo $arrayResumenIndiceObsolescencia['cantidad']; ],         
       // }         
            ?>
      <br/>
      <br/>
           
            
        <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      <?php
      while($arrayResumenIndiceObsolescencia=mysql_fetch_array($conexionResumenIndiceObsolescencia)){
      ?>
        
        var data = google.visualization.arrayToDataTable([
        ["NIVEL OBSOLESCENCIA", "CANTIDAD DE EQUIPOS", { role: "style" } ],
        ["<?php echo utf8_encode($arrayResumenIndiceObsolescencia['Indice_Cualitativo']);  ?>", <?php echo $arrayResumenIndiceObsolescencia['cantidad']; ?>, "#b87333"],
      
      ]);
      <?php
      }
      ?>

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "CANTIDAD DE EQUIPOS POR NIVEL DE OBSOLESCENCIA ESTIMADO",
        width: 800,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
  
<?php  

if(isset($_POST['btn1'])|| isset($_POST['btn2'])||isset($_POST['btn3'])||isset($_POST['btn4'])){
    
    $VisualizacionGraficoObsolescencia="width: 900px; height: 300px;margin:auto;display: none;";
}else{
    
    $VisualizacionGraficoObsolescencia="width: 900px; height: 300px;margin:auto;display: block;";
}  

?>

<div id="columnchart_values" style="<?php echo $VisualizacionGraficoObsolescencia; ?>"></div>
            
        
                
                
            
           <div style="display: none">
       <form id="Formulario" method="POST" action="GrabarIndiceObsolescencia.php">
           <div style="display: inline-table;">
           <table style="float: left;margin-left: 0px;">
           <tr>
               <td>Codigo equipo</td>
               <td><input type="text" name="codigoHV" class="form-control" placeholder="" onkeyup="traerDatosObsolescencia(this.value)" required></td>
           </tr>
               <tr>
                   <td>Nombre equipo</td>
                   <td><input type="text" id="nombreEquipo" name="nombreEquipo" class="form-control" placeholder="" readonly></td>
               </tr>
               <tr>
                   <td>Marca</td>
                   <td><input id="marca" name="marca" type="text" class="form-control" placeholder="" readonly></td>
               </tr>
               <tr>
                   <td>Modelo</td>
                   <td><input id="modelo" name="modelo" type="text" class="form-control" placeholder="" readonly></td>
               </tr>    
           </table>
            <div id="mensaje" class="" style="width: 600px;margin-left: 130px;float: left;visibility: hidden">
                <strong>INDICE OBSOLESCENCIA ESTIMADO:</strong>
                <h2 id="indice"></h2>
                <label id="IndiceEstimado"></label>
                <label id="IndiceEstimado1"></label>
                <input type="hidden" value="" name="indice" id="indiceGrabar">
                <input type="button" name="grabarIndice" onclick="this.form.submit();" value="Grabar Indice">     
            </div>
           </div>
            <br/>
            
            <!--<div style="border:1px solid;padding: 10px">-->
            <table style="float: left;margin: 30px;">
                <th colspan="2" style="text-align: center;padding: 10px;font-size: 20px;color: #0B7D85;">EVALUACIÓN TÉCNICA</th>
                
                
                <tr style="text-align: center;font-size: 20px;background: #eee;font-weight: bold;"><td>CRITERIOS</td><td>RESPUESTA</td></tr>
           
                <tr>
                   <td>Disponibilidad de soporte de consumibles</td>
                   <td>
                    <select name="consumibles" id="consumibles" class="form-control">
                        <option value="">No requiere consumibles</option>
                        <option value="100">No tiene soporte de consumibles</option>
                        <option value="65">De 1 a 4 años</option>
                        <option value="30">De 5 a 7 años</option>
                        <option value="1">Mayor a 7 años</option>
                    </select>
                   </td>
               </tr>
               <tr>
                   <td>Ha tenido eventos adversos</td>
                   <td>
                       <select name="eventosAdversos" id="eventosAdversos" class="form-control">
                        <option value="1">No</option>
                        <option value="50">Menos de 2</option>
                        <option value="100">3 o más</option>
                    </select>
                   </td>
               </tr>
               <tr>
                   <td>Vida util contable (años)</td>
                   <td><input type="text" name="vidaUtilContable" id="vidaUtilContable" class="form-control" placeholder=""></td>
               </tr>
                <tr>
                   <td>Edad del equipo (años)</td>
                   <td><input type="text" name="edadEquipo" id="edadEquipo" class="form-control" placeholder=""></td>
                </tr>
               <tr>
                   <td>Relación entre la edad del equipo y la vida util contable</td>
                   <td>
                       <input type="text" name="relacionEdad" id="relacionEdad" class="form-control" placeholder="">
                   </td>
               </tr>
               <tr>
                   <td>Mantenimiento correctivo en el ultimo año</td>
                   <td>
                       <input type="text" id="CantidadFallas" name="CantidadFallas" class="form-control" value="" placeholder="" readonly>
                   </td>
               </tr>
               <tr>
                   <td>Proveedor de soporte técnico (no incluye repuestos)</td>
                   <td>
                       <select name="ProveedorIncluyeRepuestos" id="ProveedorIncluyeRepuestos" class="form-control">
                        <option value="">(-- Seleccione --))</option>
                        <option value="1">Con fábrica</option>
                        <option value="50">Otro proveedor</option>
                        <option value="100">No existe soporte técnico</option>
                    </select>
                   </td>
               </tr>
               <tr>
                   <td>Disponibilidad de soportes de repuestos (años)</td>
                   <td>    
                       <select class="form-control" name="soporteRepuestos" id="soporteRepuestos">
                        <option value="">(-- Seleccione--)</option>
                        <option value="65">Entre 1 y 4 años</option>
                        <option value="30">Entre 5 y 7 años</option>
                        <option value="1">Más 7 años</option>
                        <option value="100">No tiene soporte de respuestos</option>
                    </select>
               </td>
               </tr>
               
       </table>
                <!--</div>-->
       <table style="margin: 30px;">
           <th colspan="2" style="text-align: center;padding: 10px;font-size: 20px;color: #0B7D85;">EVALUACIÓN CLINICA</th>
           <tr style="text-align: center;font-size: 20px;background: #eee;font-weight: bold;"><td>CRITERIOS</td><td>RESPUESTA</td></tr>
           <tr>
               <td>% operabilidad del equipo</td>
               <td>
                   <select class="form-control" name="operabilidad" id="operabilidad">
                        <option value="">(-- Seleccione--)</option>
                        <option value="1">Mas del 60%</option>
                        <option value="50">Entre el 30% y 60%</option>
                        <option value="100">Menos del 30%</option>
                    </select>
               </td>
           </tr>
               <tr>
                   <td>Grado de satisfacción con el equipo</td>
                   <td>
                    <select class="form-control" name="Satisfaccion" id="Satisfaccion">
                        <option value="">(-- Seleccione--)</option>
                        <option value="1">Alto: Mas del 75%</option>
                        <option value="50">Medio: Entre el 31% y 75%</option>
                        <option value="100">Menos del 30%</option>
                    </select>
                    </td>
               </tr>
               <tr>
                   <td>Cobertura de necesidades actuales</td>
                   <td>
                       <select class="form-control" name="cobertura" id="cobertura">
                        <option value="">(-- Seleccione--)</option>
                        <option value="1">Alto: Mas del 75%</option>
                        <option value="50">Medio: Entre el 31% y 75%</option>
                        <option value="100">Menos del 30%</option>
                    </select>
                   </td>
               </tr>
       </table>
       <table style="float: left;margin: 10px;">
           <th colspan="2" style="text-align: center;padding: 10px;font-size: 20px;color: #0B7D85;">EVALUACION ECONOMICA</th>
           <tr style="text-align: center;font-size: 20px;background: #eee;font-weight: bold;"><td>CRITERIOS</td><td>RESPUESTA</td></tr>
           <tr><td>Inversion Adquisición</td>
               <td><input type="text" name="inversionAdquisicion" id="inversionAdquisicion" class="form-control" placeholder=""></td>
           </tr>
               <tr>
                   <td>Costo Manto/año</td>
                   <td><input type="text" name="CostoManto" id="CostoManto" class="form-control" placeholder=""></td>
               </tr>
               <tr>
                   <td>Relacion Inversion/costo-año</td>
                   <td><input type="text" name="relacionCostoInversion" id="relacionCostoInversion" class="form-control" placeholder=""></td>
               </tr>
       </table>
           
       </form>
                </div>
            
            <br/>
            
            <!-- TABLA QUE RELACIONA LA LISTA DE OBSOLESCENCIA POR EQUIPO  -->
            
<!--            <div id="respDetalle"></div>-->
            

            <script type="text/javascript">
                $(document).ready(function(){
                $("#tablaDetalleEquiposNivelObsolescencia").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            },
            
                });
            });
            </script>
                
            <?php
            $con=  conectar();
            
            if(isset($_POST['btn1'])){
                $ciclo=$_POST['cicloSeleccionado'];
                $nivelObsolescencia=1;
                $EstiloNivel="class='alert alert-success'";
                
            }
            if(isset($_POST['btn2'])){
                $ciclo=$_POST['cicloSeleccionado'];
                $nivelObsolescencia=2;
                $EstiloNivel="class='alert alert-info'";
                
            }
            if(isset($_POST['btn3'])){
                $ciclo=$_POST['cicloSeleccionado'];
                $nivelObsolescencia=3;
                $EstiloNivel="class='alert alert-warning'";
            }
            if(isset($_POST['btn4'])){
                $ciclo=$_POST['cicloSeleccionado'];
                $nivelObsolescencia=4;
                $EstiloNivel="class='alert alert-danger'";
            }
            
            if(isset($nivelObsolescencia)){
            
           
            
                if($nivelObsolescencia==1){
                $NivelO="Tecnología NO requiere evaluación ni renovación";
                }else if($nivelObsolescencia==2){
                $NivelO="Evaluar tecnología en un año";
                }else if($nivelObsolescencia==3){
                $NivelO="Renovación de tecnología a la brevedad (Plazo inferior a un año)";
                }else if($nivelObsolescencia==4){
                $NivelO="Reposición de tecnología (Inmediato)";
                }
                
                $querySeleccionarEquipos="SELECT 
                        o.Cod_Equipo, 
                        h.Nombre_Equipo, 
                        h.Tipo_Equipo, 
                        o.Indice_Obsolescencia, 
                        o.Indice_Cualitativo, 
                        o.Indice_Significado 
                FROM 
                        obsolescencia AS o 
                        JOIN hoja_vida AS h ON o.Cod_Equipo = h.No_HV 
                WHERE 
                        o.Ciclo_Obsolescencia = '$ciclo' && Indice_Cualitativo = '$NivelO' 
                GROUP BY 
                        o.Cod_Equipo";

                $conexion=mysql_query($querySeleccionarEquipos, $con);
                
                if(isset($_POST['mostrarGrafico'])){
                    $VisualizarTabla='display:none;';
                }else{
                    $VisualizarTabla='display:block;';
                }
                
                echo "<div style='$VisualizarTabla;'>";
                echo "<form method='POST' action='indiceObsolescencia.php'>";
                echo "<input class='btn btn-default' type='submit' name='mostrarGrafico' value='Mostrar grafico'>";
                echo "<form>";
                 echo "<h1 style='text-align:center;'>LISTADO DE EQUIPOS POR NIVEL DE OBSOLESCENCIA</h1>";
                 echo "<br/>";
                    echo "<label style='margin-left:30px;font-size:25px;'>No ciclo obsolescencia: $ciclo</label>";
                    
                 echo "<br/>";
                 echo "<br/>";
                echo "<table class='table table-bordered' id='tablaDetalleEquiposNivelObsolescencia' style='width:95%;margin:auto;background:white;'>";
                echo "<thead>";
                echo "<tr>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>CODIGO EQUIPO</td>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>NOMBRE EQUIPO</td>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>TIPO EQUIPO</td>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>INDICE OBSOLESCENCIA</td>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>INDICE CUALITATIVO</td>";
                echo "<td style='font-weight: bold;text-align: center;vertical-align: middle;'>INDICE SIGNIFICATIVO</td>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($arrayConexion=mysql_fetch_array($conexion)){
                    echo "<tr>";
                    echo "<td style='text-align: center;vertical-align: middle;'>".$codEquipo=$arrayConexion['Cod_Equipo']."</td>";
                    echo "<td style='text-align: center;vertical-align: middle;'>".$NombreEquipo=$arrayConexion['Nombre_Equipo']."</td>";
                    echo "<td style='text-align: center;vertical-align: middle;'>".$TipoEquipo=$arrayConexion['Tipo_Equipo']."</td>";
                    echo "<td style='text-align: center;vertical-align: middle;'>".$IndiceObsolescencia=$arrayConexion['Indice_Obsolescencia']."</td>";
                    echo "<td style='text-align: center;vertical-align: middle;' $EstiloNivel;>".$IndiceCualitativo=$arrayConexion['Indice_Cualitativo']."</td>";
                    echo "<td style='text-align: center;vertical-align: middle;' $EstiloNivel;>".$IndiceSignificativo=$arrayConexion['Indice_Significado']."</td>";
                echo "</tr>";
                }
            echo "</tbody>";
            echo "</table>";
            }
            echo "</div>";
                ?>
            

           </div>
    </body>
</html>    