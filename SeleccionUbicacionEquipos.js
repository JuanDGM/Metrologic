

function EnviarCiudad(c){    
    
    var datos={
        'ciudad':c
        
    }
    
    $.ajax({
        url:'ControladorUbicacionEquipos.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        
        $("#EjemploCiudad").html(alert(respuesta));
        
    });
    
    }














//function SeleccionSede(c){
//    
//    var ciudad={
//        'ciudad':c
//    };
//    
//    
//    $.ajax({
//        
//        url:'ControladorUbicacionEquipos.php',
//        type:'POST',
//        data:ciudad
//        
//        
//    }).done(function(respuesta){
//        
//        $("#EjemploCiudad").html(alert(respuesta));
//        
//    });
//    
//    
//}