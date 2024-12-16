<?php
require 'clases/conexion.php';
session_start();

// Validar parámetros iniciales
if (empty($_REQUEST['accion'])) {
    $_SESSION['mensaje'] = "Error: Acción no especificada.";
    header("location:factura_index.php");
    exit();
}

$accion = (int)$_REQUEST['accion'];
$usu_cod = isset($_SESSION['usu_cod']) ? (int)$_SESSION['usu_cod'] : 0;

if ($usu_cod === 0) {
    $_SESSION['mensaje'] = "Error: Usuario no autenticado.";
    header("location:factura_index.php");
    exit();
}

// Sanitizar y asignar parámetros
$tim_cod = isset($_REQUEST['tim_cod']) ? (int)$_REQUEST['tim_cod'] : 0;
$vpac_cod = isset($_REQUEST['vpac_cod']) ? (int)$_REQUEST['vpac_cod'] : 0;
$fac_condicion = isset($_REQUEST['fac_condicion']) ? $_REQUEST['fac_condicion'] : "CONTADO";
$fac_total = isset($_REQUEST['fac_total']) ? (float)$_REQUEST['fac_total'] : 0;
$aper_cod = isset($_REQUEST['aper_cod']) ? (int)$_REQUEST['aper_cod'] : 0;
$fac_intervalo = isset($_REQUEST['fac_intervalo']) ? (int)$_REQUEST['fac_intervalo'] : 0;
$fac_cantcuotas = isset($_REQUEST['fac_cantcuotas']) ? (int)$_REQUEST['fac_cantcuotas'] : 1;
$vfac_nro = isset($_REQUEST['vfac_nro']) ? $_REQUEST['vfac_nro'] : "0";
$vfac_cod = isset($_REQUEST['vfac_cod']) ? (int)$_REQUEST['vfac_cod'] : 0;

// Validaciones específicas según la acción
if ($accion === 1 && $tim_cod === 0) {
    $_SESSION['mensaje'] = "Error: El código de timbrado es obligatorio.";
    header("location:factura_add.php");
    exit();
}

if (($accion === 2 || $accion === 3) && $vfac_cod === 0) {
    $_SESSION['mensaje'] = "Error: Código de factura inválido para esta acción.";
    header("location:factura_index.php");
    exit();
}

// Construir consulta SQL según la acción
switch ($accion) {
    case 1: // Insertar factura
        $sql = "SELECT sp_factura(
            $accion, 
            0, 
            $usu_cod, 
            $tim_cod, 
            $vpac_cod, 
            '$fac_condicion', 
            $fac_total, 
            $aper_cod, 
            $fac_intervalo, 
            $fac_cantcuotas, 
            '$vfac_nro'
        ) AS resul";
        break;

    case 2: // Confirmar factura
        $sql = "SELECT sp_factura(
            $accion, 
            $vfac_cod, 
            $usu_cod, 
            $tim_cod, 
            NULL, NULL, NULL, NULL, NULL, NULL, NULL
        ) AS resul";
        break;

    case 3: // Anular factura
        $sql = "SELECT sp_factura(
            $accion, 
            $vfac_cod, 
            $usu_cod, 
            NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL
        ) AS resul";
        break;

    default:
        $_SESSION['mensaje'] = "Error: Acción no válida.";
        header("location:factura_index.php");
        exit();
}

// Ejecutar consulta y manejar resultados
$resultado = consultas::get_datos($sql);

if ($resultado && isset($resultado[0]['resul'])) {
    $mensaje = $resultado[0]['resul'];
    $_SESSION['mensaje'] = $mensaje;

    if (strpos($mensaje, 'insertada correctamente') !== false) {
        $sql = "SELECT COALESCE(MAX(fac_cod), 0) AS vfac_cod FROM factura";
        $codigo_factura = consultas::get_datos($sql);
        if ($codigo_factura && isset($codigo_factura[0]['vfac_cod'])) {
            header("location:facturadetalle_add.php?vfac_cod=" . $codigo_factura[0]['vfac_cod']);
        } else {
            $_SESSION['mensaje'] = "Error: No se pudo obtener el código de la factura.";
            header("location:factura_index.php");
        }
    } elseif (strpos($mensaje, 'SE ANULO CORRECTAMENTE') !== false || strpos($mensaje, 'SE CONFIRMO CORRECTAMENTE') !== false) {
        header("location:factura_index.php");
    } else {
        header("location:factura_index.php");
    }
} else {
    $_SESSION['mensaje'] = "Error: No se pudo procesar la solicitud.";
    header("location:factura_add.php");
}
?>
    