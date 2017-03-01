<?php
include('./conexion.php');
$con=  conectar();
  // CONTROLADOR CARGAR IMAGEN DEL EQUIPO
if(isset($_FILES['archivo'])){
    $file=$_FILES['archivo'];
    $nombreImagen=$file['name'].date('H i s');
    $tipo=$file['type'];
    $temporal=$file['tmp_name'];
    $ruta="./tmp/";
    $destino=$ruta.$nombreImagen;
   // move_uploaded_file($temporal, $destino);
    
    echo json_encode($destino);
    
//    echo "<img src='$destino'>";
//    echo "<input type='hidden' name='nombreRuta' value='$destino'>";

    
}


//            $codHV=$_POST['valora'];
//            echo json_encode($codHV);
            
//                $directorio='./ImagenEquipos/';
//                $mensaje="";
//    
//                $hv="";
//                
//                foreach ($_FILES as $key){
//                    
//                if($key['error']==UPLOAD_ERR_OK){
//                    
//                    $nombreOriginal=$key['name'];
//                    $temporal=$key['tmp_name'];
//                    $destino=$directorio.$nombreOriginal;
//                    move_uploaded_file($temporal, $destino);
//                
//                if($key['error']==''){
//                $mensaje= "Archivo <b>".$nombreOriginal."</b>";    
//                }
//                if($key['error']!=''){
//                    
//                $mensaje= "No se pudo subir <b>".$nombreOriginal."</b>";    
//                }    
//                echo $mensaje;
//                }
//                }
//                
//                
//                $queryInsertarImagenEquipo="INSERT INTO imagenes_equipos VALUES ('','$hv','$destino')";
//                mysql_query($queryInsertarImagenEquipo, $con);
                
                
                //@opendir($directorio);
//                $nombreImagenEquipo=$_FILES['reporte']['name'];
//                $destinoImagenEquipo=$directorio.$_FILES['reporte']['name'];
//                $nombreTemporalImagenEquipo=$_FILES['reporte']['tmp_name'];
//                //$ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
//                move_uploaded_file($nombreTemporalImagenEquipo,$destinoImagenEquipo);               
//                
//                if(isset($codHV)){
//                //$hv=;
//                $hv=$codHV;
//                }{
//                    $hv="HV 2";
//                    
//                }
//                
//                $queryExisteImagen="SELECT No_HV FROM Imagenes_Equipos WHERE No_HV='$hv'";
//                $conexionExisteHV=mysql_query($queryExisteImagen, $con);
//                while($ArrayExisteHV=mysql_fetch_array($conexionExisteHV)){
//                    $ExisteArray=$ArrayExisteHV[0];
//                }
//                if(isset($ExisteArray)==""){
//                $queryInsertarDocumento="INSERT INTO Imagenes_Equipos VALUES ('','$hv','$destinoImagenEquipo')";
//                mysql_query($queryInsertarDocumento, $con);
//                    }
                
?>
