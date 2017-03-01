

function EliminarIntervencionOrden(p){
    
    var formulario="#formulario"+p;
    
    $(formulario).submit(function(e){
        e.preventDefault();
    var datos={
        'valoresFormulario': $(this).serializeArray()
    };
    
    $.ajax({
        url:'ControladorEliminarIntervencionOrden.php',
        type:'POST',
        data:datos
        
        
    }).done(function(s){
        
        var arreglo=JSON.parse(s);
    var posicion=arreglo[0];    
    var filaEliminar="#fila"+posicion;
        
        $(filaEliminar).hide();    
        //$("#resp").html(alert(filaEliminar));
        
});
    
    });
    
}