

<?php


         

           $directorio='./Reportes_Adjunto/';
           //@opendir($directorio);
           $nombreArchivo=$_FILES['reporte']['name'];
           $destinoArchivo=$directorio.$_FILES['reporte']['name'];
           $nombreTemporalArchivo=$_FILES['reporte']['tmp_name'];
           //$ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
           move_uploaded_file($nombreTemporalArchivo,$destinoArchivo);               
       
           $queryInsertarDocumento="INSERT INTO documentos_intervencion (No_HV,Tipo_Intervencion,Nombre_Archivo) VALUES ('HV 1','Calibracion','$destinoArchivo')";
           mysql_query($queryInsertarDocumento, $con);
           
         



?>