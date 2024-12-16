<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_procedimientodetalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vproce_cod']) ? $_REQUEST['vproce_cod'] : "0") . ",  
         " . (!empty($_REQUEST['vins_cod']) ? $_REQUEST['vins_cod'] : "0") . ",
         " . (!empty($_REQUEST['vcantidad_utilizada']) ? $_REQUEST['vcantidad_utilizada'] : "0") . ",
         '" . (!empty($_REQUEST['vobservacion']) ? $_REQUEST['vobservacion'] : "0"). "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:procedimientosdetalle_add.php?vproce_cod=".$_REQUEST['vproce_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:procedimientos_index.php");
}
?>

