
function BuscarReporteIntervencion(){
    
    $("#FormularioBuscador").submit(function(e){
        e.preventDefault();
        
    var buscar={
      'codigoReporte':$(this).serializeArray()  
    };
    
    $.ajax({
        url:'ControladorSeleccionarReporteInterBuscado.php',
        type:'POST',
        beforeSend: function (xhr) {
            $("#nohoja").val("");
            //$("input[name='intervencion']").val(r['tipoIntervencion']);
            $("#FechaIntervencion").val("");
            $("#nombreproveedor").val("");
            $("#tecnico").val("");
            $("#ListaEstadoEquipo").val("");
            $("#nombrerecibido").val("");
            $("#descripcion").val("");
            $("#Tiempo").val("");
            $("#Costo").val("");
        },
        data:buscar
        
    }).done(function(respuesta){
        
        var r=JSON.parse(respuesta);
        
            $("#nohoja").val(r['codigoEquipo']);
            $("input[name='intervencion']").val(r['tipoIntervencion']);
            $("#FechaIntervencion").val(r['fechaIntervencion']);
            $("#nombreproveedor").val(r['nombreProveedor']);
            $("#tecnico").val(r['nombreTecnico']);
            $("#ListaEstadoEquipo").val(r['estadoEquipo']);
            $("#nombrerecibido").val(r['nombreRecibe']);
            $("#descripcion").val(r['descripcion']);
            $("#Tiempo").val(r['tiempoIntervencion']);
            $("#Costo").val(r['costoIntervencion']);
            
            $("#nohoja").focus();
    });
    });
}
