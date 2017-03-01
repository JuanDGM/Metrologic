
function buscarImagenEquipo(r){
    
    var datos={
        'codigoEquipo':r
    };
    
   $.ajax({
       
       url:'ControladorBuscarImagenEquipo.php',
       type:'POST',
       data: datos,
       beforeSend: function () {

            $("#ImagenEquipo").attr("src","./images/EquipoSinImagen/no_image.png");
          
        }
       
   }).done(function(respuesta){
       
       var ruta=JSON.parse(respuesta);
       
       $("#ImagenEquipo").attr("src",ruta);
       
   }); 
    
}