<?php
require 'clases/conexion.php';
session_start();

// Sanitize inputs
$accion = isset($_REQUEST['accion']) ? intval($_REQUEST['accion']) : 0;
$vfac_cod = isset($_REQUEST['vfac_cod']) ? intval($_REQUEST['vfac_cod']) : 0;
$vservi_cod = isset($_REQUEST['vservi_cod']) ? intval($_REQUEST['vservi_cod']) : 0;
$vcantidad = !empty($_REQUEST['vcantidad']) ? floatval($_REQUEST['vcantidad']) : 0;
$vprecio = !empty($_REQUEST['vprecio']) ? floatval($_REQUEST['vprecio']) : 0;

// Validar si el servicio seleccionado es correcto para evitar errores
if ($accion != 3 && $vservi_cod == 0) { // Si no es una operación de eliminación y el servicio es 0
    $_SESSION['mensaje'] = "Error: Debes seleccionar un servicio.";
    header("Location: facturadetalle_add.php?vfac_cod=" . $vfac_cod);
    exit();
}

// Construir consulta SQL para llamar a la función almacenada
$sql = "SELECT sp_detalle_factura(
    $accion,
    $vfac_cod, 
    $vservi_cod,
    $vcantidad, 
    $vprecio
) AS resul";

$resultado = consultas::get_datos($sql);

// Verificar resultado y redirigir con el mensaje correspondiente
if ($resultado && isset($resultado[0]['resul'])) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];

    // Redirigir al lugar correcto según la operación realizada
    if ($accion == 3) { // Eliminación
        header("Location: facturadetalle.php?vfac_cod=" . $vfac_cod);
    } else { // Agregar o modificar
        header("Location: facturadetalle_add.php?vfac_cod=" . $vfac_cod);
    }
} else {
    // Mensaje de error si la consulta no se ejecutó correctamente
    $_SESSION['mensaje'] = "Error: " . pg_last_error() . " - Consulta: " . $sql;
    header("Location: facturadetalle_add.php?vfac_cod=" . $vfac_cod);    
}
?>
