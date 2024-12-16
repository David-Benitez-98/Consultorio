<?php
require 'clases/conexion.php';
session_start();
$sql = "SELECT sp_documentos_varios(
         " . $_REQUEST['accion'] . ",
        " . (!empty($_REQUEST['vdocva_cod']) ? $_REQUEST['vdocva_cod'] : "0") . ",
            '" . (!empty($_REQUEST['vdocva_observacion']) ? $_REQUEST['vdocva_observacion'] : "0") . "', 
        " . (!empty($_REQUEST['cod_ficha']) ? $_REQUEST['cod_ficha'] : "0") . ",  
        " . (!empty($_REQUEST['vtipodo_cod']) ? $_REQUEST['vtipodo_cod'] : "0"). " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
        if($resultado[0]['resul'] == "EXISTE PATOLOGIA"){
            $_SESSION['mensaje'] = "TIPO DE DOCUMENTO YA EXISTE";
        header("location:fichamedicadetalle_add_1.php?vcod_ficha=" . $_REQUEST['cod_ficha']);
        }else{
            $_SESSION['mensaje'] = "DOCUMENTOS VARIOS AGREGADO CORRECTAMENTE";
        header("location:fichamedicadetalle_add_1.php?vcod_ficha=" . $_REQUEST['cod_ficha']);
        }
    } else {
        $_SESSION['mensaje'] = "Error: Resultados no encontrados";
        header("location:fichamedica_add.php");
    }
?>

