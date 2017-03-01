

function ultimarIntervenciones(valor){
    
    var proximosDias={
        'UltimasIntervenciones':valor
    };
    
    $.ajax({
        
    url: 'ControladorUltimasIntervenciones.php',    
    type: 'POST',
    data: proximosDias,
    beforeSend: function () {

            $('#UltimasIntervenciones').empty();

        }
        
    }).done(function(respuesta){
        
        $("#UltimasIntervenciones").html(respuesta);
        
    });
    
}

