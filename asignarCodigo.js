

function proponerCodigoEquipo(){
    
//    $("#formularioAsignacionCodigo").submit(function(e){
//        e.preventDefault();
        
        var datos=document.getElementById("listaTipoEquipos").value;
        //var datos=p;
        
        $.ajax({
            
            url:'ControladorAsignacionCodigoHV.php',
            type:'POST',
            data:{
                'tipoEquipoSeleccionado':datos
            }
                 
            
        }).done(function(respuesta){
            
            var tipoCod=JSON.parse(respuesta);
            
        //$("#resp").html(tipoCod);
        $("#inputModificar").attr("value",tipoCod);
            
            
        });
        
    //});
    
}
