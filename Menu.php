<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Principal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstiloMenuPrincipal.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css" media="screen">
        <script src="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="CantidadVencidos.js"></script>
        <script>
        $(document).ready(function(){
            var tipoUsuarioIngresa=$("#tipoUsuarioCuenta").val();
                if(tipoUsuarioIngresa=="Funcional"){
                    $("#alertas").hide();
                    $("#OrdenesTrabajo").hide();
                    $("#crearHV").hide();
        }else if(tipoUsuarioIngresa=="Consulta"){
            $("#estadoIntervenciones").hide();
                    $("#OrdenesTrabajo").hide();
                    $("#crearHV").hide();
                    $("#reporteIntervercion").hide();
        }
        $('.dropdown-toggle').dropdown();
        });
//        hover de los iconos del menu
        function iconosRojos(){
            $("#buscarEquipo").attr("src","./images/RojosHover/BuscarHV.png");
            $("#idBuscar").attr("style","color:#e14242");
            }
        function iconosGrises(){
            $("#buscarEquipo").attr("src","./images/GrisesHover/BuscarHV.png");
            $("#idBuscar").attr("style","color:#525151");
            }
        function iconosRojosOrdenes(){
            $("#ordenesTrabajo").attr("src","./images/RojosHover/Ordenes.png");
            $("#idlblOrdenes").attr("style","color:#e14242");
            }
        function iconosGrisesOrdenes(){
            $("#ordenesTrabajo").attr("src","./images/GrisesHover/Ordenes.png");
            $("#idlblOrdenes").attr("style","color:#525151");
            }
        function iconosRojosReportarIntervencion(){
            $("#reporteIntervencionMenu").attr("src","./images/RojosHover/ReportarIntervencion.png");
            $("#idReportarIntervencion").attr("style","color:#e14242");
        }
        function iconosGrisesReportarIntervencion(){
            $("#reporteIntervencionMenu").attr("src","./images/GrisesHover/ReportarIntervencion.png");
            $("#idReportarIntervencion").attr("style","color:#525151");
        }
        function iconosRojosObsolescencia(){
            $("#Obsolescencia").attr("src","./images/RojosHover/Obsolescencia.png");
            $("#idlblObsolescencia").attr("style","color:#e14242");
            }
        function iconosGrisesObsolescencia(){
            $("#Obsolescencia").attr("src","./images/GrisesHover/Obsolescencia.png");
            $("#idlblObsolescencia").attr("style","color:#525151");
        }
        function iconosRojosCrearHV(){
            $("#crearHojaVida").attr("src","./images/RojosHover/HojaVida.png");
            $("#idlblCrearEquipo").attr("style","color:#e14242");
        }
        function iconosGrisesCrearHV(){
            $("#crearHojaVida").attr("src","./images/GrisesHover/HojaVida.png");
            $("#idlblCrearEquipo").attr("style","color:#525151");
        }
        function iconosRojosReportarFalla(){
            $("#ReportarFalla").attr("src","./images/RojosHover/ReportarFalla.png");
            $("#idReportarFalla").attr("style","color:#e14242");
        }
        function iconosGrisesReportarFalla(){
            $("#ReportarFalla").attr("src","./images/GrisesHover/ReportarFalla.png");
            $("#idReportarFalla").attr("style","color:#525151");
        }
        function iconosRojosCronogramas(){
            $("#cronogramasIntervencion").attr("src","./images/RojosHover/Cronogramas.png");
            $("#idlblCronogramas").attr("style","color:#e14242");
        }
        function iconosGrisesCronogramas(){
            $("#cronogramasIntervencion").attr("src","./images/GrisesHover/Cronogramas.png");
            $("#idlblCronogramas").attr("style","color:#525151");
        }
        function iconosRojosIndicadores(){
            $("#Indicadores").attr("src","./images/RojosHover/Indicadores.png");
            $("#idlblIndicadores").attr("style","color:#e14242");
        }
        function iconosGrisesIndicadores(){
            $("#Indicadores").attr("src","./images/GrisesHover/Indicadores.png");
            $("#idlblIndicadores").attr("style","color:#525151");
        }
        </script>
    </head>
    <body class="b">
