<?php

require 'clases/conexion.php';

$sql = "insert into modulos(mod_cod, mod_nombre)"
        . "values((select coalesce(max(mod_cod),0)+1 from modulos),'".$_REQUEST['vmod_nombre']."')";

session_start();


$sql = "select sp_modulos(".$_REQUEST['accion'].",".$_REQUEST['vmod_cod'].",'".$_REQUEST['vmod_nombre']."') as resul;";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null){
    $_SESSION['mensaje']=$resultado[0]['resul'];
    header("location:modulo_index.php");
}else{
    $_SESSION['mensaje']="Error".$sql;
    header("location:modulo_index.php");
}
?>
