<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_tratamiento_detalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vtra_cod']) ? $_REQUEST['vtra_cod'] : "0") . ",  
         " . (!empty($_REQUEST['vtipotra_cod']) ? $_REQUEST['vtipotra_cod'] : "0") . ",
         '" . (!empty($_REQUEST['vdetalle_obser']) ? $_REQUEST['vdetalle_obser']  : "0") . "',
         " . (!empty($_REQUEST['vprecio']) ? $_REQUEST['vprecio']  : "0") . ",
         '" .(isset($_REQUEST['vtra_fechainicio']) ? $_REQUEST['vtra_fechainicio'] : ''). "', 
         '" .(isset($_REQUEST['vtra_fechafin']) ? $_REQUEST['vtra_fechafin'] : ''). "') AS resul";

$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir con el mensaje correspondiente
if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:tratamientodetalle_add.php?vtra_cod=".$_REQUEST['vtra_cod']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:tratamientodetalle_add.php?vtra_cod=".$_REQUEST['vtra_cod']);
}
?>

