<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ubicaciones</title>
        <link rel="stylesheet" href="estilos.css">
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
    <body style="background: #F4F4F4;">
        
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        <a href='Menu.php' style='margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        
        <br/>
        <br/>
        <br/>
        
        <div style="width: 50%;margin: 0 auto;background: white;border-radius: 15px;padding: 30px;">
        <div class="form-group" style="text-align: center;">
            <label style="font-size: 30px;text-align: center;font-weight: bold;">CREAR UBICACIÓN DE EQUIPOS</label>
        </div>
            
        <?php
        include('./conexion.php');
        $con=  conectar();
        ?>
            
            <br/>
            <form class="form-inline" method="POST" action="CrearUbicacion.php">
                
        <div class="form-group">
            <label>CIUDAD</label>
            <input type="text" name="txtSede" class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label>SEDE</label>
            <input type="text" name="txtArea" class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label>ÁREA</label>
            <input type="text" name="txtSubArea" class="form-control" placeholder="">
        </div>
            
        <button type="submit" name="crear" class="btn btn-primary">Crear</button>
        
        </form>
        
        <script type="text/javascript">
$(document).ready(function(){
    $("#tablaUbicaciones").DataTable({
        
        "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
    });
});
    </script>
        
        
<table id="tablaUbicaciones" class="table table-bordered table-hover">
    <thead>
            <tr>
                <td style="text-align: center;font-weight: bold;">CIUDAD</td>
                <td style="text-align: center;font-weight: bold;">SEDE</td>
                <td style="text-align: center;font-weight: bold;">ÁREA</td>
            </tr>
            <br/>
            <br/>
    </thead>
    <tbody>
       <?php
       
       if(isset($_POST['crear'])){
           
           $Sede=$_POST['txtSede'];
           $Area=$_POST['txtArea'];
           $SubArea=$_POST['txtSubArea'];
           
           $queryInsertarUbicaciones="INSERT INTO ubicaciones (Sede,Area,Sub_Area) VALUES ('$Sede','$Area','$SubArea')";
           $conexionUbicaciones=mysql_query($queryInsertarUbicaciones, $con);
       }
       
       $querySeccionarUbicaciones="SELECT * FROM ubicaciones WHERE 1";
       $conexionUbicaciones=mysql_query($querySeccionarUbicaciones, $con);

       while($arraySeccionarUbicaciones=  mysql_fetch_array($conexionUbicaciones)){
            echo "<tr>";
            echo "<td>".$arraySeccionarUbicaciones[1]."</td>";
            echo "<td>".$arraySeccionarUbicaciones[2]."</td>";
            echo "<td>".$arraySeccionarUbicaciones[3]."</td>";
            echo "</tr>";
       }
        ?> 
        </tbody>
        </table>
        </div>
     </body>
     
</html>