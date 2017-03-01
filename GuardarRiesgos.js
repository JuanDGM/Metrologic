
function guardarRiesgo(){

    var valores={
      'CodHV':$("#nohoja").val(),
      'invasividad':$("#invasividad").val(),  
      'equipoPorTipoRiesgo':$("#equipoPorTipoRiesgo").val(),
      'Riesgo':$("#riesgo").val()
      
    };
    
        $.ajax({
            
            url:'ControladorGuardarRiesgo.php',
            type:'POST',
            beforeSend: function () {
                $("#FormularioPrueba").each(function(){
                this.reset();
            });
                
            },
            data:valores
            
            
        }).done(function(respuesta){
           var r=JSON.parse(respuesta);
           var n=r['numeroRiesgo'];
           
           var Recuadro="#Recuadro"+n;
           var IDNombre="#respuestaNombre"+n;
           var IDIcono="#respuestaIcono"+n;
           
           
           $(Recuadro).attr("style","display: block");
           $(IDNombre).html(r['NombreRiesgo']);
           $(IDIcono).attr("src",r['Icono']);
           
           //$("#cuerpo").html(alert(respuesta));
           
           
        });

}


