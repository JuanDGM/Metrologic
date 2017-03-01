

function cantidadFallasEquipos(){
    
    var datos={
      'valor':1 
      };
    
    $.ajax({
        
        url:'CantidadFallasEquiposReportado.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        var cant=JSON.parse(respuesta);
        
        $("#correctivos").html(cant);
       
    
    if(cant>0){
        $("#iconoFallas").attr("class","glyphicon glyphicon-remove");
        $("#iconoFallas").attr("style","color:red");
        
    }
    });
    
}