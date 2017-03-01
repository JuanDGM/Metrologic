

function crearUsuario(){
    
    $("#formularioCreacionUsuario").submit(function(e){
        e.preventDefault();
        
        var datos={
            'valores': $(this).serializeArray()
        };
        
    $.ajax({
        url:'ControladorCrearUsuario.php',
        type:'POST',
        data:datos,
        cache:true
            
        
        
    }).done(function(respuesta){
        
        $("#resp").html(alert(respuesta));
        $("#formularioCreacionUsuario").each(function(){
                this.reset();
            });
        
        
    }); 
    });
    }
