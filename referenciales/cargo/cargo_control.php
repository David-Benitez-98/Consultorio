<?php

require '../../clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios
if (isset($_REQUEST['accion']) && isset($_REQUEST['vcar_cod'])) {
    // Obtén los valores de los parámetros
    $accion = $_REQUEST['accion'];
    $vcar_cod = $_REQUEST['vcar_cod'];
    $vcar_descri = $_REQUEST['vcar_descri'];
    //$vciu_estado = $_REQUEST['vciu_estado'];
    //echo $accion;
    // Definimos la acción para activar la cargo (por ejemplo, asumiendo que es "4" para activar)
    $accion_activar = 0;

    $sql = "select sp_cargo($accion, $vcar_cod, '$vcar_descri') as resul;";
    //echo "aqui";
    // Iniciamos la sesión
    session_start();

    // Ejecutamos la consulta
    $resultado = consultas::get_datos($sql);

    if ($resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = 'Error al activar el cargo.';
    }

    // Cerramos la sesión después de configurar el mensaje
    session_write_close();

    // Redirigimos de nuevo a la página ciudad_index.php
    header("location: cargo_index.php");
} else {
    // Si no se proporcionaron todos los parámetros necesarios, mostrar un mensaje de error
    $_SESSION['mensaje'] = 'Faltan parámetros en la solicitud.';
    header("location: cargo_index.php");
}
?>
