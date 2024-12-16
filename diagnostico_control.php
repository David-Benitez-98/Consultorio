<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_diagnostico(
         " . $_REQUEST['accion'] . ",
         " . $_REQUEST['vdiag_cod'] . ",
         " . $_SESSION['usu_cod'] . ",  
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod'] : "0") . ",
         " . (!empty($_REQUEST['voe_cod']) ? $_REQUEST['voe_cod'] : "0") . ",
         " . (!empty($_REQUEST['voa_cod']) ? $_REQUEST['voa_cod'] : "0")
         . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(diag_cod), 0) AS vdiag_cod from v_diagnostico";
    $resultado = consultas::get_datos($sql);
    header("location:diagnosticodetalle_add.php?vdiag_cod=".$_REQUEST['vdiag_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:diagnostico_index.php");
}
?>

