<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_diagnostico_detalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vdiag_cod']) ? $_REQUEST['vdiag_cod'] : "0") . ",  
         " . (!empty($_REQUEST['venfe_cod']) ? $_REQUEST['venfe_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vdiag_descri']) ? $_REQUEST['vdiag_descri']  : "0") . "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:diagnosticodetalle_add.php?vdiag_cod=".$_REQUEST['vdiag_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:diagnostico_index.php");
}
?>

