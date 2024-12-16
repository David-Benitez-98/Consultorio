<?php

require 'clases/conexion.php';
session_start();

$sql ="select sp_enfermedades(".$_REQUEST['accion'].",
".(!empty($_REQUEST['venfe_cod'])?$_REQUEST['venfe_cod']:"0").", 
'".(!empty($_REQUEST['venfe_descri'])?$_REQUEST['venfe_descri']:"")."',
".(!empty($_REQUEST['vtipoenfe_cod'])?$_REQUEST['vtipoenfe_cod']:"0").") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:diagnosticodetalle_add.php?vdiag_cod=".$_REQUEST['vdiag_cod']);
}else {
    $_SESSION['mensaje'] = "Error: Resultados no encontrados";
    header("location:diagnostico_index.php");
}
?>