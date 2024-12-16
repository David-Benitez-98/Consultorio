<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_ordenanalisis_detalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['voa_cod']) ? $_REQUEST['voa_cod'] : "0") . ",  
         " . (!empty($_REQUEST['vtipooa_cod']) ? $_REQUEST['vtipooa_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vobservacion']) ? $_REQUEST['vobservacion']  : "0") . "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:ordenanalisisdetalle_add.php?voa_cod=".$_REQUEST['voa_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:ordenanalisis_index.php");
}
?>

