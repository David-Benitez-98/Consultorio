<?php
require 'clases/conexion.php';
session_start();

// Consultar el código de la última apertura activa (sin fecha de cierre)
$sql = "SELECT aper_cod FROM apertura_cierre WHERE fecha_cierre IS NULL ORDER BY aper_cod DESC LIMIT 1";
$resultado = consultas::get_datos($sql);

if ($resultado) {
    $vaper_cod = $resultado[0]['aper_cod'];
} else {
    // Manejar el caso en el que no se encuentre una apertura activa
    $_SESSION['mensaje'] = "Error: No hay una apertura activa disponible.";
    header("location: apertura_index.php");
    exit();
}

// Llamar a la función 'sp_realizar_arqueo' con el código de apertura
$sql = "SELECT sp_realizar_arqueo($vaper_cod) AS resultado";
$resultado = consultas::get_datos($sql);

if (isset($resultado[0]['resultado']) && $resultado[0]['resultado'] != null) {
    $_SESSION['mensaje'] = "Arqueo realizado con éxito.";
} else {
    $_SESSION['mensaje'] = "Arqueo realizado con éxito.";
}

header("location:aperturaycierre_index.php");
?>
