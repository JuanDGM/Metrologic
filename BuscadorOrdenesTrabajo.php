<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title style="font-weight: bold;">Buscador ordenes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosBuscadorOrdenes.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include ('./conexion.php');
        $con=  conectar();
        $time=  time();
        $fecharegistro=date("Y-m-d", $time);
        
        // FILTRO VIGENCIA ORDENES
        
        if(isset($_POST['filtrar'])){
            $FiltroVigencia=$_POST['SeleccionVigencia'];
        
            if($FiltroVigencia=="Vigente"){
                $variableQueryFiltro="Fecha_Programada>='$fecharegistro'";
                
            }else if($FiltroVigencia=="Vencido"){
                $variableQueryFiltro="Fecha_Programada<'$fecharegistro'";
            }else{
                $variableQueryFiltro=1;
            }
            
            $FiltroEstado=$_POST['SeleccionEstado'];
            if($FiltroEstado=='Pendiente'){
                $variableQueryFiltroEstado="Estado='Pendiente'";
            }else if($FiltroEstado=='Finalizado'){
                $variableQueryFiltroEstado="Estado='Finalizado'";
            }else{
                $variableQueryFiltroEstado=1;
            }
            
        }else{
            $variableQueryFiltro=1;
            $variableQueryFiltroEstado=1;
            //$variableQueryFiltroEstado="Estado='Pendiente'";
            $FiltroEstado='Pendiente';
                
        }
        
//        $querySeleccionOrdenes="SELECT 
//	Nombre_Proveedor, 
//	Cod_Servicio, 
//	Fecha_Solicitud, 
//	Fecha_Programada, 
//	COUNT(Tipo_Intervencion) AS TOTAL_EQUIPOS FROM programacion_intervencion WHERE Fecha_Realizacion='0000-00-00'
//        
//FROM 
//	programacion_intervencion 
//WHERE 
//	$variableQueryFiltro && $variableQueryFiltroEstado 
//GROUP BY 
//	Nombre_Proveedor, 
//	Cod_Servicio";
//        
        ///
        
        $querySeleccionOrdenesTODOS="SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada, 
	COUNT(Tipo_Intervencion) AS TOTAL_EQUIPOS, 
	SUM(
		IF(
			Fecha_Realizacion <> '0000-00-00', 
			0, 1
		)
	) as Pendiente
FROM 
	programacion_intervencion 
WHERE 
	$variableQueryFiltro && $variableQueryFiltroEstado
GROUP BY 
	Nombre_Proveedor, 
	Cod_Servicio";
       
        
        
$querySeleccionOrdenesPENDIENTES="SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada,
    TOTAL_EQUIPOS,
    Pendiente
    
    FROM 
(SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada, 
	COUNT(Tipo_Intervencion) AS TOTAL_EQUIPOS, 
	SUM(
		IF(
			Fecha_Realizacion <> '0000-00-00', 
			0, 1
		)
	) as Pendiente
    
FROM 
	programacion_intervencion 
WHERE 
	$variableQueryFiltro && 1
GROUP BY 
	Nombre_Proveedor, 
	Cod_Servicio) AS BD
    
    WHERE Pendiente>0";
        

$querySeleccionOrdenesFINALIZADAS="SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada,
    TOTAL_EQUIPOS,
    Pendiente
    
    FROM 
(SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada, 
	COUNT(Tipo_Intervencion) AS TOTAL_EQUIPOS, 
	SUM(
		IF(
			Fecha_Realizacion <> '0000-00-00', 
			0, 1
		)
	) as Pendiente
     
FROM 
	programacion_intervencion 
WHERE 
	$variableQueryFiltro && 1
GROUP BY 
	Nombre_Proveedor, 
	Cod_Servicio) AS BD
    
    WHERE Pendiente=0";

        
