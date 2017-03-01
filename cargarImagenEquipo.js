
$(document).ready(function(){
 $("input[name='archivo']").on("change",function(){
     var formData= new FormData($("#formulariohv")[0]);
     $.ajax({
         url:'ControladorCargarImagenEquipo.php',
         type:'POST',
         data:formData,
         contentType: false,
         processData: false,
         success: function(datos){
             var ruta=JSON.parse(datos);
             $("#imagen1").attr("src",ruta);
             $("#hiddenRutaIngresar").attr("value",ruta);
        //$("#respuestaImagen").html(ruta);
         }
     });
 });   
});













//
//
//
//
//
//
//
//$(document).ready(function(){
//    $("#enviar").click(subirFotos);
//});


//
//function subirFotos(){
//    
//    $("#formularioImagenesEquipos").submit(function(e){
//    e.preventDefault();
//    
//   
//    var archivos = document.getElementById("archivosSeleccionados");
//    var CodigoHojaVida={
//        'valore':$(this).serializeArray()
//    };
//    //var CodigoHojaVida= new FormData();
//    var archivo=archivos.files;
//    var archivos= new FormData();
//    
//    for(i=0;i<archivo.length;i++){
//        archivos.append('archivos'+i,archivo[i]);
//    }
//    
//    var valora=11;
//    var valorb=22;
//   
//    var arrra=['valora'=>valora,'valorb'=>valorb];    
//        
//    //var arrayDatos={'codigohv':CodigoHojaVida,'imagenSeleccionada':archivos};
//    
//    $.ajax({
//            url:'ControladorCargarImagenEquipo.php',
//            type:'POST',
//            data:arrra,
//            //data:"{'valora':'"+CodigoHojaVida+"','valorb':'"+CodigoHojaVida+"'}",
////            contentType: false
////            processData: false
//            cache:false
//        }).done(function(respuesta){
//            $("#resp").html(alert(respuesta));
//            //$("#resp").show('slow');
//        });
//        });
//}

//function cargarImagen(){
//    
//    $("#formularioCargarImagen").submit(function(e){
//        e.preventDefault();
//        
//        var datos=new FormData($(this)[0]);
//        
//        
//        
//        $.ajax({
//            
//            url:'ControladorCargarImagenEquipo.php',
//            type:'POST',
//            data:datos,
//            contentType: 'false',
//            processData: false
//            
//            
//            
//            
//        }).done(function(respuesta){
//            
//            $("#resp").html(alert(respuesta));
//            
//        });
//        
//        
//        
//        
//        
//    });
//    
//    
//    
//    
//    
//    
//    
//    
