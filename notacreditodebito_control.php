<?php
require 'clases/conexion.php';
session_start();

// Validar entrada según la acción
if (empty($_REQUEST['tim_cod']) && $_REQUEST['accion'] == 1) {
    $_SESSION['mensaje'] = "Error: El código de timbrado es obligatorio para insertar.";
    header("location:notacd_detalle_add.php");
    exit();
}

// Obtener y sanitizar los valores de entrada
$accion = (int)$_REQUEST['accion'];
$notc_cod = !empty($_REQUEST['notc_cod']) ? (int)$_REQUEST['notc_cod'] : 0;
$tim_cod = !empty($_REQUEST['tim_cod']) ? (int)$_REQUEST['tim_cod'] : 0;
$aper_cod = !empty($_REQUEST['aper_cod']) ? (int)$_REQUEST['aper_cod'] : 0;
$notc_estado = !empty($_REQUEST['notc_estado']) ? $_REQUEST['notc_estado'] : 'PENDIENTE';
$notc_fecha = !empty($_REQUEST['notc_fecha']) ? "'{$_REQUEST['notc_fecha']}'" : "CURRENT_DATE";
$pac_cod = !empty($_REQUEST['vpac_cod']) ? (int)$_REQUEST['vpac_cod'] : 0;
// Construcción de la consulta SQL según la acción
if ($accion == 1) { // Insertar nueva nota
    $sql = "SELECT sp_nota_creditodebito(
        {$accion},
        NULL,
        {$tim_cod},
        {$aper_cod},
        '{$notc_estado}',
        {$notc_fecha},
            {$pac_cod}
    ) AS resul";
} elseif ($accion == 2) { // Actualizar nota existente
    if ($notc_cod > 0) {
        $sql = "SELECT sp_nota_creditodebito(
            {$accion},
            {$notc_cod},
            NULL,
            NULL,
            '{$notc_estado}',
            NULL
        ) AS resul";
    } else {
        $_SESSION['mensaje'] = "Error: Código de la nota requerido para actualizar.";
        header("location:notacreditodebito_index.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "Error: Acción no válida.";
    header("location:notacreditodebito_index.php");
    exit();
}

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado de la consulta
if ($resultado && isset($resultado[0]['resul'])) {
    $mensaje = $resultado[0]['resul'];
    $_SESSION['mensaje'] = $mensaje;

    // Redirigir según el resultado
    if (strpos($mensaje, 'insertado correctamente') !== false || 
        strpos($mensaje, 'actualizado correctamente') !== false) {
        header("location:notacd_detalle_add.php");
    } else {
        // Mensaje inesperado o error de la función almacenada
        $_SESSION['mensaje'] = $mensaje;
        header("location:notacd_detalle_add.php");
    }
} else {
    // Error al ejecutar la consulta o sin resultados
    $_SESSION['mensaje'] = "Error: No se obtuvieron resultados.";
    header("location:notacd_detalle_add.php");
}
?>
