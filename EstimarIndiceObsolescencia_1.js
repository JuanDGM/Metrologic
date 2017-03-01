
function estimarIndice(){
    
    $("#Formulario").submit(function(e){
        e.preventDefault();
        
    var datos={
        'DatosFormulario': $(this).serializeArray()
    };
        
        $.ajax({
            
            url:'ControladorEstimarObsolescencia.php',
            type:'POST',
            data:datos
            
        }).done(function(respuesta){
            var resp=JSON.parse(respuesta);
            $("#indice").html(resp['indice']);
            $("#indiceGrabar").val(resp['indice']);
            $("#IndiceEstimado").html(resp['indiceCualitativo']);
            $("#IndiceEstimado1").html(resp['IndiceSignificado']);
            $("#mensaje").css({"visibility":"visible"});
            $("#mensaje").attr("class",resp['mensaje']);
    });
    });    
}

