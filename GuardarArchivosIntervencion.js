

$(function(){
    $("#guardarDocumentosIntervencion").click(subirArchivos);
});

function subirArchivos(){
    var archivos=document.getElementById("archivos");
    var archivo=archivos.files;
    var archivos= new FormData();
    
    for(i=0;i<archivo.length;i++){
       archivos.append('archivo'+i,archivo[i]); 
    }
    
    $.ajax({
        url:'CargarReporteIntervencion.php',
        type:'POST',
        data:archivos,
        contentType: false,
        processData: false,
        cache: false
    }).done(function(msg){
        $(".mensajeAdjunto").html(msg);
        $(".mensajeAdjunto").show('slow');
    });
}