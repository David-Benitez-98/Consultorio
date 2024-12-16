<?php
require 'clases/conexion.php';
session_start();
$sql = "SELECT sp_cobro_tarjeta(
         " . $_REQUEST['accion'] . ",
         " . (!empty($_REQUEST['vtar_cod']) ? $_REQUEST['vtar_cod'] : "0") . ",
         " . (!empty($_REQUEST['vcobro_cod']) ? $_REQUEST['vcobro_cod'] : "0") . ", 
         " . (!empty($_REQUEST['vnro_tarjeta']) ? $_REQUEST['vnro_tarjeta'] : "0") . ",  
         '" . (!empty($_REQUEST['vcod_aut']) ? $_REQUEST['vcod_aut'] : "") . "',
         " . (!empty($_REQUEST['vban_cod']) ? $_REQUEST['vban_cod'] : "0") . ",
         " . (!empty($_REQUEST['vmonto']) ? $_REQUEST['vmonto'] : "0") . "
    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    if($resultado[0]['resul'] == "EXISTE YA"){
        $_SESSION['mensaje'] = "Existe ya";
        header("location:cobros_add.php?vcobro_cod=" . $_REQUEST['vcobro_cod']);
    } else {
        $_SESSION['mensaje'] = "COBRO TARJETA AGREGADO CORRECTAMENTE";
        header("location:cobros_add.php?vcobro_cod=" . $_REQUEST['vcobro_cod']);
    }
} else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:cobros_add.php");
}
?>
