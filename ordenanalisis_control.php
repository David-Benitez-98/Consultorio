<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_ordenanalisis(
         " . $_REQUEST['accion'] . ",
             " . $_REQUEST['voa_cod'] . ",
         " . $_SESSION['usu_cod'] . ",
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod']  : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(oa_cod), 0) AS voa_cod from v_ordenanalisis";
    $resultado = consultas::get_datos($sql);
    header("location:ordenanalisisdetalle_add.php?voa_cod=".$_REQUEST['voa_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:ordenanalisis_index.php");
}
?>

