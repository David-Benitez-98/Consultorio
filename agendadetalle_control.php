<?php
require 'clases/conexion.php';
session_start();

// Parámetros para la función sp_agenda_detalle
$sql = "SELECT sp_agenda_detalle(
        ".$_REQUEST['accion'].",
        ".(!empty($_REQUEST['vagen_cod'])? $_REQUEST['vagen_cod']:"0").",
        ".(!empty($_REQUEST['vdoc_cod']) ? $_REQUEST['vdoc_cod'] : "0").",
        ".(!empty($_REQUEST['vesp_cod']) ? $_REQUEST['vesp_cod'] : "0").",
        ".(!empty($_REQUEST['vdia_cod']) ? $_REQUEST['vdia_cod'] : "0").",
        ".(!empty($_REQUEST['vtur_cod']) ? $_REQUEST['vtur_cod'] : "0").",
        '".(!empty($_REQUEST['vhora_inicio']) ? $_REQUEST['vhora_inicio'] : "00:00:00")."',
        '".(!empty($_REQUEST['vhora_fin']) ? $_REQUEST['vhora_fin'] : "00:00:00")."',
        ".(!empty($_REQUEST['vcupos']) ? $_REQUEST['vcupos'] : "0").",
        ".(!empty($_REQUEST['vsal_cod']) ? $_REQUEST['vsal_cod'] : "0").",
        '".(!empty($_REQUEST['vobservacion']) ? $_REQUEST['vobservacion'] : "")."',
        '".(!empty($_REQUEST['vdet_estado']) ? $_REQUEST['vdet_estado'] : "CONFIRMADO")."' ) as resul";
// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir
if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:agendadetalle_add.php?vagen_cod=".$_REQUEST['vagen_cod']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:agendadetalle_add.php?vagen_cod=".$_REQUEST['vagen_cod']);
}
?>

