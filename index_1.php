<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cuenta Usuario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosIndex.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script href="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    
        <script>
            function ingresar(){
                $("#formularioIngreso").submit();
            }
        </script>
        
    
    </head>
    <body>
        
        <div class="page-header" id="encabezadoIndex">
            <h1><label style="color: white;padding: 30px;">METROLOGIC</label> <small style="color: white"></small></h1>
            </div>
            <br/>
            <br/>
            <br/>
        
            <img src="images/Logo.png" style="float: left;margin-left:300px;">
        
            <div id="ContornoInicioCuenta" style="float: right;margin-right: 500px;">
            <form method="POST" action="index.php">
                <div class="form-group">
                  <label>USUARIO</label>
                  <input type="text" style="height: 50px" name="usuario" class="form-control" placeholder="nombre de usuario">
                </div>
                <div class="form-group">
                  <label>CONTRASEÑA</label>
                  <input type="password" style="height: 50px" name="contrasena" class="form-control" id="exampleInputPassword1" placeholder="contraseña">
                </div>
                <button id="btnEntrar" type="submit" name="entrar" class="btn btn-warning btn-lg btn-block">Entrar</button>
            </form><br/>
            <form>
                ¿No tiene una cuenta? <a href="CrearUsuario.php">Cree una.</a>
            </form>
        </div>
        
        <div id="index"></div>
        
        <?php
        include('./conexion.php');
        $con=  conectar();
        session_start();
        $_SESSION['usuario']="";
        
        if(isset($_POST['entrar'])){
            
            $UsuarioIngresa=$_POST['usuario'];
            $contrasenaIngresa=$_POST['contrasena'];
            
            
        $queryUsuario="SELECT Usuario,Contrasena FROM usuarios_creados WHERE Usuario='$UsuarioIngresa'";    
        $conexionDatosUsuario=mysql_query($queryUsuario, $con);
        while($arrayDatosUsuario=mysql_fetch_array($conexionDatosUsuario)){
            $usuarioCreado=$arrayDatosUsuario['Usuario'];
            $contraCreada=$arrayDatosUsuario['Contrasena'];
        }
        
        if(isset($usuarioCreado)!="" && $UsuarioIngresa==isset($usuarioCreado) && $contrasenaIngresa==isset($contraCreada)){
            
            
            echo "<form method='POST' action='Menu.php' id='formularioIngreso'>";
                echo "APROBADO";
                echo "<input type='hidden' value='$usuarioCreado' name='usuario'>";
                echo "<input type='hidden' value='$contraCreada' name='contrasena'>";
            
            echo "</form>";
            ?>
                <script>
                    ingresar();
                </script>
            <?php
        
            
        }else if($UsuarioIngresa=="" && $contrasenaIngresa==""){
            
            echo "Ingresa Consulta";
        }else {
            echo "Datos no corresponden, vuelva a intentar";
        }
        
        
            
        }
        ?>
    </body>
</html>
