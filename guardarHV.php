<?php
require_once './conexion.php';
$con=conectar();
// este post viene de crearhvajax.js
$codHV=$_POST['datosformulario'];
$codHV_encode1= json_encode($codHV);

$codHV_decode= json_decode($codHV_encode1);
$nohv = $codHV_decode[3]->value;

$consultavalidacion="SELECT No_HV FROM hoja_vida WHERE No_HV='$nohv'";
$datos=mysql_query($consultavalidacion, $con);
$respuesta="";
while($validacion=mysql_fetch_array($datos)){
    $respuesta=$validacion['No_HV'];
    }

if($respuesta!=$nohv){
       
$datosformulario=$_POST['datosformulario'];
$datosencode = json_encode($datosformulario);
$decode = json_decode($datosencode);
  
  $ruta=$decode[2]->value;  
  $nohv = $decode[3]->value;
  $tipoequipo= $decode[4]->value;
  $nombreequipo= $decode[5]->value;
  $nombreproveedor= $decode[6]->value;
  $version=1;
  $nombremodelo= $decode[7]->value;
  $serie = $decode[8]->value;
  $marca= $decode[9]->value;
  $voltaje = $decode[10]->value;
  $amperaje = $decode[11]->value;
  $potencia = $decode[12]->value;
  $caracteristicas= $decode[13]->value;
  
  $RazonSocialProveedor= $decode[14]->value;
  $nitProveedor= $decode[15]->value;
  $CiudadProveedor= $decode[16]->value;
  $DireccionProveedor= $decode[17]->value;
  $telefonoProveedor= $decode[18]->value;
  $CelularProveedor= $decode[19]->value;
  $registroInvima= $decode[20]->value;
  $inversion= $decode[21]->value;
  $edadEquipo= $decode[22]->value;
  $VidaContable= $decode[23]->value;
  $dispSoporteRepuestos= $decode[24]->value;
  $DispoSoporteConsumibles= $decode[25]->value;
  $DispoSoporteTecnicoRepuestos= $decode[26]->value;
          
          
  $time=  time();
  $fechasistema=date("Y-m-d", $time);
          
//    $consultainsertarhv;
//    sprintf($consultainsertarhv, $datosformulario[0],$datosformulario[1],$datosformulario[2],$datosformulario[3],$datosformulario[4],$datosformulario[5],$datosformulario[6],$datosformulario[7],$datosformulario[8],$datosformulario[9],$datosformulario[10],$datosformulario[11],$datosformulario[12],$datosformulario[13]);

  
  
  
  
  $insertarRutaImagenEquipo="INSERT INTO imagenes_equipos (No_HV, Ruta) VALUES ('$nohv','$ruta')";
  mysql_query($insertarRutaImagenEquipo, $con);  
  
//              if(isset($ruta)){
//    $file=$_FILES['archivo'];
//    $nombreImagen=$file['name'];
//    $tipo=$file['type'];
//    $temporal=$file['tmp_name'];
//    $ruta="./ImagenEquipos/";
//    $destino=$ruta.$nombreImagen;
//    move_uploaded_file($temporal, $destino);
//    
//    $mask = "*.*";
//   array_map( "unlink", glob( $mask ) );
//    
//    echo json_encode($destino);
//    
//
//    
//}
  
  
  $consultainsertarhv = "INSERT INTO hoja_vida (No_HV,
                                                Version,
                                                Tipo_Equipo,
                                                Nombre_Equipo, 
                                                Nombre_Proveedor, 
                                                Modelo, 
                                                No_Serie,
                                                Marca,
                                                Voltaje,
                                                Amperaje,
                                                Potencia,
                                                Caracteristicas,
                                                Razon_SocialProveedor,
                                                Nit_Proveedor,
                                                Ciudad_Proveedor,
                                                Direccion_Proveedor,
                                                Telefono_Proveedor,
                                                Celular_Proveedor,
                                                Registro_Invima,
                                                Inversion,
                                                Edad_Equipo,
                                                Vida_Contable,
                                                Disp_Soporte_Repuestos,
                                                Disp_Soporte_Consumibles,
                                                Soporte_Tecnico_Respuestos,
                                                Fecha_CreacionHV) VALUES 
                                                ('$nohv',
                                                 '$version',
                                                '$tipoequipo',
                                                '$nombreequipo',
                                                '$nombreproveedor',
                                                '$nombremodelo',
                                                '$serie',
                                                '$marca',
                                                '$voltaje',
                                                '$amperaje',
                                                '$potencia',
                                                '$caracteristicas',
                                                '$RazonSocialProveedor',
                                                '$nitProveedor',
                                                '$CiudadProveedor',
                                                '$DireccionProveedor',
                                                '$telefonoProveedor',
                                                '$CelularProveedor',
                                                '$registroInvima',
                                                '$inversion',
                                                '$edadEquipo',
                                                '$VidaContable',
                                                '$dispSoporteRepuestos',
                                                '$DispoSoporteConsumibles',
                                                '$DispoSoporteTecnicoRepuestos',
                                                '$fechasistema')";
  $datosguardados=mysql_query($consultainsertarhv, $con);
    
  // -----  CONFIRMACION DE REGISTRO EXITOSO
    
    if(isset($datosguardados)){
       echo json_encode("SE CREO LA HOJA DE VIDA EXITOSAMENTE!!");  
          
    } else {
        echo json_encode("NO SE GUARDO LA HOJA DE VIDA");
    }
    
    // UBICACIÓN Y PUESTA EN MARCHA
                        $Sede=$decode[27]->value; 
                        $Area=$decode[28]->value; 
                        $SubArea=$decode[29]->value; 
                        $fecha_marcha=$decode[30]->value; 
                        $fecha_Descarte=$decode[31]->value; 

                        //if($ubicacion!="" && $fecha_marcha!=""){

                            if($Area!=""){
                            $queryubicacion="INSERT INTO puesta_marcha (No_HV, Version,Sede,Area,SubArea,Fecha_Marcha,Fecha_Descarte) VALUES ('$nohv','$version','$Sede','$Area','$SubArea','$fecha_marcha','$fecha_Descarte')";
                            $datosubicacion=mysql_query($queryubicacion, $con);
                            }   
                    // }
                    // INGRESO DE INTERVENCIONES METROLOGIAS A BD
                        
                        $manto= $decode[32]->value;
                        $desdeManto=$decode[33]->value;
                        $verificacion= $decode[34]->value;
                        $desdeVerificacion=$decode[35]->value;
                        $calibracion= $decode[36]->value;
                        $desdeCalibracion= $decode[37]->value;
                        $calificacion= $decode[38]->value;
                        $desdeCalificacion= $decode[39]->value;
                        $otrocual= $decode[40]->value;
                        $otro= $decode[41]->value;
                        $desdeOtro= $decode[42]->value;
                        
                        if(isset($Area)!=""){
                            $versionUbicacion=1;
                        } else{
                            $versionUbicacion=0;
                        }
                        
            if($manto){
                $querymanto="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion,Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$versionUbicacion','$version','Mantenimiento preventivo','$manto','$desdeManto')";
                $datosmanto=mysql_query($querymanto, $con);
            }
            if($verificacion){
                $queryverificacion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion,Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$versionUbicacion','$version','Verificacion','$verificacion','$desdeVerificacion')";
                $datosverificacion=mysql_query($queryverificacion, $con);
            }
            if($calibracion){
                $querycalibracion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion,Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$versionUbicacion','$version','Calibracion','$calibracion','$desdeCalibracion')";
                $datoscalibracion=mysql_query($querycalibracion, $con);
            }
            if($calificacion){
                $querycalificacion="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion,Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$versionUbicacion','$version','Calificacion','$calificacion','$desdeCalificacion')";
                $datoscalificacion=mysql_query($querycalificacion, $con);
            }
            if($otro){
                $queryotro="INSERT INTO intervenciones (HV_Equipo,Version_Ubicacion,Version_Intervencion,Tipo_Intervencion,Frecuencia,Aplica_Desde) VALUES ('$nohv','$versionUbicacion','$version','$otrocual','$otro','$desdeOtro')";
                $datosotro=mysql_query($queryotro, $con);
            }
            

            
            
    }else{
       echo json_encode("CODIGO EXISTENTE, PRUEBA OTRO");
    }
       ?>            