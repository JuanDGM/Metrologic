<script src="DataTable/js/jquery.dataTables.min.js"></script>
<script src="DataTable/css/dataTables.material.min.css"></script>
<script src="DataTable/js/dataTables.bootstrap.min.js"></script>

<?php

include ('./conexion.php');
$con=  conectar();

// cuando no se selecciona ningun filtro en la busqueda
    
    $queryBuscar="SELECT
	IF(p.Area IS null, 'NO TIENE UBICACIÓN',p.Area) AS Area,
	h.Id,
	h.No_HV,
	h.Tipo_Equipo, 
	h.Nombre_Equipo 
FROM
	hoja_vida as h 
	LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
WHERE
	IF(CONCAT(h.No_HV, p.Version) IS null,1,

    CONCAT(h.No_HV, p.Version) IN (
			SELECT
    			CONCAT(
				h.No_HV, 
				MAX(p.Version)
			) 
		FROM 
			hoja_vida as h 
			LEFT JOIN puesta_marcha as p ON h.No_HV = p.No_HV 
		WHERE 
			1 
		GROUP BY 
			h.No_HV
	))
GROUP BY 
	p.Area, 
	h.Tipo_Equipo, 
	h.No_HV";

    $conexionBuscar=mysql_query($queryBuscar, $con);
   
    if(isset($conexionBuscar)){
        ?> 
    
<script type="text/javascript">
$(document).ready(function(){
    $("#tableBusqueda").DataTable({
        
        "language":{
            "search": "Busqueda Rapida",
            "info": "Mostrando paginas _PAGE de _PAGES"
           }
        
    });
});
</script>

<div class="table-responsive" style="width: 80%;margin: auto">
    <table id="tableBusqueda" class="table table-bordered">
        <thead>
        <tr style="background: #eee;text-align: center">
            <td>AREA</td>
            <td>No HV</td>
            <td>TIPO DE EQUIPO</td>
            <td>NOMBRE DEL EQUIPO</td>
            <td>FICHA TÉCNICA</td>
        </tr>
        </thead>
        <tbody>
      <?php
  
      while($arrayBuscar=mysql_fetch_array($conexionBuscar)){
        
       echo "<tr>"; 
       echo "<td>".$arrayBuscar['Area']."</td>";
       echo "<td>".$arrayBuscar['No_HV']."</td>";
       echo "<td>".$arrayBuscar['Tipo_Equipo']."</td>";
       echo "<td>".$arrayBuscar['Nombre_Equipo']."</td>";
       $id=$arrayBuscar['Id'];
       echo "<td>";
    echo "<form id='formularioedicion' method='POST' action='hojaVida.php'>";
    
        echo "<input type='hidden' value='none' name='desdebuscador'>";       
        echo "<input type='hidden' name='idseleccionado1' value='$id'>";
       
        echo "<button type='submit' id='idseleccionado'><span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
    echo "</td>";   
    echo "</form>";   
     }        
    
       echo "</tr>";     
           ?> 
            </tbody>
  </table>
    
</div>
    <?php
    } else {
        echo json_encode("Fallas en la Conexion");
    }
