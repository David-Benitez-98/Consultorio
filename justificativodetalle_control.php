<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_justificativo_detalle(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vjus_cod']) ? $_REQUEST['vjus_cod'] : "0") . ",  
         " . (!empty($_REQUEST['vmot_cod']) ? $_REQUEST['vmot_cod'] : "0") . ",
         '" .(isset($_REQUEST['vjusti_fechainicio']) ? $_REQUEST['vjusti_fechainicio'] : ''). "', 
         '" .(isset($_REQUEST['vjusti_fechafin']) ? $_REQUEST['vjusti_fechafin'] : ''). "',
         '" . (!empty($_REQUEST['vjus_obervacion']) ? $_REQUEST['vjus_obervacion']  : "0") . "') AS resul";

$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir con el mensaje correspondiente
if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:justificativodetalle_add.php?vjus_cod=".$_REQUEST['vjus_cod']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:justificativodetalle_add.php?vjus_cod=".$_REQUEST['vjus_cod']);
}
?>

