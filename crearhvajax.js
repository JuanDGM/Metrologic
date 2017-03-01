    
    function enviar(){
    
    $("#formulariohv").submit(function(e){
       e.preventDefault();
       
   var datos={
              'datosformulario': $(this).serializeArray()
          };       
        
        //Guardar imagen equipo
        
        
        //$("input[name='archivo']").on("change",function(){
//     var formData= new FormData($("#formularioImagenesEquipos")[0]);
//     $.ajax({
//         url:'ControladorCargarImagenEquipo.php',
//         type:'POST',
//         data:formData,
//         contentType: false,
//         processData: false,
//         success: function(datos){
//             var ruta=JSON.parse(datos);
//             $("#imagen1").attr("src",ruta);
//             $("#hiddenRutaIngresar").attr("value",ruta);
//        //$("#respuestaImagen").html(ruta);
//         }
//     });
 //}); 
        
        
        
        
        
         $.ajax({
        
        url: 'guardarHV.php',
        type:'POST',
        data: datos
//        success: function(response){
//            
//            document.getElementById("nohoja").value="";
//            document.getElementById("tipoequipo").value="";
//            document.getElementById("nombreequipo").value="";
//            document.getElementById("nombreproveedor").value="";
//            document.getElementById("modelo").value="";
//            document.getElementById("serie").value="";
//            document.getElementById("marca").value="";
//            document.getElementById("voltaje").value="";
//            document.getElementById("amperaje").value="";
//            document.getElementById("potencia").value="";
//            document.getElementById("caracteristicas").value="";
//            document.getElementById("sede").value="";
//            document.getElementById("txtSede").value="";
//            document.getElementById("txtArea").value="";
//            document.getElementById("fecha_marcha").value="";
//            document.getElementById("otro_cual").value="";
//            document.getElementById("f_manto").value="";
//            document.getElementById("f_verificacion").value="";
//            document.getElementById("f_calibracion").value="";
//            document.getElementById("f_calificacion").value="";
//            document.getElementById("f_otro").value="";
//        }  
    }).done(function(respuesta){
        var r=JSON.parse(respuesta);
    $("#RespuestaGuardarHV").html(alert(r));
    //$("#resp").html(alert(respuesta));
            if(r=="SE CREO LA HOJA DE VIDA EXITOSAMENTE!!"){
            location.href="Menu.php"; 
            //location.reload();
            }else{
            location.reload();    
            }
            document.getElementById("nohoja").value="";
            document.getElementById("tipoequipo").value="";
            document.getElementById("nombreequipo").value="";
            document.getElementById("nombreproveedor").value="";
            document.getElementById("modelo").value="";
            document.getElementById("serie").value="";
            document.getElementById("marca").value="";
            document.getElementById("voltaje").value="";
            document.getElementById("amperaje").value="";
            document.getElementById("potencia").value="";
            document.getElementById("caracteristicas").value="";
            document.getElementById("sede").value="";
            document.getElementById("txtSede").value="";
            document.getElementById("txtArea").value="";
            document.getElementById("fecha_marcha").value="";
            document.getElementById("otro_cual").value="";
            document.getElementById("f_manto").value="";
            document.getElementById("f_verificacion").value="";
            document.getElementById("f_calibracion").value="";
            document.getElementById("f_calificacion").value="";
            document.getElementById("f_otro").value="";           
        
    });
    });
    }
    
    function editar(){
       $("#formulariohv").submit(function(e){
       e.preventDefault();
       
   var datos={
              'datosformulario': $(this).serializeArray()
          };
        });
        }


