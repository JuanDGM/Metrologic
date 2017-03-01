
function distribucionObsolescencia(c){
    
    var datos={
        'ciclo':c
    };
    
    
    $.ajax({
        url:'ControladorDistribucionObsolescenciaCiclo.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        
        var r=JSON.parse(respuesta);
        
        //$("#cuerpo").html(alert(respuesta));
      $("#respuestaVerde").html(r['Verde']);
      $("#respuestaAzul").html(r['Azul']);
      $("#respuestaAmarillo").html(r['Amarillo']);
      $("#respuestaRojo").html(r['Rojo']);
        
    });
    
}
