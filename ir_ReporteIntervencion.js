

function reportarIntervencion(){
    
    $("#formulariohv").submit(function(e){
        e.preventDefault();
    
    var datos={
        'datos': serializeArray()
    }
    
    
    $.ajax({
        
        url:'reporteIntervencion.php',
        type: 'POST',
        data: datos
        
    }).done(function(){
        
        
        
        
    });
    
    
    });
    
}
    
    