
function traerDatosObsolescencia(v){
    
    var CodigoHV={
      'codigoHVequipo': v  
    };
    
    
    $.ajax({
        
        url:'ControladorDatosObsolescencia.php',
        type:'POST',
        data:CodigoHV 
        
    }).done(function(respuesta){
        var arreglo=JSON.parse(respuesta);
        
        $("#nombreEquipo").attr("value",arreglo['nombre']);
        $("#nombreEquipo").attr("placeholder",arreglo['nombre']);
        
        $("#marca").attr("value",arreglo['marca']);
        $("#marca").attr("placeholder",arreglo['marca']);
        
        $("#modelo").attr("value",arreglo['modelo']);
        $("#modelo").attr("placeholder",arreglo['modelo']);
        
        $("#CantidadFallas").attr("value",arreglo['CantFallas']);
        $("#CantidadFallas").attr("placeholder",arreglo['CantFallas']);
        
        
        
    });
    
}
