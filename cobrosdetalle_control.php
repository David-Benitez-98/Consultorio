<?php
require 'clases/conexion.php';
session_start();

// Definir `$ban` para determinar la acción
$ban = isset($_REQUEST['accion']) ? intval($_REQUEST['accion']) : 0;
$vcobro_cod = isset($_REQUEST['vcobro_cod']) ? intval($_REQUEST['vcobro_cod']) : 0;
$vcta_nro_cuota = isset($_REQUEST['vcta_nro_cuota']) ? intval($_REQUEST['vcta_nro_cuota']) : 0;
$fac_cod = isset($_REQUEST['fac_cod']) ? intval($_REQUEST['fac_cod']) : 0;
$vcantidad_cobro = isset($_REQUEST['vcantidad_cobro']) ? floatval($_REQUEST['vcantidad_cobro']) : 0;

$sql = "SELECT sp_cobro_detalle(
         $ban,
         $vcta_nro_cuota,
         $fac_cod,
         $vcobro_cod,
         $vcantidad_cobro
    ) as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redireccionar en consecuencia
if ($resultado && isset($resultado[0]['resul'])) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];

    // Redirigir al lugar correcto según la operación realizada
    header("Location: cobros_add.php?vcobro_cod=" . $vcobro_cod);
} else {
    // Mensaje de error si la consulta no se ejecutó correctamente
    $_SESSION['mensaje'] = "Error: " . pg_last_error();
    header("Location: cobros_add.php?vcobro_cod=" . $vcobro_cod);
}
?>
