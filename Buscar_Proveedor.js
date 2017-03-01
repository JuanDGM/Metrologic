
// esta funcion viene de reporteIntervencion.php
//function buscarProveedor(valor){
  
$(document).ready(function(){

$("#selectdata").on('change',function(){    

var hv=$("#nohoja").val();
var tipointervencion=$("#selectdata").val();

//    var HojaV={
//        'hojaVida': hv
//        };
//    var interv={
//        'Intervencion': tipointervencion
//        };
   
    
    
    
    $.ajax({
        url: 'ControladoBuscarProveedor.php',
        type:'POST',
        data: {'h':hv,'i':tipointervencion} 
        
    }).done(function(respuesta){
        $("#nombreproveedor").val(JSON.parse(respuesta));
    });
//}
});
});