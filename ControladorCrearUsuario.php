
<?php

include('./conexion.php');
    $con=  conectar();

    $datos=$_POST['valores'];
    $encode=json_encode($datos);
    $d=json_decode($encode);
    
        $usuario=$d[0]->value;
        $nombre=$d[1]->value;
        $apellidos=$d[2]->value;
        $cedula=$d[3]->value;
        $contrasena=$d[4]->value;
        $repetirContrasena=$d[5]->value;
        $tipoUsuario=$d[6]->value;
        $fechaCreacion="2016-03-19";
        
        if($contrasena==$repetirContrasena){
            
            $queryValidarDatosExistentes="SELECT Usuario, Cedula FROM usuarios_creados WHERE Usuario='$usuario' || Cedula='$cedula'";
            $conexionValidarDatosExistentes=mysql_query($queryValidarDatosExistentes, $con);
            
            while($arrayValidarExistentes=mysql_fetch_array($conexionValidarDatosExistentes)){
                $usuarioValidar=$arrayValidarExistentes['Usuario'];
                $cedulaValidar=$arrayValidarExistentes['Cedula'];
                }
            
          if(isset($usuarioValidar)=="" && isset($cedulaValidar)==""){
        
              $queryCrearUsuario="INSERT INTO usuarios_creados (Usuario,Nombres,Apellidos,Tipo_Usuario, Cedula,Contrasena,Fecha_Creacion) VALUES ('$usuario','$nombre','$apellidos','$tipoUsuario','$cedula','$contrasena','$fechaCreacion')";
              mysql_query($queryCrearUsuario, $con);
        
                ?>
                    <script>
                   echo json_encode("Usuario creado correctamente!");
                <?php
              
          }else if($usuarioValidar=="" && $cedulaValidar!=""){
              
              echo json_encode("La cedula registrada ya se encuentra creada");
          }else{
              echo json_encode("El usuario registrado ya se encuentra creado");
          }
          }else{
            echo json_encode("Contraseña incorrecta!!");
          }
        







?>