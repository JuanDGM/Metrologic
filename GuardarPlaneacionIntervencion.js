
function guardarPlaneacionIntervencion(p) {
    var numeroFormulario = "#FormularioPlaneacionIntervencion"+p;
        $(numeroFormulario).submit(function(e){
        e.preventDefault();
        
        var id="#"+p;
        var FechaModificable="#FechaModificableProgramada"+p;
        var FechaNoModificable = "#FechaNoModificable"+p;
        
        var ProveedorModificable="#ProveedorModificableProgramado"+p;
        var ProveedorNoModificable="#ProveedorNoModificable"+p;
    
        var datos = {
            'datosFormularioGuardarPlaneacion': $(this).serializeArray()
        };

        $.ajax({
            url: 'ControladorGuardarPlaneacionIntervencion.php',
            type: 'POST',
            data: datos,
            success:function(respuesta){
                
            var estado=JSON.parse(respuesta);
            $(id).attr("style",estado["color"]);
            $(id).attr("class",estado["icono"]);
            $(FechaModificable).attr("style","display:none");
            $(FechaNoModificable).html(estado["fechaProgramada"]);
            $(FechaNoModificable).attr("style","");
                
                
            $(ProveedorModificable).attr("style","display:none");
            $(ProveedorNoModificable).html(estado["ProveedorProgramado"]);
            $(ProveedorNoModificable).attr("style","");

            
            
        }
       });
       });    
    }