if($FiltroEstado=='Pendiente'){
    $querySeleccionOrdenes=$querySeleccionOrdenesPENDIENTES;
}else if($FiltroEstado=='Finalizado'){
    $querySeleccionOrdenes=$querySeleccionOrdenesFINALIZADAS;
}else{
    $querySeleccionOrdenes=$querySeleccionOrdenesTODOS;
}
        
    $conexionSeleccionOrdenes=mysql_query($querySeleccionOrdenes, $con);
        
        ?>
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
    <div id="contorno">
        <div class="page-header" id="encabezadoOrdenes">
            <div style="float: left;">
                <h1 id="titulo">BUSCADOR DE ORDENES DE TRABAJO <small></small></h1>
            </div>
            <div style="float: right;margin-top: 30px;">
            <a href='Menu.php' style='margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        </div>
        </div>

        
        <form method="POST" action="BuscadorOrdenesTrabajo.php" id="FormularioListaOrdenes">
        <table>
        <tr>
            <td>ESTADO ORDENES</td>
            <td>
                <?php
                
                    if(isset($_POST['SeleccionEstado'])){
                        
                        $EstadoSeleccionado=$_POST['SeleccionEstado'];
                        
                    }else{
                        $EstadoSeleccionado="Pendiente";
                        
                    }
                
                ?>
                <select class="form-control" name="SeleccionEstado" style="width: 150px">
                    <option value="<?php echo $EstadoSeleccionado; ?>"><?php echo $EstadoSeleccionado; ?></option>  
                        <option value="Todas">Todas</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Finalizado">Finalizado</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>VIGENCIA ORDENES</td>
            <?php
                    if(isset($_POST['SeleccionVigencia'])){
                        $VigenciaSeleccionado=$_POST['SeleccionVigencia'];
                    }else{
                        $VigenciaSeleccionado="Todas";
                    }
                ?>
            <td><select class="form-control" name="SeleccionVigencia" style="width: 150px">
               <option><?php echo $VigenciaSeleccionado; ?></option>
               <option value="Todas">Todas</option>
                <option value="Vencido">Vencido</option>
                <option value="Vigente">Vigente</option>
            </select></td>
        </tr>
        <tr>
        <td><input type="submit" name="filtrar" class="btn btn-primary"></td>
        </tr>
        </table>
        </form>
        <br/>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#tableBusquedaOrdenes").DataTable({
                    "language":{
                        "search": "Busqueda Rapida",
                        "info": "Mostrando pagina _PAGE_ de _PAGES_",
                        }
                });
            });
        </script>
        <div id="DisplayOrdenador">
    <!--<div class="table-responsive">-->
    <table id="tableBusquedaOrdenes" class="table table-bordered">
        <thead>
            <tr style="background: #eee;text-align: center;font-size: 18px;font-weight: bold;">
                <td style="vertical-align: middle;">PROVEEDOR</td>
                <td style="vertical-align: middle;">No ORDEN</td>
                <td style="vertical-align: middle;">FECHA SOLICITUD</td>
                <td style="vertical-align: middle;">FECHA PROGRAMADA</td>
                <td style="vertical-align: middle;">No INTERVENCIONES PROGRAMADAS</td>
                <td style="vertical-align: middle;">No INTERVENCIONES PENDIENTES</td>
                <td style="vertical-align: middle;">% EJECUCIÓN</td>
                <td style="vertical-align: middle;">ESTADO ORDEN</td>
                <td style="vertical-align: middle;">VIGENCIA ORDEN</td>
            </tr>
        </thead>
        <tbody>
            <?php
                
