<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Crear usuario</title>
        <link rel="stylesheet" href="./jquery/jquery-3.1.0.js">
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTable/css/dataTables.bootstrap.css">
        <script src="DataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="DataTable/css/dataTables.material.min.css">
        <script src="DataTable/js/dataTables.bootstrap.min.js"></script>
        <script src="crearUsuario.js"></script>

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
            
               <label style="font-size: 30px;text-align: center;font-weight: bold;">CREAR USUARIOS DEL SISTEMA</label>
            </div>
            
            <form class="form-group" method="POST" action="CrearUsuario.php" id="formularioCreacionUsuario">
                <tr>
                <td><label>USUARIO</label></td>
                <td><input type="text" name="usuario" class="form-control" placeholder="código de usuario" required></td>
            </tr>
            <tr>
                <td><label style="margin: 7px;">NOMBRES</label></td>
                <td><input type="text" name="nombre" class="form-control" placeholder="nombres" required></td>
            </tr>
            <tr>
            
                <td><label style="margin: 7px;">APELLIDOS</label></td>
              <td><input type="text" name="apellido" class="form-control" placeholder="apellidos" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">CEDULA</label></td>
              <td><input type="text" name="cedula" class="form-control" placeholder="cedula" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">CONTRASEÑA</label></td>
              <td><input type="text" name="contrasena" class="form-control" placeholder="contraseña" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">REPITA CONTRASEÑA</label></td>
              <td><input type="text" name="repetircontrasena" class="form-control" placeholder="repita contraseña" required></td>
            </tr>
            <tr>
              <td><label style="margin: 7px;">TIPO USUARIO</label></td>  
              <td><select name="tipoUsuario" class="form-control">
                    <option value="Administrador">Administrador</option>
                    <option value="Funcional">Funcional</option>
                    <option value="Consulta" selected>Consulta</option>
                </select></td>
              
            </tr><br/>
            <button type="submit" name="guardarUsuario" onclick="crearUsuario();" class="btn btn-success btn-lg btn-block">Crear Usuario</button>
        </form>    
        </div>    
   
    </body>
</html>