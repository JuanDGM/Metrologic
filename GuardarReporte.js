

function guardarReporte(){
    
    $("#formularioReporte").submit(function(e){
        e.preventDefault();
        
       var datos={
           'datosFormulario': $(this).serializeArray()
        };
        
        $.ajax({
            
            url: 'ControladorGuardarReporte.php',
            type: 'POST',
            data: datos,
            cache:false
            
        }).done(function(respuesta){
        var r= ' REPORTE GUARDADO CORRECTAMENTE, \n DESEA REPORTAR UNA NUEVA INTERVENCIÓN!!';
           
        
        
        if(confirm(r)){
            
            $("#cuerpo").load("reporteIntervencion.php");
            
        }else{
            location.href="Menu.php"; 
        }
//            $("#formularioReporte").each(function(){
//                this.reset();
//            });
            
            $("#formularioReporte").empty();
        });
        
        
        
    });
}