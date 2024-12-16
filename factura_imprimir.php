<?php
// Incluye la librería TCPDF
require_once('tcpdf/tcpdf.php');

// Asegúrate de que la clase Conectar está correctamente definida
require_once('clases/conexion.php');

// Recuperar el cobro_cod desde algún lugar, por ejemplo, GET o POST
$cobro_cod = isset($_GET['cobro_cod']) ? $_GET['cobro_cod'] : null;

if ($cobro_cod === null) {
    die('Código de cobro no especificado.');
}

// Crear una nueva instancia de TCPDF
$pdf = new TCPDF();

// Establecer la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Empresa');
$pdf->SetTitle('Factura de Cobro');
$pdf->SetSubject('Cobro No. ' . $cobro_cod);
$pdf->SetKeywords('TCPDF, PDF, cobro, factura');

// Establecer el tamaño de la página
$pdf->AddPage();

// Conexión a la base de datos
$conexion = new Conectar(); // Asegúrate de usar la clase Conectar
$conn = $conexion->con();  // Usa el método correcto de la clase Conectar

// Consultar la vista 'v_factura' para obtener los datos de la factura con el cobro_cod
$query_factura = "SELECT * FROM v_factura WHERE fac_cod = (SELECT fac_cod FROM v_cobros WHERE cobro_cod = :cobro_cod)";
$stmt_factura = pg_prepare($conn, "query_factura", $query_factura);
$stmt_factura = pg_execute($conn, "query_factura", array(':cobro_cod' => $cobro_cod));
$factura = pg_fetch_assoc($stmt_factura);

if (!$factura) {
    die('Factura no encontrada.');
}

// Consultar la vista 'v_detalle_factura' para obtener los detalles de la factura
$query_detalle = "SELECT * FROM v_detalle_factura WHERE fac_cod = :fac_cod";
$stmt_detalle = pg_prepare($conn, "query_detalle", $query_detalle);
$stmt_detalle = pg_execute($conn, "query_detalle", array(':fac_cod' => $factura['fac_cod']));
$detalles = pg_fetch_all($stmt_detalle);

if (!$detalles) {
    die('Detalles de la factura no encontrados.');
}

// Consultar la vista 'v_cobros' para obtener los cobros asociados al cobro_cod
$query_cobros = "SELECT * FROM v_cobros WHERE cobro_cod = :cobro_cod";
$stmt_cobros = pg_prepare($conn, "query_cobros", $query_cobros);
$stmt_cobros = pg_execute($conn, "query_cobros", array(':cobro_cod' => $cobro_cod));
$cobros = pg_fetch_assoc($stmt_cobros);

if (!$cobros) {
    die('Cobros no encontrados.');
}

// Agregar datos de la factura al PDF
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Factura No. ' . $factura['fac_nro'], 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Fecha de emisión: ' . $factura['fac_fecha'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Paciente: ' . $factura['paciente'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Timbrado: ' . $factura['timbrado'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Apertura: ' . $factura['apertura_fecha'], 0, 1, 'L');

// Agregar detalles de la factura
$pdf->Ln(10); // Salto de línea
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Servicio', 1, 0, 'C');
$pdf->Cell(40, 10, 'Precio', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'IVA', 1, 0, 'C');
$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C');

// Rellenar con los detalles de la factura
$pdf->SetFont('helvetica', '', 12);
foreach ($detalles as $detalle) {
    $pdf->Cell(40, 10, $detalle['Servicio'], 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($detalle['Precio'], 2), 1, 0, 'C');
    $pdf->Cell(30, 10, $detalle['Cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, $detalle['IVA'] . '%', 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($detalle['Subtotal'], 2), 1, 1, 'C');
}

// Agregar información de los cobros
$pdf->Ln(10); // Salto de línea
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Cobro No. ' . $cobro_cod, 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Fecha de cobro: ' . $cobros['cobro_fecha_formateada'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Monto total: $' . number_format($cobros['monto_total'], 2), 0, 1, 'L');

// Salida del PDF
$pdf->Output('cobro_' . $cobro_cod . '.pdf', 'I');
?>
