<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cuenta Usuario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosIndex.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Muli|Strait" rel="stylesheet">
        <script href="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        
        <script>
            function ingresar(){
                $("#formularioIngreso").submit();
            }
            
            
            function cambiarColorBoton(){
                
                $(document).ready(function(){
                    $("#btnEntrar").attr("class","btn btn-success btn-lg btn-block");
                    $("#textoBoton").hide();
                    $("#textBotonEntrada").attr("style","display:block");;
                    
                });
                
                
            }
            
        </script>
       
    </head>
    <body id="Cuerpo">
        
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
        
        
        <div style="height: 100px" id="margen"></div>
        
        <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div>
            
            <div id="ContornoInicioCuenta">
            <div class="form-group">
            
                <label id="textoInicio">SISTEMA DE ADMINISTRACIÓN <p style="text-decoration: underline;">DE EQUIPOS</p></label>
            </div>    
                
                
            <form method="POST" action="index.php">
                <div class="form-group">
                  <input type="text" style="height: 50px" name="usuario" class="form-control" placeholder="Nombre de usuario">
                </div>
               
                <!--Alerta Datos No corresponden-->
                <div id="AlertaDatosNoCorresponden" class="alert alert-warning alert-dismissible" role="alert" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Atención!</strong> Datos de ingreso no corresponde, vuelve a intentarlo.
              </div>
                
                <!--Alerta complete todos los campos-->
                
                <div id="AlertaCompletaDatos" class="alert alert-info alert-dismissible" role="alert" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Atención!</strong> Diligencia todos los campos.
              </div>
                
                
                
                <div class="form-group">
                  <input type="password" style="height: 50px" name="contrasena" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
                </div>
                <button id="btnEntrar" type="submit" name="entrar" class="btn #808B96 btn-lg btn-block"><p id="textoBoton">Entrar</p><p id="textBotonEntrada" style="display: none;">Entrando...</p></button>
                </form><br/>
<!--            <form>
                ¿No tiene una cuenta? <a href="CrearUsuario.php">Cree una.</a>
            </form>-->
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
        
        if(isset($usuarioCreado)!="" && $UsuarioIngresa==$usuarioCreado && $contrasenaIngresa==$contraCreada){
            ?>
        <script>
            cambiarColorBoton();
        </script>
            
            <?php
            
            
            echo "<form method='POST' action='Menu.php' id='formularioIngreso'>";
                
                
                echo "<input type='hidden' value='$usuarioCreado' name='usuario'>";
                echo "<input type='hidden' value='$contraCreada' name='contrasena'>";
            
            echo "</form>";
            ?>
                <script>
                    ingresar();
                </script>
            <?php
        
            
        }else if($UsuarioIngresa=="" && $contrasenaIngresa==""){
            
            ?>
                <script>
                $(document).ready(function(){
                    
                    $("#AlertaCompletaDatos").attr("style","display:block");
                    
                    
                    
                });
                
                
                </script>
            
            
            <?php
            
            
        }else {
             
            ?>
                <script>
                $(document).ready(function(){
                    
                    $("#AlertaDatosNoCorresponden").attr("style","display:block");
                    
                    
                    
                });
                
                
                </script>
            
            
            <?php
        }
        
        
            
        }
        ?>
                
                <footer id="piePagina" style="vertical-align: middle;text-align: center;">
                    <div>Copyright° All Right Reservec</div>
                </footer>        
    </body>
</html>
