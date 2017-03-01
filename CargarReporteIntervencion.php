<?php

$ruta="./Reportes_Adjunto/";
$mensaje="";

foreach($_FILES as $key){
    
    if($key['error']==UPLOAD_ERR_OK){
        
        $nombreArchivo=$key['name'];
        $temporal=$key['tmp_name'];
        $destino=$ruta.$nombreArchivo;
        move_uploaded_file($temporal,$destino);
        
    }
    
    if($key['error']==''){
        
        $mensaje.='Archivo <b>'.$nombreArchivo.'</b>Subido correctamente. <br>';
        
    }
    
    if($key['error']!=''){
        
        $mensaje.='No se pudo subir el archivo <b>'.$nombreArchivo.'</b> debido al siguinte error: \n'.$key['error'];
        
    }
    
    $queryInsertarDocumentoIntervencion="INSERT INTO documentos_intervencion (No_HV,Tipo_Intervencion,Nombre_Archivo) VALUES ('','','$destino')";
    
    
}
    
echo $mensaje;

?>        
