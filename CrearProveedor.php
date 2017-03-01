<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Crear Proveedor</title>
        <link rel="stylesheet" href="./jquery/jquery-3.1.0.js">
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
    </head>
    <body style="background: #FAFAFA">
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        <a href='Menu.php' style='margin: 80px;margin-top:10px;'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Regresar al inicio</a>
        <span id="resp"></span>
        <br/>
        
        <div style="width: 500px;margin: auto;padding: 30px;margin-top: 50px;background: white;border-radius: 15px">
            <div class="form-group" style="text-align: center;">
            
               <label style="font-size: 30px;text-align: center;font-weight: bold;">CREAR PROVEEDORES DE SERVICIO</label>
            </div>
            
            <form class="form-group" method="POST" action="CrearProveedor.php">
                <tr>
                <td><label>NOMBRE PROVEEDOR</label></td>
                <td><input type="text" name="nombreProveedor" class="form-control" placeholder="nombre del proveedor" required></td>
            </tr>
            <tr>
                <td><label style="margin: 7px;">CIUDAD</label></td>
                <td><input type="text" name="ciudad" class="form-control" placeholder="ciudad" required></td>
            </tr>
            <tr>
            
                <td><label style="margin: 7px;">DIRECCIÓN</label></td>
              <td><input type="text" name="direccion" class="form-control" placeholder="direccion" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">TELEFONO</label></td>
              <td><input type="text" name="telefono" class="form-control" placeholder="telefono" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">CELULAR</label></td>
              <td><input type="text" name="celular" class="form-control" placeholder="celular" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">NOMBRE CONTACTO</label></td>
              <td><input type="text" name="nombreContacto" class="form-control" placeholder="nombre de contacto" required></td>
            </tr>

            <br/>
            <button type="submit" name="guardarProveedor" class="btn btn-success btn-lg btn-block">Crear Proveedor</button>
        </form>    
        </div>    
   
        <?php
        include ('./conexion.php');
        $con=  conectar();
        
        if(isset($_POST['guardarProveedor'])){
            
            $nombreProveedor=$_POST['nombreProveedor'];
            $ciudad=$_POST['ciudad'];
            $direccion=$_POST['direccion'];
            $telefono=$_POST['telefono'];
            $celular=$_POST['celular'];
            $nombreContacto=$_POST['nombreContacto'];
            
            
            $queryCrearProveedor="INSERT INTO informacion_proveedor(
                                                Nombre_Proveedor, Ciudad, 
                                                Direccion, Telefono, Celular, 
                                                Contacto
                                        ) 
                                        VALUES 
                                                (
                                                        '$nombreProveedor', '$ciudad', '$direccion', 
                                                        '$telefono', '$celular', '$nombreContacto'
                                                )";
            $conexionGuardarProveedor=mysql_query($queryCrearProveedor, $con);
        
            if(isset($conexionGuardarProveedor)){
                ?>
                <script>
                     alert("Proveedor creado exitosamente!");   
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
        ?>
        
    </body>
</html>