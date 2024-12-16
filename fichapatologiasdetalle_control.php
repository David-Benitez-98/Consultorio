<?php
require 'clases/conexion.php';
session_start();
$sql = "SELECT sp_detallepatologia(
         " . $_REQUEST['accion'] . ",
        " . (!empty($_REQUEST['cod_ficha']) ? $_REQUEST['cod_ficha'] : "0") . ",  
         " . (!empty($_REQUEST['vpat_cod']) ? $_REQUEST['vpat_cod'] : "0"). " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
        if($resultado[0]['resul'] == "EXISTE PATOLOGIA"){
            $_SESSION['mensaje'] = "LA PATOLOGIA YA EXISTE";
        header("location:fichamedicadetalle_add_1.php?vcod_ficha=" . $_REQUEST['cod_ficha']);
        }else{
            $_SESSION['mensaje'] = "PATOLOGIA AGREGADO CORRECTAMENTE";
        header("location:fichamedicadetalle_add_1.php?vcod_ficha=" . $_REQUEST['cod_ficha']);
        }
        
    } else {
        $_SESSION['mensaje'] = "Error: Resultados no encontrados";
        header("location:fichamedica_add.php");
    }
?>

