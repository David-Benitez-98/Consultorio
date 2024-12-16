<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_ordenestudios(
         " . $_REQUEST['accion'] . ",
             " . $_REQUEST['voe_cod'] . ",
         " . $_SESSION['usu_cod'] . ",
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod']  : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(oe_cod), 0) AS voe_cod from v_ordenestudio";
    $resultado = consultas::get_datos($sql);
    header("location:ordenestudiosdetalle_add.php?voe_cod=".$_REQUEST['voe_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:ordenestudios_index.php");
}
?>

