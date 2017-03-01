<?php
require_once './dompdf_0-7-0/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$content='
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>';
    $content.='<h1>EJEMPLO GENERA PDF</h1>
         <p>Te genera la orden que le realizaste al proveedor</p>';   
            "<p>Esta parte no quiero que salga</p>";
        $content.='<input type="submit" name="enviar" value="Generar">';
    $content.='</body>
</html>';

// reference the Dompdf namespace

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>