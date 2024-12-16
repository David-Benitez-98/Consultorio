<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_procedimientos(
         " . $_REQUEST['accion'] . ",
         " . $_REQUEST['vproce_cod'] . ",
         " . $_SESSION['usu_cod'] . ",  
         " . (!empty($_REQUEST['vcod_consulta']) ? $_REQUEST['vcod_consulta'] : "0") . ",
         '" . (!empty($_REQUEST['vproce_descri']) ? $_REQUEST['vproce_descri'] : "0"). "',
        " .(!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod'] : "0").",
        " .(!empty($_REQUEST['vtipoproce_cod']) ? $_REQUEST['vtipoproce_cod'] : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(proce_cod), 0) AS vproce_cod from v_procedimiento";
    $resultado = consultas::get_datos($sql);
    header("location:procedimientosdetalle_add.php?vproce_cod=".$_REQUEST['vproce_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:procedimientos_index.php");
}
?>

