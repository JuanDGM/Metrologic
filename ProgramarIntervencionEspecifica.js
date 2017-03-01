
function GuardarProgramacionEspecifica(){
    

    var datos={
        
        'codigoHV':$("#nohoja").val(),
        'FechaMantoEspecifica':$("#FechaMantoEspecifica").val()
        
    };
    
    $.ajax({
        
        url:'ControladorGuardarIntervencionEspecifica.php',
        type:'POST',
        data:datos
    }).done(function(respuesta){
        
        
        $("#FechaMantoProgramadaEspecifica").html(respuesta);
        
    });
    
//    });
}
