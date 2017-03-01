

function HabilitarCampos(p){
    
    $("#formularioEdicion").submit(e);
    e.preventDefault();
    
    $.ajax({
        
        url: 'ControladorHabilitarProgramacionIntervencion.php',
        type: 'POST',
        data: datos
        
        
    }).done(function(respuesta){
        
        
        
    });
}