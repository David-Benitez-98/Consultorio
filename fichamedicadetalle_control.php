<?php
require 'clases/conexion.php';
session_start();
$sql = "SELECT sp_fichamedicadetalle(
         " . $_REQUEST['accion'] . ",
        " . (!empty($_REQUEST['cod_ficha']) ? $_REQUEST['cod_ficha'] : "0") . ",  
             '" . (!empty($_REQUEST['vfich_antecedentes_enfermedades']) ? $_REQUEST['vfich_antecedentes_enfermedades'] : "0") . "',
                  '" . (!empty($_REQUEST['vfich_cirugias_anteriores']) ? $_REQUEST['vfich_cirugias_anteriores'] : "0") . "',
         '" . (!empty($_REQUEST['vfich_observacion']) ? $_REQUEST['vfich_observacion'] : "0"). "' ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
        if($resultado[0]['resul'] == "EXISTE PATOLOGIA"){
            $_SESSION['mensaje'] = "DETALLES DE FICHA AGREGADO";
        header("location:fichamedicadetalle_add_1.php?vcod_ficha=" . $_REQUEST['cod_ficha']);
        }
        
    } else {
        $_SESSION['mensaje'] = "Error: Resultados no encontrados";
        header("location:fichamedica_add.php");
    }
?>