
function datoEntrada(valor){
    
    $.ajax({
        
            url: 'ValidadorHV.php',
            type: 'POST',
            data:{
                codhvvalidando: valor
        }
        
      
      //$("#campocodhv").attr("class",respuesta.color);
      
      
//    error: function(respuesta){
//        
//        $("#resp").html(respuesta.icono);
//        
//    }
//        
    }).done(function(resultado){
       
      var ar = JSON.parse(resultado);
        
      $("#campocodhv").attr("class",ar['color']);
      $("#icon").attr("class",ar['icono']);
     
    });
    
    
    
    }
    
    
    
    
  //    $("#campo").attr("class",icono1);
      //$("#icono").attr("class",icono);
      
       // $.each(respuesta,function(index,value){
            
            //$("#campo").attr("class",respuesta[0]);
            
       // });
    
    // busca un propiedad que se llama append 
    //
    //
    //
//$("#campo").attr("class",respuesta);
        //$("#campo").attr("class",respuesta);
        //$("#icono").attr("class",icono);
       // $("#icono").attr("class","glyphicon glyphicon-ok form-control-feedback");
       //console.log(respuesta.color);
    
    
