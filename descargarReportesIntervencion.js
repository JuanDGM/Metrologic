
function descargarReporte(){
    
    $("#formularioDescargarArchivo").submit(function(e){
        e.preventDefault();
        
        var datos={
            'valores':$(this).serializeArray()
          };
        
        $.ajax({
            url:'descargarReportesIntervencion.php',
            type:'POST',
            data: datos
            
        }).done(function(respuesta){
            
            
            
        });
        });
        }
