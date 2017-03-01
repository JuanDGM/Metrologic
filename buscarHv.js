

function buscarHojavida(){
    
    
    $("#formulariobuscador").submit(function(e){
        e.preventDefault();
        
        var datos={
              'datosformulariobusqueda': $(this).serializeArray()
          };
        
    $.ajax({
        
        url: "buscarhv.php",
        type: "POST",
        data: datos
            
    }).done(function(respuesta){
        
        //var $array= JSON.parse(respuesta);
        
       $("#listamaestra").html(respuesta);
        
        
    });
        
        
        
        
        
        
        
        
    });
    
}

