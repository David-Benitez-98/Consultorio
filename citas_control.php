<?php
require 'clases/conexion.php';
session_start();

// Parámetros para la función sp_agenda_detalle
$sql = "SELECT sp_citas(
           " . $_REQUEST['accion'] . ",
           " . (!empty($_REQUEST['vcita_cod']) ? $_REQUEST['vcita_cod'] : "0") . ",
           " . $_SESSION['usu_cod'] . ",
           " . (!empty($_REQUEST['vpac_cod']) ? $_REQUEST['vpac_cod'] : "0") . ",
           '".(!empty($_REQUEST['vcita_hora']) ? $_REQUEST['vcita_hora'] : "00:00:00")."',
           " . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ", 
           '" . (!empty($_REQUEST['vrazon_cita']) ? $_REQUEST['vrazon_cita'] :  "") . "',
           " . (!empty($_REQUEST['dias']) ? $_REQUEST['dias'] : "0") . ",
           '" . (!empty($_REQUEST['vcita_estado']) ? $_REQUEST['vcita_estado'] : "PENDIENTE") . "' ) as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir
if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:citas_index.php?vcita_cod=".$_REQUEST['vcita_cod']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:citas_index.php?vcita_cod=".$_REQUEST['vcita_cod']);
}
?>