//            echo $Estado="<a href='OrdenTrabajoProveedor.php?id=$codigoHVProgramacion' style='color:white;'>Programado! No Orden:".$codigoHVProgramacion."</a>";
            $codigoHVProgramacion=1;
            while($arrayOrdeneTrabajo= mysql_fetch_array($conexionSeleccionOrdenes)){
                $codServicio=$arrayOrdeneTrabajo['Cod_Servicio'];
                echo "<tr>";
                    echo "<td style='width: 140px;font-size:19px;text-align:center;'>".$arrayOrdeneTrabajo['Nombre_Proveedor']."</td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'><a href='OrdenTrabajoProveedor.php?id=".$arrayOrdeneTrabajo['Cod_Servicio']."'>".$arrayOrdeneTrabajo['Cod_Servicio']."</a></td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'>".$arrayOrdeneTrabajo['Fecha_Solicitud']."</td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'>".$arrayOrdeneTrabajo['Fecha_Programada']."</td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'>".$arrayOrdeneTrabajo['TOTAL_EQUIPOS']."</td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'>".$arrayOrdeneTrabajo['Pendiente']."</td>";
                    //echo "<td style='width: 40px;'>".$cp."</td>";
                    echo "<td style='width: 40px;font-size:19px;text-align:center;'>";
                    $numeroPorcentaje=(($arrayOrdeneTrabajo['TOTAL_EQUIPOS']-$arrayOrdeneTrabajo['Pendiente'])/$arrayOrdeneTrabajo['TOTAL_EQUIPOS'])*100;
                    $PorcentajeAproximado=round($numeroPorcentaje,2);
                    echo $PorcentajeFormato=$PorcentajeAproximado."%";
                    echo "</td>";
                        if($numeroPorcentaje==0){ 
                            echo "<td style='background: red;color:white;width: 150px;font-size:19px;text-align:center;'>Orden no comenzada</td>";
                        }else if($numeroPorcentaje==100){
                            echo "<td style='background: green;color:white;width: 150px;font-size:19px;text-align:center;'>Orden finalizada</td>";
                        }else{
                            echo "<td style='background: yellow;width: 150px;font-size:19px;text-align:center;'>Orden en desarrollo</td>";
                        }
                        $time=  time();
                        $fecharegistro=date("Y-m-d", $time);
                        
                        if($fecharegistro<=$arrayOrdeneTrabajo['Fecha_Programada']){
                            echo "<td style='color: green;width:60px;font-size:19px;text-align:center;'>Vigente</td>";
                            
                        }else {
                            echo "<td style='color:red;width:60px;font-size:19px;text-align:center;'>Vencido</td>";
                        }
                        echo "</td>";
                        echo "</tr>";
                        
                        }
            ?>
        </tbody>
    </table>
    </div>   
    </div>   
        
        <!--TABLA PARA CELULARES-->
        
        <div id="DisplayCelular">
       <?php      
            
       $querySeleccionOrdenes="SELECT 
	Nombre_Proveedor, 
	Cod_Servicio, 
	Fecha_Solicitud, 
	Fecha_Programada, 
	COUNT(Tipo_Intervencion) AS TOTAL_EQUIPOS, 
	SUM(
		IF(
			Fecha_Realizacion <> '0000-00-00', 
			0, 1
		)
	) as Pendientes 
FROM 
	programacion_intervencion 
WHERE 
	$variableQueryFiltro && $variableQueryFiltroEstado
GROUP BY 
	Nombre_Proveedor, 
	Cod_Servicio";
        
       
        $conexionSeleccionOrdenes=mysql_query($querySeleccionOrdenes, $con);      
            
        
        
//       $codServicio=$arrayOrdeneTrabajo['Cod_Servicio'];
//                    $queryCantEquiposPendientes="SELECT 
//                                                    count(Fecha_Realizacion) AS Equipos_Pendientes 
//                                            FROM 
//                                                    programacion_intervencion 
//                                            WHERE 
//                                                    Fecha_Realizacion = '0000-00-00' && Cod_Servicio='$codServicio' 
//                                            GROUP BY 
//                                                    Cod_Servicio";
//                $conexionCantEquiposPendientes=mysql_query($queryCantEquiposPendientes, $con);
//                    while($arrayCantEquiposPendientes=mysql_fetch_array($conexionCantEquiposPendientes)){
//                        $CantPendientes=$arrayCantEquiposPendientes['Equipos_Pendientes'];
//                    } 
                    
                    
            
       $i=0;    
        echo "<div class='list-group'>";
       while($arrayOrden=mysql_fetch_array($conexionSeleccionOrdenes)){
       $i++;
       
       //$id=$arrayOrden['Id'];
       
       
       $numeroPorcentaje=(($arrayOrden['TOTAL_EQUIPOS']-$arrayOrden['Pendientes'])/$arrayOrden['TOTAL_EQUIPOS'])*100;
        $PorcentajeAproximado=round($numeroPorcentaje,2);
       
        
        if($PorcentajeAproximado==100){
                     $estado="Finalizado";   
                    }else{
                    $estado="Pendiente";
                    }
        
       
        echo "<a href='OrdenTrabajoProveedor.php?id=".$arrayOrden['Cod_Servicio']."' class='list-group-item'>";
        echo "<h4 class='list-group-item-heading'>No Orden:<strong>".$arrayOrden['Cod_Servicio']."</strong> Proveedor: <strong>".$arrayOrden['Nombre_Proveedor']."</strong></h4>";
        echo "<p class='list-group-item-text'><label>F. Programada: </label>".$arrayOrden['Fecha_Programada']."<label>Cant. Intervenciones: </label>".$arrayOrden['TOTAL_EQUIPOS']."</p>";    
        echo "<p class='list-group-item-text'><label># Intervenciones Pendientes: </label>".$arrayOrden['Pendientes']."<label>Estado: </label>".$estado."</p>";    
        
        
        echo "</a>";
       }
        echo "</div>";
        ?>
            
            
            
        </div>    
        
</body>
</html>