function cantidadIntervencionesVencidas(){
    var datos={
      'valor':1 
      };
    
    $.ajax({
        url: 'Controlador_Cant_Intervenciones_Vencidas.php',
        type: 'POST',
        data: datos
        
    }).done(function(respuesta){
    $("#CantVencidos").html(JSON.parse(respuesta));
    
    var cant=respuesta;
    if(cant>0){
        $("#iconoVencido").attr("class","glyphicon glyphicon-remove");
        $("#iconoVencido").attr("style","color:red");
        
    }
      });
}
