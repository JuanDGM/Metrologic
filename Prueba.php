<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proximas Intervenciones</title>

    </head>
    <body>
        
        <form method="POST" action="Prueba.php">
        Nombre: <input type="text" name="name">
        Apellido: <input type="text" name="apellido">
        
        <input type="submit" value="enviar" name="enviar">
        </form>

            <?php
                include('./conexion.php');
                $con=  conectar();
                
                if(isset($_POST['enviar'])){
                
                    $n=$_POST['name'];
                    $a=$_POST['apellido'];
                    
                $queryInsertar="INSERT INTO prueba VALUES ('','$n','$a')";
                $DatosInsertados=mysql_query($queryInsertar, $con);
                }
                $queryMostrar="SELECT * FROM prueba WHERE 1";
                $datosquery=mysql_query($queryMostrar, $con);
                while($array=  mysql_fetch_array($datosquery)){
                    echo $array[0];
                    echo $array[1];
                    echo $array[2]."<br/>";
                }
             ?>
    </body>
</html>