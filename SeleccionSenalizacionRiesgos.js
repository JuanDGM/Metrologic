
function SeleccionarImagenen(s){
    
    var datos={
      'riesgoSeleccionado':s
    };
    
    $.ajax({
        
        url:'ControladorSeleccionarImagenRiesgos.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        var r=JSON.parse(respuesta);
        //var r=respuesta;
        $("#imagenRiesgos").attr("src",r);
        //$("#imagenRiesgos").html(alert(respuesta));
        
    });
    
    
    
    
}

