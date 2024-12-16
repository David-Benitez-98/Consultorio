<?php
require_once('tcpdf/tcpdf.php');
require_once('clases/conexion.php');
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
$pdf->SetTitle('CONSULTA Y SUS DETALLES');
$pdf->SetSubject('Prototipo de Impresión para Consulta Médica ');
$pdf->SetKeywords('TCPDF, PDF, consulta médica, informe médico');
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
$pdf->Cell(0, 20, 'CONSULTAS ', 0, 1, 'C');

// Obtener datos de la consulta solo para el paciente seleccionado
$cabeceras = consultas::get_datos("SELECT * FROM v_consultadetalle WHERE pac_cod = $pac_cod");

// Verificar si existen registros para el paciente
if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        // Datos del Paciente
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(130, 8, "Paciente: (" . $cabecera['pac_cod'] . ") " . strtoupper($cabecera['paciente']), 0, 1, 'L');
        
        // Información de la consulta
        $pdf->SetFont('times', '', 11);
        $pdf->Cell(0, 6, "Fecha: " . $cabecera['con_fecha'], 0, 1, 'L');
        $pdf->Cell(0, 6, "Motivo de la Consulta: " . strtoupper($cabecera['con_motivo']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Síntomas: " . $cabecera['sin_descri'], 0, 1, 'L');
        $pdf->Cell(0, 6, "Observaciones: " . $cabecera['observacion'], 0, 1, 'L');
        
        // Separador para cada consulta
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
        $pdf->Ln(8);
    }
} else {
    // Si no hay registros para el paciente seleccionado
    $pdf->SetFont('times', 'I', 11);
    $pdf->Cell(0, 10, 'No se encontraron registros de consultas para este paciente.', 0, 1, 'C');
}

// Salida del archivo
$pdf->Output('reporte_consultas.pdf', 'I');
?>
