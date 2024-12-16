<?php
require __DIR__ . '/clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'], $_POST['vper_cod'])) {
    // Obtén los valores de los parámetros
    $accion = $_POST['accion'];
    $vper_cod = $_POST['vper_cod'];
    $vper_nombre = $_POST['vper_nombre'];
    $vper_apellido = $_POST['vper_apellido'];
    $vper_ci = $_POST['vper_ci'];
    $vper_fecnac = $_POST['vper_fecnac'];
    $vper_telefono = $_POST['vper_telefono'];
    $vper_email = $_POST['vper_email'];
    $vper_direc = $_POST['vper_direc'];
    $vciu_cod = $_POST['vciu_cod'];
    $vgen_cod = $_POST['vgen_cod'];
    $vnac_cod = $_POST['vnac_cod'];
    $vdepar_cod = $_REQUEST['vdepar_cod'];

    // Validación de Parámetros
$accion = filter_var($_POST['accion'], FILTER_VALIDATE_INT);
$vper_cod = filter_var($_POST['vper_cod'], FILTER_VALIDATE_INT);
// ... Validar y filtrar otros datos

    if ($accion !== false && $vper_cod !== false) {
        try {
            // Preparamos la consulta SQL para llamar a la función sp_persona
            $sql = "SELECT sp_persona($accion, $vper_cod, '$vper_nombre', '$vper_apellido', '$vper_ci', '$vper_fecnac', '$vper_telefono',
                '$vper_email', '$vper_direc', $vciu_cod, $vgen_cod, $vnac_cod, $vdepar_cod, 'ACTIVO') as resul";

            // Iniciamos la sesión
            session_start();

            // Ejecutamos la consulta
            $resultado = consultas::get_datos($sql);

            if (!empty($resultado) && isset($resultado[0]['resul'])) {
                $_SESSION['mensaje'] = $resultado[0]['resul'];
            } else {
                $_SESSION['mensaje'] = 'Error al procesar la acción en la persona.';
            }
        } catch (Exception $e) {
            // Manejo de errores
            $_SESSION['mensaje'] = 'Error en la consulta: ' . $e->getMessage();
        }

        // Cerramos la sesión después de configurar el mensaje
        session_write_close();

        // Redirigimos de nuevo a la página persona_index.php (ajusta el nombre según tu aplicación)
        header("Location: personas_index.php");
        exit();
    } else {
        // Manejar el caso en el que los parámetros no son válidos
        $_SESSION['mensaje'] = 'Parámetros no válidos.';
    }
} else {
    // Si no se proporcionaron todos los parámetros necesarios, mostrar un mensaje de error
    $_SESSION['mensaje'] = 'Parámetros incompletos para la acción en persona.';
    header("Location: personas_index.php"); // Ajusta el nombre según tu aplicación
    exit();
}
?>
