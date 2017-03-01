<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cuenta Usuario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="EstilosIndex.css">
        <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Muli|Strait" rel="stylesheet">
        <script href="./jquery/jquery-1.11.3.js"></script>
        <script src="bootstrap-3.3.6-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.6-dist/js/datepicker.js"></script>
        <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
     
        <script>
        
                    function cambiar()
                            {
                            var index=document.forms.formBuscador.Ciudad.selectedIndex;

                            
                            if(index==0) ciudad0();
                            if(index==1) ciudad1();

                            }
function ciudad0(){
    
    <?php
    
                $querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
            
    ?>
    
    opcion0=new Option(<?php 
    
    while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                    echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                }
    
    ?>,<?php 
    
    while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                   
                    echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                }
    
    ?>
            
                
                ,"defauldSelected");
    document.forms.formBuscador.Sede.options[0]=opcion0;
    
}
function ciudad1(){
    
    opcion0=new Option("Avenida1","Avenida1","defauldSelected");
    opcion1=new Option("Buga1","Buga1","defauldSelected");
    
    document.forms.formBuscador.Sede.options[0]=opcion0;
    document.forms.formBuscador.Sede.options[1]=opcion1;
    
}



//                            if(index==0) trimestre1();
//                            if(index==1) trimestre2();
//                            if(index==2) trimestre3();
//                            if(index==3) trimestre4(); 
//                            }
//
//
//function trimestre1(){
//opcion0=new Option("Enero","Enero","defauldSelected");
//opcion1=new Option("Febrero","Febrero");
//opcion2=new Option("Marzo","Marzo");
//
//document.forms.formulario.meses.options[0]=opcion0;
//document.forms.formulario.meses.options[1]=opcion1;
//document.forms.formulario.meses.options[2]=opcion2; 
//}
//
//
//
//function trimestre2(){
//opcion0=new Option("Abril","Abril","defauldSelected");
//opcion1=new Option("Mayo","Mayo");
//opcion2=new Option("Junio","Junio");
//
//document.forms.formulario.meses.options[0]=opcion0;
//document.forms.formulario.meses.options[1]=opcion1;
//document.forms.formulario.meses.options[2]=opcion2; 
//}
//
//function trimestre3(){
//opcion0=new Option("Julio","Julio","defauldSelected");
//opcion1=new Option("Agosto","Agosto");
//opcion2=new Option("Septiembre","Septiembre");
//
//document.forms.formulario.meses.options[0]=opcion0;
//document.forms.formulario.meses.options[1]=opcion1;
//document.forms.formulario.meses.options[2]=opcion2; 
//}
//
//function trimestre4(){
//opcion0=new Option("Octubre","Octubre","defauldSelected");
//opcion1=new Option("Noviembre","Noviembre");
//opcion2=new Option("Diciembre","Diciembre");
//
//document.forms.formulario.meses.options[0]=opcion0;
//document.forms.formulario.meses.options[1]=opcion1;
//document.forms.formulario.meses.options[2]=opcion2; 
//}



        
        </script>
        
        
        
        
    </head>
    <body>

            <form name="formulario" method="post" action="">
