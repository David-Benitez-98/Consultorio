<?php 
require 'clases/conexion.php'; 
session_start(); 

// Verificar y obtener el parámetro 'id_caja'
$id_caja = isset($_REQUEST['caj_cod']) ? $_REQUEST['caj_cod'] : null;
if (!$id_caja) {
    $_SESSION['mensaje'] = "Error: 'caj_cod' no definido.";
    header("location:aperturaycierre_index.php");
    exit;
}

// Verificar si 'caj_cod' existe en la tabla 'cajas'
$check_caja = consultas::get_datos("SELECT 1 FROM cajas WHERE caj_cod = $id_caja");
if (empty($check_caja)) {
    $_SESSION['mensaje'] = "Error: El valor de 'caj_cod' ($id_caja) no existe en la tabla 'cajas'.";
    header("location:aperturaycierre_index.php");
    exit;
}

// Construir la consulta SQL para llamar a la función 'sp_abrircaja'
$sql = "SELECT sp_abrircaja(
    ".$_REQUEST['accion'].", 
    ".$_REQUEST['vaper_cod'].", 
    ".$_SESSION['usu_cod'].", 
    ".(!empty($_REQUEST['vaper_monto']) ? $_REQUEST['vaper_monto'] : "0").", 
    ".$id_caja.", 
    ".(!empty($_REQUEST['cierre_monto']) ? $_REQUEST['cierre_monto'] : "0").", 
    ".(isset($_REQUEST['p_cierre_tarjeta']) ? $_REQUEST['p_cierre_tarjeta'] : "0").", 
    ".(isset($_REQUEST['p_cierre_cheque']) ? $_REQUEST['p_cierre_cheque'] : "0").", 
    ".(isset($_REQUEST['p_cierre_diferencia']) ? $_REQUEST['p_cierre_diferencia'] : "0")."
) AS resul";

// Ejecutar la consulta y manejar el resultado
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) { 
    $valor = explode("*", $resultado[0]['resul']); 
    $_SESSION['mensaje'] = $valor[0]; 
    header("location:".$valor[1]); 
} else { 
    $_SESSION['mensaje'] = "Error:".$sql; 
    header("location:aperturaycierre_index.php"); 
}
?>
