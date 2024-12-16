<?php
require 'clases/conexion.php';
session_start();
$sql = "SELECT sp_pre_consulta(
           " . $_REQUEST['accion'] . ",
           ".$_REQUEST['vpcon_cod'].", 
           " . (isset($_REQUEST['vpcon_fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vpcon_fecha'])) . "'" : 'NULL') . ",   
           '" . (!empty($_REQUEST['vpcon_hora']) ? $_REQUEST['vpcon_hora'] : "00:00:00") . "',
           " . (!empty($_REQUEST['vpresion_arterial']) ? $_REQUEST['vpresion_arterial'] : "0") . ",
           " . (!empty($_REQUEST['vtemperatura']) ? $_REQUEST['vtemperatura'] : "0") . ",
           " . (!empty($_REQUEST['vfrecuencia_respiratoria']) ? $_REQUEST['vfrecuencia_respiratoria'] : "0") . ",  
           " . (!empty($_REQUEST['vfrecuencia_cardiaca']) ? $_REQUEST['vfrecuencia_cardiaca'] : "0") . ",
           " . (!empty($_REQUEST['vsaturacion']) ? $_REQUEST['vsaturacion'] : "0") . ",
           " . (!empty($_REQUEST['vpeso']) ? $_REQUEST['vpeso'] : "0") . ",
           " . (!empty($_REQUEST['vtalla']) ? $_REQUEST['vtalla'] : "0") . ", 
           " . (!empty($_REQUEST['vcita_cod']) ? $_REQUEST['vcita_cod'] : "0"). ", 
           " . $_SESSION['usu_cod']. ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    $sql = "select COALESCE(max(pcon_cod), 0) AS vpcon_cod from v_pre_consulta";
    $resultado = consultas::get_datos($sql);
    header("location:preconsulta_index.php?vpcon_cod=" . $resultado[0]['vpcon_cod']);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:preconsulta_index.php?vpcon_cod=" . $_REQUEST['vpcon_cod']);
}
?>

