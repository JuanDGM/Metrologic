<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario de Equipos</title>
        <link rel="stylesheet" href="EstilosInventario.css">
        <script src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
    </head>
    <body>
        
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        <div id="ContenerdorLogo">
            
           <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div>  
          
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
      
          <p>estas son estadisticas</p>
          
      
      </div>
    </div>
  </div>
  </div>
           
           
        </div>
        <div id="ContenedorInventario">
        
            
        
        <div class="page-header" id="encabezadoinicio">
                 <div style="float: left">
            <h1 style="font-weight: bold;margin-left:5%;margin-top: 90px;">INVENTARIO DE EQUIPOS</h1>
            </div>
            <div style="float: right;margin-top: 30px;margin-right: 40px;">
            <a href="Menu.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Regresar al inicio</a>
             </div>
             </div>
            <br/>
        
        
        
         <div id="contorno1">
            <?php
           include ('./conexion.php');  
        $con = conectar();
        $queryInventario= "SELECT 
	h.Id, 
	h.No_HV, 
	h.Nombre_Equipo, 
	p.Sede, 
	p.Area, 
	p.SubArea, 
	p.Fecha_Marcha, 
	p.Fecha_Descarte,
        f.Ruta 
FROM 
	hoja_vida AS h 
	LEFT JOIN puesta_marcha AS p ON h.No_HV = p.No_HV 
	LEFT JOIN imagenes_equipos AS f ON h.No_HV = f.No_HV 
WHERE 
     p.Fecha_Descarte='0000-00-00' && 	
CONCAT(p.No_HV, p.Version) IN (
		SELECT 
			CONCAT(
				p.No_HV, 
				MAX(p.Version)
			) 
		FROM 
			puesta_marcha AS p 
		GROUP BY 
			p.No_HV
	)  
GROUP BY 
	h.No_HV";
        $conexionInventario=mysql_query($queryInventario, $con); 

?>
        
            
            <script type="text/javascript">
                $(document).ready(function(){
                $("#TableInventarioEquipos").DataTable({
                 
                 "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
                 
                });
            });
            </script>
            
            
             <table class="table table-bordered" id="TableInventarioEquipos">
                 <thead>                 
            <tr style="background: #C9D6DF">
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">Imagen del Equipo</td>
                <td style="width: 70px;vertical-align: middle;text-align: center;font-weight: bold;">Cod Equipo</td>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">Nombre Equipo</td>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ciudad</td>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">Sede</td>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">Area</td>
                <td style="width: 80px;vertical-align: middle;text-align: center;font-weight: bold;">Fecha Puesta Marcha</td>
                <td style="width: 80px;vertical-align: middle;text-align: center;font-weight: bold;">Ir a Hoja de vida</td>
            </tr>
            </thead>
            <tbody>
             

<?php

while($arrayInventarioEquipos=mysql_fetch_array($conexionInventario)){

    $id=$arrayInventarioEquipos['Id'];
    echo "<td style='width:90px;' align='center'><image src='".$arrayInventarioEquipos['Ruta']."' style='width:50px;'></td>";
    echo "<td>".$arrayInventarioEquipos['No_HV']."</td>";
    echo "<td>".$arrayInventarioEquipos['Nombre_Equipo']."</td>";
    echo "<td>".$arrayInventarioEquipos['Sede']."</td>";
    echo "<td>".$arrayInventarioEquipos['Area']."</td>";
    echo "<td>".$arrayInventarioEquipos['SubArea']."</td>";
    echo "<td>".$arrayInventarioEquipos['Fecha_Marcha']."</td>";
    
    
       echo "<td style='width:50px;font-size:20px;' align='center'>";
    echo "<form id='formularioedicion' method='POST' action='hojaVida.php'>";
    
        echo "<input type='hidden' value='none' name='desInventario'>";       
        echo "<input type='hidden' name='idseleccionado1' value='$id'>";
       
        echo "<button type='submit' id='idseleccionado' class='btn btn-info'><span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
    echo "</td>";   
    echo "</form>";
    
    echo "</tr>";
}

?>
                </tbody>
</table>
    </div>
            
            </div>
    </body>
</html>
        