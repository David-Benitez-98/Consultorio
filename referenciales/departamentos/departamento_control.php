<?php

require '../../clases/conexion.php';

// Verificamos que se hayan recibido los parámetros necesarios
if (isset($_REQUEST['accion']) && isset($_REQUEST['vdepar_cod'])) {
    // Obtén los valores de los parámetros
    $accion = $_REQUEST['accion'];
    $vdepar_cod = $_REQUEST['vdepar_cod'];
    $vdepar_descri = $_REQUEST['vdepar_descri'];
    //$vdepar_estado = $_REQUEST['vdepar_estado'];
    //echo $accion;
    // Definimos la acción para activar la departamento (por ejemplo, asumiendo que es "4" para activar)
    $accion_activar = 0;

    // Preparamos la consulta SQL para activar la departamento
    $sql = "select sp_departamento($accion, $vdepar_cod, '$vdepar_descri') as resul;";
    //echo "aqui";
    // Iniciamos la sesión
    session_start();

    // Ejecutamos la consulta
    $resultado = consultas::get_datos($sql);

    if ($resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = 'Error al activar la departamento.';
    }

    // Cerramos la sesión después de configurar el mensaje
    session_write_close();

    // Redirigimos de nuevo a la página departamento_index.php
    header("location: departamento_index.php");
} else {
    // Si no se proporcionaron todos los parámetros necesarios, mostrar un mensaje de error
    $_SESSION['mensaje'] = 'Faltan parámetros en la solicitud.';
    header("location: departamento_index.php");
}
?>
