

function proximasIntervenciones(valor){
    
    var proximosDias={
        'DiasProximasIntervenciones':valor
    };
    
    $.ajax({
        
    url: 'ControladoProximasIntervenciones.php',    
    type: 'POST',
    data: proximosDias,
    beforeSend: function () {

            $('#ProximasIntervenciones').empty();

        }
        
    }).done(function(respuesta){
        
        var valor=respuesta;
        
        $("#ProximasIntervenciones").html(respuesta);
        
        if(valor>0){
        $("#iconoProximos").attr("class","glyphicon glyphicon-warning-sign");
        $("#iconoProximos").attr("style","color:orange");
        }
    });
    
}

