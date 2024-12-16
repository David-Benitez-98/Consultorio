<?php
require 'clases/conexion.php';

// Verificar que el código del paciente esté presente y sea válido
$pac_cod = isset($_GET['pac_cod']) ? intval($_GET['pac_cod']) : 0;

if ($pac_cod > 0) {
    // Realizar la consulta para obtener las cuentas a cobrar
    $query = "SELECT * FROM v_cuentas_a_cobrar WHERE pac_cod = $pac_cod AND cta_saldo > 0";
    $result = consultas::get_datos($query);

    // Generar las opciones del select basado en los resultados de la consulta
    if (!empty($result)) {
        foreach ($result as $res) {
            echo '<option value="' . $res['fac_cod'] . '~' . $res['cta_nro_cuota'] . '~' . $res['cta_saldo'] . '~' . $res['fac_total'] . '~' . $res['cta_vencimiento_f'] . '">';
            echo 'Cuenta nro.: <strong>' . $res['cta_nro_cuota'] . '</strong> de la factura nro.: <strong>' . $res['fac_total'] . '</strong> Vence el: ' . $res['cta_vencimiento_f'] . ' Saldo: ' . $res['cta_saldo'];
            echo '</option>';
        }
    } else {
        echo '<option value="0">No hay cuentas pendientes para este cliente.</option>';
    }
} else {
    echo '<option value="0">Cliente no válido.</option>';
}
?>
