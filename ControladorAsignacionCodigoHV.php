<?php
    include('./conexion.php');
    $con=  conectar();
    $tipoEquipo=$_POST['tipoEquipoSeleccionado'];
    
    $d=json_encode($tipoEquipo);
    
     $tp=json_decode($d);

    //$encode=json_encode($tipoEquipo);

    //$d=json_decode($encode);
    
    //$TipoEquipo=$d[0]->value;

    $querySeleccionTipoCodigo="SELECT Codigo_Equipo FROM tipo_equipo WHERE Tipo_Equipo='$tp'";
    $conexionSeleccionTipoCodigo=mysql_query($querySeleccionTipoCodigo, $con);
    while($arrayTipoCodigo=mysql_fetch_array($conexionSeleccionTipoCodigo)){
        $codigoTipoEquipo=$arrayTipoCodigo['Codigo_Equipo'];
        }
     
        $tamanoCodigo=strlen($codigoTipoEquipo);
        $extraeInicio=$tamanoCodigo+1;
        $extrarFin=$extraeInicio+6;
        
        
     if(isset($codigoTipoEquipo)){
        
    //$querMaximoCodigoUtilizado="SELECT MAX(No_HV) FROM hoja_vida WHERE No_HV LIKE '$codigoTipoEquipo%'";    
    $querMaximoCodigoUtilizado="SELECT MAX(SUBSTRING(No_HV,$extraeInicio,$extrarFin)*1) AS Consecutivo FROM hoja_vida WHERE Tipo_Equipo='$tipoEquipo'";    
    $conexionMaxCodigo=mysql_query($querMaximoCodigoUtilizado, $con);    
    while($arrayMaxCodEquipo=mysql_fetch_array($conexionMaxCodigo)){
        $MaxConsecutivoActual=$arrayMaxCodEquipo['Consecutivo'];
        }  

        $ConsecutivoNuevo=$MaxConsecutivoActual+1;
        $nuevoCodigo=$codigoTipoEquipo.$ConsecutivoNuevo;
        
    if($tp=="-- Seleccione --"){
        echo json_encode("");
    } else if($MaxConsecutivoActual==""){
        
        $PrimerCodigoAsignado=$codigoTipoEquipo."1";
        echo json_encode($PrimerCodigoAsignado);
        
    }else{
        echo json_encode($nuevoCodigo);
    }   
// echo json_encode($codigoEquipo);
    }
    ?>