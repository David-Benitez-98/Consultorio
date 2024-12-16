<?php
// Incluir las librerías TCPDF y la clase de conexión (ajusta las rutas según tu estructura)
include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';
$pac_cod = isset($_GET['vpac_cod']) ? $_GET['vpac_cod'] : 0;
class MYPDF extends TCPDF {
    public function Header() {
        // Add header content here if needed
    }
    public function Footer() {
        // Add footer content here if needed
    }
}
// Crear instancia de TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Configurar información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Doctor o Consultorio');
$pdf->SetTitle('ORDEN DE ESTUDIOS DETALLE');
$pdf->SetSubject('Prototipo de Impresión para Orden de Estudios Detalle');
$pdf->SetKeywords('TCPDF, PDF, orden de estudios, informe médico');
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// Configuración de márgenes y saltos de página
$pdf->SetMargins(20, 20, 20);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 15);
// Agregar página y logo del consultorio
$pdf->AddPage('P', 'A4');
$pdf->Image("img/logoconsultorio.png", 15, 15, 60, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
// Campos de Datos del Consultorio
$pdf->SetFont('times', 'B', 12);
$pdf->SetXY(80, 15);
$pdf->Cell(2, 10, 'CONSULTORIO MÉDICO "Medicina Familiar"', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(2, 10, 'Dirección: Ruta n°8 - Simón Bolivar', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(2, 10, 'Teléfono: 0975388433', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(2, 10, 'Correo: medicinafamiliar2018@gmail.com', 0, 1, 'L');
$pdf->SetXY(80, 70); // Ajusta la posición según tu diseño
// Agregar título
$pdf->SetFont('times', 'B', 16);
$pdf->SetXY(30, 70);
$pdf->Cell(0, 20, 'ORDEN DE ESTUDIOS ', 0, 1, 'C');
// Obtener datos de la vista v_ordenestudiosdetalle (ajusta la consulta según tu estructura de base de datos)
$ordenEstudiosDetalle = consultas::get_datos("SELECT * FROM v_ordenestudiosdetalle WHERE pac_cod = $pac_cod");
// Verificar si hay datos
if (!empty($ordenEstudiosDetalle)) {
    foreach ($ordenEstudiosDetalle as $ordenDetalle) {
        // Datos del Paciente
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(130, 8, "Paciente: (" . $ordenDetalle['pac_cod'] . ") " . strtoupper($ordenDetalle['paciente']), 0, 1, 'L');
    // Iterar sobre los datos y agregarlos de manera personalizada
        $pdf->SetFont('times', '', 11);
//        $pdf->MultiCell(0, 10, 'Paciente: ' . $ordenDetalle['paciente'], 0, 'L');
        $pdf->MultiCell(0, 10, 'Fecha: ' . $ordenDetalle['oe_fecha'], 0, 'L');
        $pdf->MultiCell(0, 10, 'Tipo de Estudios: ' . $ordenDetalle['tipooe_descri'], 0, 'L');
        $pdf->MultiCell(0, 10, 'Observación: ' . $ordenDetalle['observacion'], 0, 'L');
        // Agregar espacio entre registros
        // Separador para cada consulta
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
        $pdf->Ln(8);
    }
} else {
    // Mensaje si no hay datos para v_ordenestudiosdetalle
    $pdf->SetFont('times', 'I', 12);
    $pdf->Cell(0, 10, 'No hay datos disponibles ', 0, 1, 'C');
}
// Agregar la firma del doctor (puedes ajustar la posición según tu diseño)
$pdf->Ln(20);
$pdf->Cell(0, 10, '_____________________________', 0, 1, 'C');
$pdf->Cell(0, 10, 'Firma del Doctor', 0, 1, 'C');

// Salida al navegador
$pdf->Output('informe_orden_estudios_detalle.pdf', 'I');
?>
