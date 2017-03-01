
function buscador(){
    
    var datos={
        'ciudad':a
        }
    
    $.ajax({
        url:'ControladorBuscadorLocalizacion.php',
        type:'POST',
        data:datos,
        beforeSend: function () {
            $("#txtCiudad").empty();
        },
        success:function(){
            
        var arreglo = JSON.parse(data);
            $.each(arreglo['ciudad'], function (index, valor) {
                $("#txtCiudad").append($('<option>', {
                    value: valor,
                    text: valor
                }));
            });
           
        }
        
    });
        
            
        
 
    
    
}