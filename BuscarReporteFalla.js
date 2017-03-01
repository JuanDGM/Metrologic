
function mostrarReporteFalla(p){
    
    var numeroRporte={
            'valor':p
    };
    
    $.ajax({
        url:'ControladorBuscarReporteFalla.php',
        type:'POST',
        data:numeroRporte
        
        
    }).done(function(respuesta){
        
        var array=JSON.parse(respuesta);
                            
        
        $("#nohoja").val(array['codhv']);
        $("#nohoja").focus();
        $("#descripcion").val(array['descripcionjson']);
        $("#fechaFalla").val(array['fechaFalla']);
        $("#nombreReporta").val(array['nombreRporta']);
        $("#prioridad").val(array['prioridad']);
        //$("#lblCodReporte").val(array['codReporte']);
        $('#estadoActual').val(array['EstadoEquipo']);
    });
    
}

