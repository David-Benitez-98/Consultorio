<?php
require __DIR__ . '/clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios
if (isset($_REQUEST['accion'], $_REQUEST['vpac_cod'], $_REQUEST['vper_cod'])) {
    // Obtén los valores de los parámetros
    $ban = (int)$_REQUEST['accion'];
    $vpac_cod = (int)$_REQUEST['vpac_cod'];
    $vper_cod = (int)$_REQUEST['vper_cod'];

    // Sanitización de Datos
    $ban = filter_var($ban, FILTER_SANITIZE_NUMBER_INT);
    $vpac_cod = filter_var($vpac_cod, FILTER_SANITIZE_NUMBER_INT);
    $vper_cod = filter_var($vper_cod, FILTER_SANITIZE_NUMBER_INT);

    // Validación de Parámetros
    if ($ban !== false && $vpac_cod !== false && $vper_cod !== false) {
        // Preparamos la consulta SQL para llamar a la función sp_doctor
        $sql = "SELECT sp_pacientes($ban, $vpac_cod, $vper_cod, 'ACTIVO') as resul";

        // Iniciamos la sesión
        session_start();

        try {
            // Ejecutamos la consulta
            $resultado = consultas::get_datos($sql);

            if (!empty($resultado) && isset($resultado[0]['resul'])) {
                $_SESSION['mensaje'] = $resultado[0]['resul'];
            } else {
                $_SESSION['mensaje'] = 'Error al activar el paciente.';
            }
        } catch (Exception $e) {
            // Manejo de errores
            $_SESSION['mensaje'] = 'Error en la consulta: ' . $e->getMessage();
        }

        // Cerramos la sesión después de configurar el mensaje
        session_write_close();

        // Redirigimos de nuevo a la página doctor_index.php
        header("Location: paciente_index.php");
        exit();
    } else {
        // Manejar el caso en el que los parámetros no son válidos
        $_SESSION['mensaje'] = 'Parámetros no válidos.';
    }
} else {
    // Si no se proporcionaron todos los parámetros necesarios, mostrar un mensaje de error
    $_SESSION['mensaje'] = 'Paciente agregado exitosamente';
    header("Location: paciente_index.php");
    exit();
}
?>
