<?php
if (isset($_GET['aper_cod'])) {
    $aper_cod = $_GET['aper_cod'];
    
    // Consulta para obtener los detalles de la apertura seleccionada
    $detalle_apertura = consultas::get_datos("SELECT * FROM apertura_cierre WHERE aper_cod = {$aper_cod}");
    
    if (!empty($detalle_apertura)) {
        // Muestra los detalles que desees
        echo "<strong>Código de Apertura:</strong> " . $detalle_apertura[0]['aper_cod'] . "<br>";
        echo "<strong>Descripción:</strong> " . $detalle_apertura[0]['aper_descrip'] . "<br>";
        // Puedes agregar más detalles según lo que necesites mostrar
    } else {
        echo "No se encontraron detalles para esta apertura.";
    }
} else {
    echo "No se seleccionó ninguna apertura.";
}
?>

