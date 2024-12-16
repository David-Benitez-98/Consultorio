<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_recetasindicaciones(
         " . $_REQUEST['accion'] . ",
         " . $_REQUEST['vre_cod'] . ",
         " . $_SESSION['usu_cod'] . ",  
         " . (!empty($_REQUEST['pac_cod']) ? $_REQUEST['pac_cod'] : "0") . ",
         " . (!empty($_REQUEST['vdiag_cod']) ? $_REQUEST['vdiag_cod'] : "0") . ",
         " . (!empty($_REQUEST['vcod_consulta']) ? $_REQUEST['vcod_consulta'] : "0")
         . " ) as resul";

$resultado = consultas::get_datos($sql);

    if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(re_cod), 0) AS id from v_recetasindicaciones";
    $resultado = consultas::get_datos($sql);
    header("location:recetasindicacionesdetalle_add.php?vre_cod=" . $resultado[0]['id']);
} else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:recetasindicaciones_index.php");
}
?>

