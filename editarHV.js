// Esta funcion viene desde hojaVida.php
function guardarCambios(){
    
$("#formulariohv").submit(function(e){
    e.preventDefault();

    var datos={
        'datosformulario': $(this).serializeArray(),
        'CodHV': $("#nohoja").val()
    };
    
    $.ajax({
        
        url: 'GuardarEdicion.php',
        type: 'POST',
        data: datos
        
    }).done(function(respuesta){
        
        //var arregloResp=JSON.parse(respuesta);
        
        //arregloResp['msgalerta'];
        //var RestablecerEdicion=arregloResp['RestablecerEdicion'];
        
        //$("#respuesta").html(alert(arregloResp['msgalerta']));
        //
            //$("#respuesta").html(alert(respuesta));
            $("#respuesta").html(alert("MODIFICACION REALIZADA EXITOSAMENTE"));
            //$("#formularioedicion").submit();
            $.post("Buscar_hojaVida.php",function(){$("#formularioedicion").submit();});
//        $("#respuesta").html(alert(arregloResp[0]));
//        $("#respuesta").html(alert(arregloResp[1]));
//        $("#respuesta").html(alert(arregloResp[2]));
//        $("#respuesta").html(alert(arregloResp[3]));
//        $("#respuesta").html(alert(arregloResp[4]));
//        $("#respuesta").html(alert(arregloResp[5]));
//        $("#respuesta").html(alert(arregloResp[6]));
//        $("#respuesta").html(alert(arregloResp[7]));
//        $("#respuesta").html(alert(arregloResp[8]));
//        $("#respuesta").html(alert(arregloResp[9]));
        
        //if(RestablecerEdicion==1){
            
          //  $("#formularioedicion").submit();
       // }
    });
});    
}
