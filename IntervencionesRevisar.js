
function cantidadIntervencionesRevisar(){
    
    var datos={
      'valor':1 
      };
    
    $.ajax({
        
        url:'CantidadIntervencionesPorRevisar.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        var cant=JSON.parse(respuesta);
        
        $("#IntervencionesPorRevisar").html(cant);
       
    
//    if(cant>0){
//        $("#iconoFallas").attr("class","glyphicon glyphicon-remove");
//        $("#iconoFallas").attr("style","color:red");
//        
//    }
    });
    
}

