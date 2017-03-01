<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tipo Equipos</title>
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
    <body style="background: #FAFAFA">
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
        
        <div style="width: 40%;margin: 0 auto;background: white;border-radius: 15px;padding: 20px;">
        
            <div class="form-group" style="text-align: center;">
            
               <label style="font-size: 30px;text-align: center;font-weight: bold;">CREAR TIPOS DE EQUIPOS DEL SISTEMA</label>
            </div>
            
        <?php
        include('./conexion.php');
        $con=  conectar();
        ?>
            
            <br/>
            <form class="form-inline" method="POST" action="CrearTipoEquipos_CodHV.php">
                
        <div class="form-group" style="margin: auto;">
            <label>TIPO EQUIPO</label>
            <input type="text" name="tipoEquipo" class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label>CODIGO EQUIPO</label>
            <input type="text" name="codHV" class="form-control" placeholder="Codigo sin el consecutivo">
        </div>
            
        <button type="submit" name="crear" class="btn btn-primary">Crear</button>
        
        </form>
        
        <script type="text/javascript">
$(document).ready(function(){
    $("#tablaTipoEquipos").DataTable({
        
        "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            }
    });
});
    </script>
        
        
<table id="tablaTipoEquipos" class="table table-bordered table-hover">
    <thead>
            <tr>
                <td style="text-align: center;font-weight: bold;">TIPO EQUIPO</td>
                <td style="text-align: center;font-weight: bold;">CODIGO TIPO EQUIPO</td>
            </tr>
            <br/>
            <br/>
    </thead>
    <tbody>
       <?php
       
       if(isset($_POST['crear'])){
           
           $TipoEquipo=$_POST['tipoEquipo'];
           $CodigoHV=$_POST['codHV'];
           
           $queryInsertarTipoEquipo="INSERT INTO tipo_equipo (Tipo_Equipo,Codigo_Equipo) VALUES ('$TipoEquipo','$CodigoHV')";
           $conexionInsertarTipoEquipo=mysql_query($queryInsertarTipoEquipo, $con);
       }
       
       $querySeccionarTipoEquipos="SELECT * FROM tipo_equipo WHERE 1";
       $conexionSeccionarTipoEquipos=mysql_query($querySeccionarTipoEquipos, $con);

       while($arraySeccionarTipoEquipos=  mysql_fetch_array($conexionSeccionarTipoEquipos)){
            echo "<tr>";
            echo "<td>".$arraySeccionarTipoEquipos[1]."</td>";
            echo "<td>".$arraySeccionarTipoEquipos[2]."</td>";
            echo "</tr>";
       }
        ?> 
        </tbody>
        </table>
        </div>
     </body>
     
</html>