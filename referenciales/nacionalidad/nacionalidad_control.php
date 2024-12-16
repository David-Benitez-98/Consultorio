<?php

require '../../clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios
if (isset($_REQUEST['accion']) && isset($_REQUEST['vnac_cod'])) {
    // Obtén los valores de los parámetros
    $accion = $_REQUEST['accion'];
    $vnac_cod = $_REQUEST['vnac_cod'];
    $vnac_descri = $_REQUEST['vnac_descri'];
    //$vciu_estado = $_REQUEST['vciu_estado'];
    //echo $accion;
    // Definimos la acción para activar la ciudad (por ejemplo, asumiendo que es "4" para activar)
    $accion_activar = 0;

    // Preparamos la consulta SQL para activar la ciudad
    $sql = "select sp_nacionalidad($accion, $vnac_cod, '$vnac_descri') as resul;";
    //echo "aqui";
    // Iniciamos la sesión
    session_start();

    // Ejecutamos la consulta
    $resultado = consultas::get_datos($sql);

    if ($resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = 'Error al activar nacionalidad.';
    }

    // Cerramos la sesión después de configurar el mensaje
    session_write_close();

    // Redirigimos de nuevo a la página nacionalidad_index.php
    header("location: nacionalidad_index.php");
} else {
    // Si no se proporcionaron todos los parámetros necesarios, mostrar un mensaje de error
    $_SESSION['mensaje'] = 'Faltan parámetros en la solicitud.';
    header("location: nacionalidad_index.php");
}
?>
