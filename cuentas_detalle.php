<?php
require 'clases/conexion.php';

$fac_cod = isset($_GET['fac_cod']) ? intval($_GET['fac_cod']) : 0;

if ($fac_cod > 0) {
    // Filtrar por `fac_cod` para obtener las cuotas asociadas
    $cuentas = consultas::get_datos("SELECT * FROM v_cuentas_a_cobrar where fac_cod = " . $fac_cod);
    
    if (!empty($cuentas)) {
        foreach ($cuentas as $cuenta) {
            echo '
                <tr>
                    <td>' . htmlspecialchars($cuenta['cta_nro_cuota']) . '</td>
                    <td>' . htmlspecialchars($cuenta['cta_vencimiento_f']) . '</td>
                    <td>' . htmlspecialchars($cuenta['cta_saldo']) . ' Gs</td>
                </tr>
            ';
        }
    }
}
?>
