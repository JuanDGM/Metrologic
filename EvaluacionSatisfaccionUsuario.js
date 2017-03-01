
function PrimerPregunta(a,z,p,t,i){
    var resultadoA={
        'resultadoA':a,
        'codReporte':z,
        'proveedor':p,
        'tecnico':t,
        'intervencion':i
    };
    $.ajax({
        url:'ControladorGuardarEncuestaSatisfaccion.php',
        type:'POST',
        data:resultadoA
    }).done(function(respuesta){
        $("#respuesta1").html("Guardado!");
        $("#excelente1").hide();
        $("#bueno1").hide();
        $("#insatisfactorio1").hide();
        var r=JSON.parse(respuesta);
        if(r==4){
            $("#TablaEncuesta").hide();
            $("#encuestaCompleta").html("GRACIAS!");
            $("#cuerpoModalCompleto").attr("style","background:#A9D0F5;");
            $("#bntCerrar").attr("style","display:block;");
        }
    });
    }

function SegundaPregunta(b,z,p,t,i){
    var resultadoB={
        'resultadoB':b,
        'codReporte':z,
        'proveedor':p,
        'tecnico':t,
        'intervencion':i
        };
    $.ajax({
        url:'ControladorGuardarEncuestaSatisfaccion.php',
        type:'POST',
        data:resultadoB
    }).done(function(respuesta){
        $("#respuesta2").html("Guardado!");
        $("#excelente2").hide();
        $("#bueno2").hide();
        $("#insatisfactorio2").hide();
        var r=JSON.parse(respuesta);
        if(r==4){
            $("#TablaEncuesta").hide();
            $("#encuestaCompleta").html("GRACIAS!");
            $("#cuerpoModalCompleto").attr("style","background:#A9D0F5;");
            $("#bntCerrar").attr("style","display:block;");
        }
    
    
        });
   }

function TercerPregunta(c,z,p,t,i){
    var resultadoC={
        'resultadoC':c,
        'codReporte':z,
        'proveedor':p,
        'tecnico':t,
        'intervencion':i
        };
    $.ajax({
        url:'ControladorGuardarEncuestaSatisfaccion.php',
        type:'POST',
        data:resultadoC
    }).done(function(respuesta){
        $("#respuesta3").html("Guardado!");
        $("#excelente3").hide();
        $("#bueno3").hide();
        $("#insatisfactorio3").hide();
        var r=JSON.parse(respuesta);
        if(r==4){
            $("#TablaEncuesta").hide();
            $("#encuestaCompleta").html("GRACIAS!");
            $("#cuerpoModalCompleto").attr("style","background:#A9D0F5;");
            $("#bntCerrar").attr("style","display:block;");
        }

        });
   }
function CuartaPregunta(d,z,p,t,i){
    var resultadoD={
        'resultadoD':d,
        'codReporte':z,
        'proveedor':p,
        'tecnico':t,
        'intervencion':i
        };
    $.ajax({
        url:'ControladorGuardarEncuestaSatisfaccion.php',
        type:'POST',
        data:resultadoD
        
    }).done(function(respuesta){
        
        $("#respuesta4").html("Guardado!");
        $("#excelente4").hide();
        $("#bueno4").hide();
        $("#insatisfactorio4").hide();
        var r=JSON.parse(respuesta);
        if(r==4){
            $("#TablaEncuesta").hide();
            $("#encuestaCompleta").html("GRACIAS!");
            $("#cuerpoModalCompleto").attr("style","background:#A9D0F5;");
            $("#bntCerrar").attr("style","display:block;");
        }
    });
   }