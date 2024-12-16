<?php
require 'clases/conexion.php';

$pac_cod = $_GET['pac_cod']; // Asegúrate de que este valor sea correcto y esté presente

// Prepara la consulta para unir con la tabla factura
$sql = "SELECT 
    cac.cta_nro_cuota, 
    cac.fac_cod, 
    cac.cta_monto_pagar, 
    cac.cta_estado 
FROM cuenta_a_cobrar cac
JOIN factura f ON cac.fac_cod = f.fac_cod
WHERE f.pac_cod = :pac_cod AND cac.cta_estado = 'PENDIENTE'";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':pac_cod', $pac_cod, PDO::PARAM_INT);

// Ejecutar la consulta y verificar si hubo algún error
if ($stmt->execute()) {
    $cuentas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($cuentas)) {
        echo '<table class="table table-striped">';
        echo '<tr><th>Factura</th><th>Monto a Pagar</th><th>Estado</th></tr>';
        foreach ($cuentas as $cta) {
            echo "<tr>
                    <td>{$cta['fac_cod']}</td>
                    <td>{$cta['cta_monto_pagar']}</td>
                    <td>{$cta['cta_estado']}</td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo '<div class="alert alert-info">No hay cuentas pendientes para este paciente.</div>';
    }
} else {
    // Mostrar el error de la consulta
    $errorInfo = $stmt->errorInfo();
    echo "Error al cargar los datos: " . $errorInfo[2];
}
?>
