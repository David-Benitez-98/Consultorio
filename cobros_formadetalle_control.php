<?php

require 'clases/conexion.php';
session_start();

// Recoger los parámetros enviados por la solicitud
$accion = isset($_REQUEST['accion']) ? $_REQUEST['accion'] : 0;
$vcobro_cod = isset($_REQUEST['vcobro_cod']) ? $_REQUEST['vcobro_cod'] : 0;
$vmonto = isset($_REQUEST['vmonto']) ? $_REQUEST['vmonto'] : 0;
$vnro_tarjeta = isset($_REQUEST['vnro_tarjeta']) ? $_REQUEST['vnro_tarjeta'] : null;
$vcod_aut = isset($_REQUEST['vcod_aut']) ? $_REQUEST['vcod_aut'] : null;
$vban_cod = isset($_REQUEST['vban_cod']) ? $_REQUEST['vban_cod'] : null;
$vmontotarjeta = isset($_REQUEST['vmontotarjeta']) ? $_REQUEST['vmontotarjeta'] : 0;
$vmontocheque = isset($_REQUEST['vmontocheque']) ? $_REQUEST['vmontocheque'] : 0;
$nro_cheque = isset($_REQUEST['vnro_cheque']) ? $_REQUEST['vnro_cheque'] : null;
$vfecha_emision = isset($_REQUEST['vfecha_emision']) ? $_REQUEST['vfecha_emision'] : null;
$vtipoche_cod = isset($_REQUEST['vtipoche_cod']) ? $_REQUEST['vtipoche_cod'] : null;
$vtitular = isset($_REQUEST['vtitular']) ? $_REQUEST['vtitular'] : null;

// Verificamos si el monto de la tarjeta se ha enviado y es mayor que 0
if ($accion == 2 && $vmontotarjeta > 0) {
    $vmonto = $vmontotarjeta;
}
if ($accion == 3 && $vmontocheque > 0) {
    $vmonto = $vmontocheque;
}

// Validaciones iniciales
if ($vmonto <= 0) {
    $_SESSION['mensaje'] = "El monto debe ser mayor a cero.";
    header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
    exit();
}

// Comprobación si el monto es válido y la forma de cobro es correcta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formaCobro = isset($_POST['formaCobro']) ? $_POST['formaCobro'] : '';
    $vmonto = floatval($vmonto);

    // Validación de monto
    if ($vmonto <= 0) {
        $_SESSION['mensaje'] = "El monto debe ser mayor a cero.";
        header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
        exit();
    }

    // Validación de la forma de cobro
    if (!in_array($formaCobro, ['EFECTIVO', 'TARJETA', 'CHEQUE'])) {
        $_SESSION['mensaje'] = "Forma de cobro no válida.";
        header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
        exit();
    }

    // Ejecución de acuerdo a la forma de cobro
    switch ($formaCobro) {
        case 'EFECTIVO':
            // Inserción para pago en efectivo
            $sql = "SELECT sp_cobro_formadetalle($accion, $vcobro_cod, 1, $vmonto, NULL, NULL, NULL, NULL) AS resul";
            $_SESSION['mensaje'] = "Pago en efectivo registrado correctamente. Monto: Gs. $vmonto";
            break;

        case 'TARJETA':
            // Inserción para pago con tarjeta
            if ($vmontotarjeta <= 0) {
                $_SESSION['mensaje'] = "El monto de la tarjeta debe ser mayor a cero.";
                header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
                exit();
            }
            $sql = "SELECT sp_cobro_formadetalle($accion, $vcobro_cod, 2, $vmonto, $vban_cod, '$vnro_tarjeta', '$vcod_aut', $vban_cod) AS resul";
            $_SESSION['mensaje'] = "Pago con tarjeta registrado correctamente. Monto: Gs. $vmonto";
            break;

        case 'CHEQUE':
            // Inserción para pago con cheque
            if ($vmontocheque <= 0) {
                $_SESSION['mensaje'] = "Datos del cheque incompletos o monto inválido.";
                header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
                exit();
            }
            $sql = "SELECT sp_cobro_formadetalle(
                    $accion, 
                    $vcobro_cod, 
                    3, 
                    $vmonto, 
                    $nro_cheque, 
                    '$vfecha_emision', 
                    $vtipoche_cod, 
                    '$vtitular'
                ) AS resul";
            $_SESSION['mensaje'] = "Pago con cheque registrado correctamente. Monto: Gs. $vmonto";
            break;

        default:
            $_SESSION['mensaje'] = "Forma de cobro desconocida.";
            header("Location: cobros_add.php?vcobro_cod=$vcobro_cod");
            exit();
    }

    // Ejecutar la consulta
    try {
        $resultado = consultas::get_datos($sql);

        if ($resultado && isset($resultado[0]['resul'])) {
            if ($resultado[0]['resul'] === 'EXISTE YA') {
                $_SESSION['mensaje'] = "El registro ya existe.";
            }
        } else {
            $_SESSION['mensaje'] = "Error: Resultados no encontrados.";
        }
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al procesar la solicitud: " . $e->getMessage();
    }
}

// Redirigir a la página de cobros
header("Location: cobros_add.php?vcobro_cod=" . urlencode($vcobro_cod));
exit();
?>
