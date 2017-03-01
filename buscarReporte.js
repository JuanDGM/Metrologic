//$(document).ready(function(){
function buscarReporte(valor) {

    $.ajax({
        url: 'controladoBuscarReporte.php',
        type: 'POST',
        //dataType:'json',
        beforeSend: function () {
            $("#Imagen_Del_Equipo").attr("src","./images/EquipoSinImagen/no_image.png");
            $("#nombreequiporeporte").val("");
            $("#Areareporte").val("");
            $("#selectdata").empty();
        }

        , data: {
            'valorIngresado': valor
        },
        success: function (data) {
            var arreglo = JSON.parse(data);
            
          $("#nombreequiporeporte").val(arreglo['nombreEquipo']);
            $("#Areareporte").val(arreglo['Area']);
            $.each(arreglo['Intervencion'], function (index, valor) {
                $("#selectdata").append($('<option>', {
                    value: valor,
                    text: valor
                }));
            });
            $("#Imagen_Del_Equipo").attr("src",arreglo['RutaImagen']);
            
            }
            
        });
}