<?php 
       require_once('./EstadoIntervenciones.php');
       require_once ('./conexion.php');
       $con=  conectar();
       if($_SESSION['usuario']==""){
            $_SESSION['usuario']=$_POST['usuario'];
        }else{
            $_SESSION['usuario'];
        }
        $usuario=$_SESSION['usuario'];
        $queryTipoUsuario="SELECT Tipo_Usuario FROM usuarios_creados WHERE Usuario='$usuario'";
        $conexionTipoUsuario=mysql_query($queryTipoUsuario, $con);
         while($arrayTipoUsuario=mysql_fetch_array($conexionTipoUsuario)){
             $_SESSION['TipoUsuario']=$arrayTipoUsuario['Tipo_Usuario'];
             echo "<input type='hidden' id='tipoUsuarioCuenta' name='tipoUsuarioCuenta' value='".$arrayTipoUsuario['Tipo_Usuario']."'>";
        }
        Menu();
        function Menu(){
?>
        <div id="franjaColores">
        <div style="width: 25%;float: left;background: #e14242;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #ffde00;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #3e88da;height: 7px;">.</div>
        <div style="width: 25%;float: left;background: #00cd6b;height: 7px;">.</div>
        </div>
            <div id="panelLogo">
                <div id="imagenLogo"><img id="logo" src="images/LogoApp/logo.png"></div>
<?php
                if($_SESSION['TipoUsuario']=="Consulta"){
                    $VisualizarPanelControlIntervenciones="display: none;";
                }else{
                    $VisualizarPanelControlIntervenciones="";
                }
?>
              <div id="panel" style="<?php echo $VisualizarPanelControlIntervenciones; ?>">
<?php
                            // esta funcion se ejecuta en EstadoIntervenciones.php
                                estadoIntervenciones();
?>
            </div>
    </div>
            <div id="contenedorBotones">
                <div id="encabezado" class="page-header" style="border-bottom: 1px solid #a3a3a3">
                    <label id="Usuario">Bienvenid@: <?php echo $_SESSION['usuario']; ?></label>
                    <h2 style="font-weight: bold;margin-left:5%;margin-top: 90px;">PANEL DE CONTROL</h2>
                    <h3 style="margin-left:5%;margin-top: -5px;">ADMINISTRADOR DE EQUIPOS</h3>
<div style="text-align: right;margin-right: 7%;margin-top: -100px;">
                    <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Parametros del sistema
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="margin-left: 83%;">
    <li><a href="CrearTipoEquipos_CodHV.php">Crear tipo de equipos</a></li>
    <li><a href="CrearUbicacion.php">Crear ubicación de equipos</a></li>
    <li><a href="CrearUsuario.php">Crear usuarios</a></li>
    <li><a href="CrearProveedor.php">Crear proveedores</a></li>
</ul>
</div>
</div>
                </div>
    <center>
        <div id="Fila1">
<div class="row" id="uno" onmouseover="iconosRojos();" onmouseout="iconosGrises();">
  <a href='Buscar_hojaVida.php' title='Buscar y editar hoja de vida de equipos.' id="enlance1"><img src='./images/GrisesHover/BuscarHV.png' id='buscarEquipo'>
      <div class="caption">
          <h4 id="idBuscar" class="nombre" style="color: #525151;">BUSCAR<br/> EQUIPO</h4>
      </div></a>
</div>
<div class="row" id="seis"  onmouseover="iconosRojosReportarFalla();" onmouseout="iconosGrisesReportarFalla();">
      <a title="Falla en equipo" href="ReportarFallaEquipo.php" id="enlance2"><img src="./images/GrisesHover/ReportarFalla.png" id="ReportarFalla">
      <div class="caption">
          <h4 id="idReportarFalla" class="nombre" style="color: #525151;">REPORTAR<br/> FALLA</h4>
      </div></a>
</div>
            <div class="row" id="tres"  onmouseover="iconosRojosReportarIntervencion();" onmouseout="iconosGrisesReportarIntervencion();">
      <a title='Reportar Intervencion' href='reporteIntervencion.php' id="enlance3"><img src='./images/GrisesHover/ReportarIntervencion.png' id='reporteIntervencionMenu'>
      <div class="caption">
          <h4 id="idReportarIntervencion" class="nombre" style="color: #525151;">REPORTAR <br/>INTERVENCION</h4>
      </div></a>
</div>
            <div class="row" id="cuatro"  onmouseover="iconosRojosObsolescencia();" onmouseout="iconosGrisesObsolescencia();">
      <a title='Indice de obsolescencia' href='indiceObsolescencia.php' id="enlance4"><img src='./images/GrisesHover/Obsolescencia.png' id='Obsolescencia'>
      <div class="caption">
          <h4 id="idlblObsolescencia" class="nombre" style="color: #525151;">INDICE <br/>OBSOLESCENCIA</h4>
      </div></a>
</div>
        </div>
    </center>
        <center>
        <div id="Fila2" style="<?php echo $VisualizarPanelControlIntervenciones; ?>">  
<div class="row" id="dos"  onmouseover="iconosRojosOrdenes();" onmouseout="iconosGrisesOrdenes();">
  <a title='Ordenes de trabajo' href='BuscadorOrdenesTrabajo.php' id="enlance5"><img src='./images/GrisesHover/Ordenes.png' id="ordenesTrabajo">
      <div class="caption">
          <h4 id="idlblOrdenes" class="nombre" style="color: #525151;">ORDENES DE<br/>TRABAJO</h4>
      </div></a>
</div>      
            <div class="row" id="cinco"  onmouseover="iconosRojosCrearHV();" onmouseout="iconosGrisesCrearHV();">
      <a title="Crear equipo" href="hojaVida.php" id="enlance6"><img src="images/GrisesHover/HojaVida.png" id="crearHojaVida">
      <div class="caption">
          <h4 id="idlblCrearEquipo" class="nombre" style="color: #525151;">CREAR<br/> EQUIPO</h4>
      </div></a>
</div>
            <div class="row" id="siete"  onmouseover="iconosRojosCronogramas();" onmouseout="iconosGrisesCronogramas();">
      <a title="Cronogramas de intervención" href="Cronogramas.php" id="enlance7"><img src="./images/GrisesHover/Cronogramas.png" id="cronogramasIntervencion">
      <div class="caption">
          <h4 id="idlblCronogramas" class="nombre" style="color: #525151;">CRONOGRAMAS</h4>
      </div></a>
</div>  
            <div class="row" id="ocho"  onmouseover="iconosRojosIndicadores();" onmouseout="iconosGrisesIndicadores();">
  <a title="Indicadores" href="Estadisticas.php" id="enlance8"><img src="./images/GrisesHover/Indicadores.png" id="Indicadores">
      <div class="caption">
          <h4 id="idlblIndicadores" class="nombre" style="color: #525151;">INDICADORES</h4>
      </div></a>
</div>      
<!--<div class="row" id="nueve">
      <a title="Tecnovigilancia" href="TecnoVigilancia.php" id="enlance9"><img src="./images/rojos/Buscar.png" id="Tecnovigilancia">
      <div class="caption">
          <h4 id="idlblTecnovigilancia" class="nombre" style="color: #525151;">TECNOVIGILANCIA</h4>
      </div></a>
</div>  -->
        </div> <!--Fin container-->    
        </center>
        </div>
<?php
        }
?>
</body>
</html>