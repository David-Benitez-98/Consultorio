<?php

require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_avisos(
         " . $_REQUEST['accion'] . ",
          " . (!empty($_REQUEST['vrec_cod']) ? $_REQUEST['vrec_cod'] : "0") . ",
         " . $_SESSION['usu_cod'] . ", 
         " . (!empty($_REQUEST['vcita_cod']) ? $_REQUEST['vcita_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vaviso_observ']) ? $_REQUEST['vaviso_observ'] : "") . "',
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod'] : "0") . " ) as resul";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(rec_cod), 0) AS id from v_avisos_recordatorios";
    $resultado = consultas::get_datos($sql);
    header("location:avisos_index.php?vrec_cod=" . $resultado[0]['id']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:avisos_index.php?vrec_cod=".$_REQUEST['vrec_cod']);
}
?>