<div align="center">Trimestre 
<select name="trimestres" OnChange="cambiar()">
<option value="1er. Trimestre" selected>1er. Trimestre</option>
<option value="2do. Trimestre">2er. Trimestre</option>
<option value="3er. Trimestre">3er. Trimestre</option>
<option value="4to. Trimestre">4to. Trimestre</option>
</select>
Meses 
<select name="meses">
<option value="Enero" selected>Enero</option>
<option value="Febrero">Febrero</option>
<option value="Marzo">Marzo</option>
</select>
</div>
</form>

        
<form name="formBuscador" method="POST" action="#">
    <div class="form-group" id="Ciudad">
                <?php
                include_once ('./conexion.php');
                $con=  conectar();
                if(isset($Ciudad)){
                  $c=$Ciudad;  
                }else{
                  $c="";  
                }
                
                $querySeleccionCiudad="SELECT Sede FROM ubicaciones GROUP BY Sede";
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                
                ?>
       
            
        <div class="form-group" id="campoCiudad">
                <label class="lblFiltros">CIUDAD</label>
                <select class="form-control" name="Ciudad" id="txtCiudad" value="<?php echo $c; ?>" placeholder="<?php echo $c; ?>" OnChange="cambiar();">
                    
                    <option value="Otro">Otro</option>
                    
                   <?php
                   while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                   
                    echo "<option value='".$arraySeleccionCiudad['Sede']."'>".$arraySeleccionCiudad['Sede']."</option>";
                }
                   ?>
                </select>
        </div>
    </div>
    
    <?php $c; ?>
    
<div class="form-group" id="campoSede">
                 <?php
                if(isset($Sede)){
                  $s=$Sede;  
                }else{
                  $s="Todos";  
                }
                
                if($c==""){
                $querySeleccionCiudad="SELECT Area FROM ubicaciones WHERE 1 GROUP BY Area";
                 $c;   
                }else{
                    $querySeleccionCiudad="SELECT Area FROM ubicaciones WHERE Sede='$c' GROUP BY Area";
                    
                }
                
                
                
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                
                ?>   
                
                <label class="lblFiltros">SEDE</label>
                <!--<input type="text" name="Sede" id="txtSede" class="form-control" value="<?php //echo $s; ?>" placeholder="<?php //echo $s; ?>">-->
                <select class="form-control" name="Sede" id="txtSede" value="<?php echo $s; ?>" placeholder="<?php echo $s; ?>">
                    
                   <?php
                   while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                   
                    echo "<option>".$arraySeleccionCiudad['Area']."</option>";
                }
                   ?>
                   </select>
        </div>
    
    <div class="form-group" id="CampoArea">
         <?php
                if(isset($Area)){
                  $a=$Area;  
                }else{
                  $a="";  
                }
                
                $querySeleccionCiudad="SELECT Sub_Area FROM ubicaciones GROUP BY Sub_Area";
                $conexionSeleccionCiudad=mysql_query($querySeleccionCiudad, $con);
                ?>        
        
        <label class="lblFiltros">AREA</label>
                <!--<input type="text" name="Area" id="txtArea" class="form-control" value="<?php //echo $a; ?>" placeholder="<?php //echo $a; ?>">-->
                <select class="form-control" name="Area" id="txtArea" value="<?php echo $a; ?>" placeholder="<?php echo $a; ?>">
                <?php
                   while($arraySeleccionCiudad=mysql_fetch_array($conexionSeleccionCiudad)){
                    echo "<option>".$arraySeleccionCiudad['Sub_Area']."</option>";
                }
                   ?>
                   </select>
    </div>
    
    <div class="form-group" id="campoTipo_equipo">
        <?php
                if(isset($tp)){
                  $t=$tp;  
                }else{
                  $t="";  
                }
                ?>        
        
        <label class="lblFiltros">TIPO EQUIPO</label>
                <input type="text" id="txtTipoEquipo" name="tipoEquipo" class="form-control" value="<?php echo $t; ?>" placeholder="<?php echo $t; ?>">
            </div>
    
    <div class="form-group" id="campoCod_HV">
        <?php
                if(isset($CodHV)){
                  $ch=$CodHV;  
                }else{
                  $ch="";  
                }
                ?>        
        
        <label class="lblFiltros">No EQUIPO</label>
                <input type="text" id="txtCodEquipo" name="Cod_Equipo" class="form-control" value="<?php echo $ch; ?>" placeholder="<?php echo $ch; ?>">
            </div>
    <br/>
    <div id="campobtn">
    
    <button type="submit" name="enviar" class="btn btn-primary">Generar</button>
    </div>
    </form>        
        
        


                <?php




                ?>

    </body>
        
</html>