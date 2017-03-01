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
                    $("#estadoIntervenciones").hide();
                    $("#OrdenesTrabajo").hide();
                    $("#crearHV").hide();
        }else if(tipoUsuarioIngresa=="Consulta"){
            $("#estadoIntervenciones").hide();
                    $("#OrdenesTrabajo").hide();
                    $("#crearHV").hide();
                    $("#reporteIntervercion").hide();
        }
        $('.dropdown-toggle').dropdown();
        // 
// efectos al menu buscador
//        $("#buscarEquipo").mouseenter(function(){
//            $("#buscarEquipo").css("width",310);
//            $("#buscarEquipo").css("height",260);
//        });
//        $("#buscarEquipo").mouseleave(function(){
//            $("#buscarEquipo").css("width",260);
//            $("#buscarEquipo").css("height",250);
//        });
//        
//        // efectos al menu Crear hoja Vida
//        $("#crearHojaVida").mouseenter(function(){
//            $("#crearHojaVida").css("width",310);
//            $("#crearHojaVida").css("height",260);
//        });
//        $("#crearHojaVida").mouseleave(function(){
//            $("#crearHojaVida").css("width",300);
//            $("#crearHojaVida").css("height",250);
//        });
//        
//        // efectos al menu Orden Orden TRabajo
//        $("#ordenesTrabajo").mouseenter(function(){
//            $("#ordenesTrabajo").css("width",310);
//            $("#ordenesTrabajo").css("height",260);
//        });
//        $("#ordenesTrabajo").mouseleave(function(){
//            $("#ordenesTrabajo").css("width",300);
//            $("#ordenesTrabajo").css("height",250);
//        });
        });
        </script>
    </head>
    <body class="b">
        <?php
        session_start();    
//include('./EstadoOrdenesTrabajo.php');
       include('./EstadoIntervenciones.php');
       include ('./conexion.php');
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
             $arrayTipoUsuario['Tipo_Usuario'];
             echo "<input type='hidden' id='tipoUsuarioCuenta' name='tipoUsuarioCuenta' value='".$arrayTipoUsuario['Tipo_Usuario']."'>";
        }
        Menu();
        function Menu(){
        ?>
        <!--<div id="contorno">-->
        <div class="page-header" id="encabezadoinicio">
            <label id="Usuario" style="color: white;margin-left: 90%;font-size: 15px;">Bienvenid@: <?php echo $_SESSION['usuario']; ?></label>
            <h1>
                <!--<img src="./images/Logo.png" style="width: 130px;margin-left: 30px;">-->
                <label id="tituloPrincipal">METROLOGIC</label> <small style="color: silver">Administrador de equipos</small>
                <!--<span class="glyphicon glyphicon-off" style="color: white;margin-left: 60%;cursor: pointer;"></span>-->
            </h1>
            <!-- Single button -->
            <div class="btn-group" id="idDropdown" style="float: right;margin-right: 20px;margin-top: -50px;">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Parametros del sistema <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
      <li><a href="CrearTipoEquipos_CodHV.php">Crear tipo de equipos</a></li>
      <li><a href="CrearUbicacion.php">Crear ubicación de equipos</a></li>
  </ul>
</div>
        </div>
    <center>
  <div id="Fila1">    
      <div id="alertas">
  
                            <?php
                            // esta funcion se ejecuta en EstadoIntervenciones.php
                                estadoIntervenciones();
                            ?>
            </div>
      <a title='Ordenes de trabajo' href='BuscadorOrdenesTrabajo.php'><img src='./images/OrdenesTrabajo1.png' id='ordenesTrabajo'></a>
            <a title='Reportar Intervencion' href='reporteIntervencion.php'><img src='./images/CrearHV.png' id='reporteIntervencionMenu'></a>
            <a title='Indice de obsolescencia' href='indiceObsolescencia.php'><img src='./images/IndiceObsolescencia.png' id='reporteIntervencionMenu'></a>
            <a title='Tecnovigilancia' href='TecnoVigilancia.php'><img src='./images/TecnoVigilancia.png' id='reporteIntervencionMenu'></a>
       
  </div>
        </center>
        <center>
        <div id="Fila2">  
            <a href='Buscar_hojaVida.php' title='Buscar y editar hoja de vida de equipos.'><img src='./images/BuscarHV.png' id='buscarEquipo'></a>
            <!--<a title='Crear equipo' href="AsignacionCodigoEquipo.php"><img src='images/HojaVida.jpg' id='crearHojaVida'></a>-->
            <a title='Crear equipo' href="hojaVida.php"><img src='images/CrearHV2.png' id='crearHojaVida'></a>
            <a title='Falla en equipo' href="ReportarFallaEquipo.php"><img src='./images/ReportarFallas.png' id="ReportarFalla"></a>
            <a title='Cronogramas de intervención' href="Cronogramas.php"><img src='./images/Cronogramas1.png' id="cronogramasIntervencion"></a>
            <a title='Indicadores   ' href="Estadisticas.php"><img src='./images/Indicadores.png' id="cronogramasIntervencion"></a>
        </div> <!--Fin container-->    
        </center>        
        <?php
        }
        ?> 
    <!--<footer style="background-color: #777;width: 100%;height: 50px;text-align: center;margin: auto;color:white">Realizado por Juan David Corporation, Derechos reservados 2016</footer>-->
</body>
</html>