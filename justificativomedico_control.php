<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_justificativo(
         " . $_REQUEST['accion'] . ",
         " . $_REQUEST['vjus_cod'] . ",
         " . $_SESSION['usu_cod'] . ", 
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod'] : "0") . ",
         " . (!empty($_REQUEST['vdiag_cod']) ? $_REQUEST['vdiag_cod']  : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(jus_cod), 0) AS vjus_cod from v_justificativo";
    $resultado = consultas::get_datos($sql);
    header("location:justificativodetalle_add.php?vjus_cod=".$_REQUEST['vjus_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:justificativomedico_index.php");
}
?>

