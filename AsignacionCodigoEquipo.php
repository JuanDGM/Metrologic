<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asignacion codigo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosAsignacionCodigoHV.css">
        <script  src="./jquery/jquery-3.1.0.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="asignarCodigo.js"></script>
    </head>
    <body
        
        
        <!--  ESTE CLASE NO SE ESTA UTILIZANDO   -->
        <!--  ESTE CODIGO ESTA ESCRITO EN hojaVida.php   -->
        
        
        <?php
            require_once './conexion.php';
            $con=  conectar();
            require_once './regresar.php';
            Regresar();
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
                            <input type="text" id="inputModificar" class="form-control" name="CodHVEnviado">
                        </div>
                    </td>
                </tr>
                <tr>
                    
                    <td><button type="submit" name="CrearEquipo" class="btn btn-primary">Crear</button></td>
                    <td><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></td>
                
                </tr>
            </table>
        </div>
        
        </form>
    </body>
</html>