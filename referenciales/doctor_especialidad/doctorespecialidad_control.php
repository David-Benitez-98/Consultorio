<?php
require '../../clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios
if (
    isset($_REQUEST['accion']) &&
    isset($_REQUEST['vdoc_cod']) &&
    isset($_REQUEST['vesp_cod']) &&
    isset($_REQUEST['vnro_registro']) &&
    isset($_REQUEST['vdoc_estado'])
) {
    // Obtén los valores de los parámetros
    $accion = $_REQUEST['accion'];
    $vdoc_cod = $_REQUEST['vdoc_cod'];
    $vesp_cod = $_REQUEST['vesp_cod'];
    $vnro_registro = $_REQUEST['vnro_registro'];
    $vdoc_estado = $_REQUEST['vdoc_estado'];

    // Define la acción correcta para la función almacenada
    // 1 para Insertar, 2 para Modificar, 3 para Desactivar, 4 para Activar
    $accion_correcta = $accion;

    // Preparamos la consulta SQL para ejecutar la función almacenada
    $sql = "SELECT sp_doctor_especialidad(
        $accion_correcta, $vdoc_cod, $vesp_cod, $vnro_registro, '$vdoc_estado'
    ) as resul;";

    // Iniciamos la sesión
    session_start();

    // Ejecutamos la consulta
    $resultado = consultas::get_datos($sql);

    if ($resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = 'Error al ejecutar la operación en la tabla doctor_especialidad.';
    }

    // Cerramos la sesión después de configurar el mensaje
    session_write_close();

    // Redirigimos de nuevo a la página doctor_especialidad_index.php (ajusta la ruta según tu estructura de carpetas)
    header("location: doctorespecialidad_index.php");
} else {
    // Si faltan parámetros en la solicitud, muestra un mensaje de error
    $_SESSION['mensaje'] = 'Faltan parámetros en la solicitud.';
    header("location: doctorespecialidad_index.php");
}
?>
