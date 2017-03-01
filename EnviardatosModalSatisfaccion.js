
// esta funcion esta definida para llevar por medio de ajax, 
// el codigo del servicio a la ventana modal para que cuando grabe los resultados de la encuesta la grabe
function trarDatos(x){
    var datos={
        'codigoReporte':x
        //'proveedorEncuesta':p
      };
    
    $.ajax({
        url:'ControladorLlevarDatosModalSatisfaccion.php',
        type:'POST',
        data:datos
    }).done(function(respuesta){
        var r=JSON.parse(respuesta);
            $("#codigoReporteModal").attr("value",r);
//            $("#proveedorEvaluarModal").attr("value",r['proveedorEvaluar']);
//            $("#tecnicoEvaluarModal").attr("value",r['tecnicoEvaluar']);
//            $("#intervencionEvaluarModal").attr("value",r['intervencionEvaluar']);
    });
    }