
function cantidadEquiposInventario(){
    
    var datos={
      'valor':1 
      };
    
    $.ajax({
        url: 'Controlador_Cant_Inventario.php',
        type: 'POST',
        data: datos
        
    }).done(function(respuesta){
        
    
    $("#CantInventario").html(JSON.parse(respuesta));
      });
    
}
