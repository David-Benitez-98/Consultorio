<?php
require 'clases/conexion.php';

// Obtener cuentas a cobrar pendientes
$cuentas = consultas::get_datos("SELECT * FROM v_cuentas_a_cobrar where cta_nro_cuota");
foreach ($cuentas as $cuenta) {
    echo '<option value="' . htmlspecialchars($cuenta['fac_cod']) . '">' . 
            'Paciente: ' . htmlspecialchars($cuenta['paciente']) . ' - Cuota: ' . 
            htmlspecialchars($cuenta['cta_nro_cuota']) . ' - Saldo: ' . 
            htmlspecialchars($cuenta['cta_saldo']) . ' Gs' .
         '</option>';
}
?>
