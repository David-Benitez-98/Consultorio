<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_tratamiento(
         " . $_REQUEST['accion'] . ",
             " . $_REQUEST['vtra_cod'] . ",
         " . $_SESSION['usu_cod'] . ", 
         " . (!empty($_REQUEST['vdiag_cod']) ? $_REQUEST['vdiag_cod'] : "0") . ",
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod']  : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(tra_cod), 0) AS vtra_cod from v_tratamientos";
    $resultado = consultas::get_datos($sql);
    header("location:tratamientodetalle_add.php?vtra_cod=".$_REQUEST['vtra_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:tratamiento_index.php");
}
?>

