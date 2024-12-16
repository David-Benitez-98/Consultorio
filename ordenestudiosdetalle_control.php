<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_ordenestudios_detalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['voe_cod']) ? $_REQUEST['voe_cod'] : "0") . ",  
         " . (!empty($_REQUEST['vtipooe_cod']) ? $_REQUEST['vtipooe_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vobservacion']) ? $_REQUEST['vobservacion']  : "0") . "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:ordenestudiosdetalle_add.php?voe_cod=".$_REQUEST['voe_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:ordenestudios_index.php");
}
?>

