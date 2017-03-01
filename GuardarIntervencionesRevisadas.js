
function IntervencionesRevisadas(i){
    var p="#formularioIntervencionesRealizadas"+i;
    
    
    $(p).submit(function(e){
        e.preventDefault();
        
        var datos={
            'valores': $(this).serializeArray()
        };
    
    $.ajax({
        url:'ControladorGuardarIntervencionesRevisadas.php',
        type:'POST',
        data:datos
        
    }).done(function(respuesta){
        $("#MenuRevision").html(alert(respuesta));
       
       $(document).ready(function(){
           
           $("#cuerpo").load("RevisionInformeIntervencion.php");
           
       });
       
    });
    });
}