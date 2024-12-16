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

// Ahora puedes usar $vaper_cod en tu proceso de cobros
$sql = "SELECT sp_cobros(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vcobro_cod']) ? $_REQUEST['vcobro_cod'] : "0") . ",
         " . (!empty($_REQUEST['vcobro_monto']) ? $_REQUEST['vcobro_monto'] : "0") . ",
         '" . (!empty($_REQUEST['vcobro_tipopago']) ? $_REQUEST['vcobro_tipopago'] : "") . "',
         " . $vaper_cod . "
    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "SELECT COALESCE(MAX(cobro_cod), 0) AS id FROM cobros";
    $resultado = consultas::get_datos($sql);
    header("location:cobros_add.php?vcobro_cod=" . $resultado[0]['id']);
} else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:cobros_index.php");
}
?>
