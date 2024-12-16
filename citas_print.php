<?php
require_once('tcpdf/tcpdf.php');
require_once('clases/conexion.php');

// Obtener parámetros de filtro
$pac_cod = isset($_GET['vpac_cod']) ? $_GET['vpac_cod'] : 0;
$doc_cod = isset($_GET['vdoc_cod']) ? $_GET['vdoc_cod'] : null;
$esp_cod = isset($_GET['vesp_cod']) ? $_GET['vesp_cod'] : null;

class MYPDF extends TCPDF {
    public function Header() {
        // Agregar contenido al encabezado aquí si es necesario
    }
    public function Footer() {
        // Agregar contenido al pie de página aquí si es necesario
    }
}

// Crear instancia de TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurar información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Doctor o Consultorio');
$pdf->SetTitle('CITAS Y SUS DETALLES');
$pdf->SetSubject('Prototipo de Impresión para Citas');
$pdf->SetKeywords('TCPDF, PDF, citas, informe médico');
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
$pdf->Cell(2, 10, 'Dirección: Ruta n°8 - Simón Bolívar', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(2, 10, 'Teléfono: 0975388433', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(2, 10, 'Correo: medicinafamiliar2018@gmail.com', 0, 1, 'L');
$pdf->SetXY(80, 70); // Ajusta la posición según tu diseño

// Agregar título
$pdf->SetFont('times', 'B', 16);
$pdf->SetXY(30, 70);
$pdf->Cell(0, 20, 'CITAS', 0, 1, 'C');

// Construir la consulta SQL
$sql = "SELECT * FROM v_citasdetalle WHERE pac_cod = $pac_cod";
if ($doc_cod) {
    $sql .= " AND doc_cod = $doc_cod";
}
if ($esp_cod) {
    $sql .= " AND esp_cod = $esp_cod";
}

// Obtener datos de la consulta solo para el paciente y filtros seleccionados
$cabeceras = consultas::get_datos($sql);

// Verificar si existen registros para el paciente
if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        // Datos del Paciente
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(130, 8, "Paciente: (" . $cabecera['pac_cod'] . ") " . strtoupper($cabecera['paciente']), 0, 1, 'L');
        
        // Información de la cita
        $pdf->SetFont('times', '', 11);
        $pdf->Cell(0, 6, "Fecha: " . $cabecera['cita_fecha'], 0, 1, 'L');
        $pdf->Cell(0, 6, "Hora: " . $cabecera['cita_hora'], 0, 1, 'L');
        $pdf->Cell(0, 6, "Razón de la Cita: " . strtoupper($cabecera['razon_cita']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Estado de la Cita: " . strtoupper($cabecera['cita_estado']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Doctor: " . strtoupper($cabecera['doctor']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Especialidad: " . strtoupper($cabecera['esp_descri']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Turno: " . strtoupper($cabecera['tur_descri']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Sala: " . strtoupper($cabecera['sal_descri']), 0, 1, 'L');
        $pdf->Cell(0, 6, "Día: " . strtoupper($cabecera['dia_descri']), 0, 1, 'L');
        
        // Separador para cada consulta
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
        $pdf->Ln(8);
    }
} else {
    // Si no hay registros para el paciente seleccionado
    $pdf->SetFont('times', 'I', 11);
    $pdf->Cell(0, 10, 'No se encontraron registros de citas para este paciente.', 0, 1, 'C');
}

$pdf->Output('reporte_citas.pdf', 'I');
?>
