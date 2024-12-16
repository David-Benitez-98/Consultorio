<?php
require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_recetasindicaciones_detalle(
         " . $_REQUEST['accion'] . ",
             " . (!empty($_REQUEST['vre_cod']) ? $_REQUEST['vre_cod'] : "0") . ",  
              " . (!empty($_REQUEST['vmedi_cod']) ? $_REQUEST['vmedi_cod'] : "0") . ",
                 '" . (!empty($_REQUEST['vre_indi']) ? $_REQUEST['vre_indi'] : "0") . "',
                  '" . (!empty($_REQUEST['vre_observ']) ? $_REQUEST['vre_observ'] : "0") . "',
                    '".(!empty($_REQUEST['vhora']) ? $_REQUEST['vhora'] : "00:00:00")."',
                        '" . (!empty($_REQUEST['vdosis']) ? $_REQUEST['vdosis'] : "0") . "',
                            " . (!empty($_REQUEST['vcantidad']) ? $_REQUEST['vcantidad']  : "0") . " ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(re_cod), 0) AS id from v_recetasindicacionesdetalle";
    $resultado = consultas::get_datos($sql);
    header("location:recetasindicacionesdetalle_add.php?vre_cod=".$_REQUEST['vre_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:recetasindicaciones_index.php");
}
?>

