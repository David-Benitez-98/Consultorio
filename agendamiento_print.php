<?php
require_once('tcpdf/tcpdf.php');
require_once('clases/conexion.php');

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
$pdf->SetTitle('AGENDA Y SUS DETALLES');
$pdf->SetSubject('Prototipo de Impresión para Agenda Médica ');
$pdf->SetKeywords('TCPDF, PDF, agenda médica, informe médico');
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
$pdf->Cell(0, 20, 'AGENDA MÉDICA ', 0, 1, 'C');

// Get data from the view v_agenda_detalle
$cabeceras = consultas::get_datos("SELECT * FROM v_agenda_detalle");

// Check if there are records
if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        // Add details to the PDF
        $pdf->SetFont('', '', 11);
        $pdf->Cell(130, 2, "Doctor: (" . $cabecera['doc_cod'] . ") " . strtoupper($cabecera['doctor']), 0, '', 'L');
        $pdf->Cell(80, 2, "Fecha: " . $cabecera['agen_fecha'], 0, 1);
        $pdf->Cell(130, 2, "Especialidad: " . strtoupper($cabecera['esp_descri']), 0, '', 'L');
        $pdf->Cell(80, 2, "Día: " . $cabecera['dia_descri'], 0, 1);
        $pdf->Cell(130, 2, "Turno: " . $cabecera['tur_descri'], 0, '', 'L');
        $pdf->Cell(80, 2, "Sala: " . $cabecera['sal_descri'], 0, 1);
        $pdf->Ln();
    }
} else {
    // If no records found
    $pdf->Cell(135, 5, 'NO SE ENCONTRARON REGISTROS DE LAS AGENDAS', 0, '', 'L', 1);
}

$pdf->Output('reporte_agenda.pdf', 'I');
?>
