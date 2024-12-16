<?php

require 'clases/conexion.php';
session_start();

// Crear la consulta SQL para llamar al procedimiento almacenado Sp_cheque
$sql = "SELECT Sp_cheque(" . $_REQUEST['accion'] . ", " .
    (!empty($_REQUEST['che_cod']) ? $_REQUEST['che_cod'] : "0") . ", " .
    "'" . (!empty($_REQUEST['titular_cheque']) ? $_REQUEST['titular_cheque'] : "") . "', " .
    (!empty($_REQUEST['nro_cheque']) ? $_REQUEST['nro_cheque'] : "0") . ", " .
    (!empty($_REQUEST['fecha_cheque']) ? "'" . $_REQUEST['fecha_cheque'] . "'" : "null") . ", " .
    (!empty($_REQUEST['venci_cheque']) ? "'" . $_REQUEST['venci_cheque'] . "'" : "null") . ", " .
    (!empty($_REQUEST['ban_cod']) ? $_REQUEST['ban_cod'] : "0") . ") AS resul";

// Ejecutar la consulta utilizando la clase consultas
$resultado = consultas::get_datos($sql);

// Verificar si el resultado es válido
if ($resultado[0]['resul'] != null) {
    // Guardar el resultado en la sesión y redirigir según la acción
    $_SESSION['mensaje'] = "Operación realizada exitosamente.";
    header("location:cheque_index.php");
} else {
    // En caso de error, mostrar mensaje y redirigir
    $_SESSION['mensaje'] = "Error: No se pudo realizar la operación.";
    header("location:cheque_index.php");
}

?>
