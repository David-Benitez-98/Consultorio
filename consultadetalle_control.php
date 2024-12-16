<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_consultadetalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vcod_consulta']) ? $_REQUEST['vcod_consulta'] : "0") . ",  
         " . (!empty($_REQUEST['vsin_cod']) ? $_REQUEST['vsin_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vobservacion']) ? $_REQUEST['vobservacion']  : "0") . "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:consultadetalle_add.php?vcod_consulta=".$_REQUEST['vcod_consulta']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:consultas_index.php");
}
?>

