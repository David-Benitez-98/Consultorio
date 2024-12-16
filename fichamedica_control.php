<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_fichamedica(
         " . $_REQUEST['accion'] . ",
         " . $_SESSION['usu_cod'] . ",  
         " . (!empty($_REQUEST['vpac_cod']) ? $_REQUEST['vpac_cod'] : "0") . ""
         . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   
    header("location:fichamedicadetalle_add_1.php?vcod_ficha=".$resultado[0]['resul']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:fichamedica_add.php");
}
?>

