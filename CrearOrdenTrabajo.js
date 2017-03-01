

function CrearOrdenProveedor(){
           
           $("#FormularioSolicitudProgramacion").submit(function(e){
           e.preventDefault();
           
           var datos={
               'datosFormulario':$(this).serializeArray()
           };
  

        $.ajax({
            url: 'OrdenTrabajoProveedor.php',
            type: 'POST',
            data: datos,
            success: function(respuesta){
            
            $("#r").html(alert(respuesta));
            //window.location.href="index.php";
            }
            
        });
        
        });
        
           }
  



