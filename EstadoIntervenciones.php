<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="EstilosEstadoIntervencionesMenu.css">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="CantidadVencidos.js"></script>
        <script src="proximasIntervenciones.js"></script>
        <script src="UltimasIntervenciones.js"></script>
        <script src="CantidadFallasReportadas.js"></script>
        <script src="IntervencionesRevisar.js"></script>
        <script src="InventarioEquipos.js"></script>
        <script>
        $(document).ready(function(){
        $("#ProximasIntervenciones").click(function(){
            $("#formularioVigentes").submit();
        });
        $("#UltimasIntervenciones").click(function(){
            $("#formularioIntervenido").submit();
        });
        $("#enlanceNumVencidos").click(function(){
            $("#formularioVencidos").submit();
        });
        $("#EnlacePorRevisar").click(function(){
            $("#formularioPorRevisar").submit();
        });
        $("#enlanceInventario").click(function(){
            $("#formularioInventario").submit();
        });
        $("#acordionAlertas").click(function(){
            $("#tablaOcultar").toggle();
        });
        });
        </script>
    </head>
    <body onload="cantidadIntervencionesVencidas();cantidadFallasEquipos();cantidadIntervencionesRevisar();cantidadEquiposInventario();proximasIntervenciones(30);">
<?php
function estadoIntervenciones(){
    ?>
<h3 style="text-align: center;cursor: pointer;" id="acordionAlertas"><strong> ESTADO DE EQUIPOS</strong></h3>
    <table class="table table-condensed" id="tablaOcultar">
        
        <tr style="background: #f4f4f4;height: 60px;">
        <form method="POST" id="formularioVencidos" action="DetalleEstadoVigente.php">
            <td class="NombreAlerta" style="width: 100%;vertical-align: middle;">Intervenciones Vencidas:</td>
            <td><a href="#" id="enlanceNumVencidos"><p style="font-size: 20px;" id="CantVencidos"></p></a></td>
            <td class=""><span id="iconoVencido" class=""></span></td>
            <input type="hidden" value="VENCIDO" name="desdeVencidos">
        </form>
        </tr>
        <tr style="height: 60px;">
        <form method="POST" id="formularioV" action="DetalleEstadoVigente.php">
            <td class="NombreAlerta" style="width: 100%;vertical-align: middle;">Mantenimientos correctivos pendientes:</td>
            <td><a href="Detalle_Reporte_Fallas.php" style="font-size: 20px;" id="correctivos"></a></td>
            <td><span id="iconoFallas" class="" style=""></span></td>
        </form>
        </tr>
        <tr style="background: #f4f4f4;height: 60px;">
        <form method="POST" id="formularioVigentes" action="DetalleEstadoVigente.php">
            <td class="NombreAlerta" style="width: 100%;vertical-align: middle;">Proximas Intervenciones<input type="text" value="30" name="proximas" onkeyup="proximasIntervenciones(this.value)" onfocus="proximasIntervenciones(this.value)" style="width: 40px;margin-left: 2px;"> dias:</td>
            <td><a href="#" style="font-size: 20px;" id="ProximasIntervenciones"></a></td>
            <td><span id="iconoProximos" class="" style=""></td>
            <input type="hidden" value="PROXIMAMENTE" name="desdeVencidos">
        </form>
        </tr>
<!--        <tr style="height: 60px;">
        <form method="POST" id="formularioIntervenido" action="DetalleEstadoIntervenido.php">
            <td style="width: 100%;font-size: 20px;vertical-align: middle;">Intervenciones realizadas<input type="text" value="30" name="proximas" onkeyup="ultimarIntervenciones(this.value)" onfocus="ultimarIntervenciones(this.value)" style="width: 40px;margin-left: 2px;"> dias:</td>
            <td><a href="#" id="UltimasIntervenciones"></a></td>
        </form>
        </tr>-->
        <tr style="height: 60px;">
        <form method="POST" id="formularioPorRevisar" action="RevisionInformeIntervencion.php">
            <td class="NombreAlerta" style="width: 100%;vertical-align: middle;">Aprobacion de intervenciones pendientes</td>
            <td><a href="#" id="EnlacePorRevisar"><p id="IntervencionesPorRevisar" style="font-size: 20px;"></p></a></td>
            <td></td>
        </form>
        </tr>
        <tr style="height: 60px;background: #f4f4f4;">
        <form method="POST" id="formularioInventario" action="DetalleInventarioEquipos.php">
            <td class="NombreAlerta" style="width: 100%;vertical-align: middle;">Inventario de Equipos:</td>
            <td><a href="#" id="enlanceInventario"><p style="font-size: 20px;" id="CantInventario"></p></a></td>
            <td></td>
        </form>
        </tr>
    </table>
    <?php
    }
    ?>
</body>
</html>