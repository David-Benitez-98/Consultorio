<?php
require_once('tcpdf/tcpdf.php');
require_once('clases/conexion.php');

$pac_cod = isset($_GET['vpac_cod']) ? $_GET['vpac_cod'] : 0;
$servi_cod = isset($_GET['vservi_cod']) ? $_GET['vservi_cod'] : 0;
class MYPDF extends TCPDF {
    public function Header() {
        // Agregar un encabezado personalizado si es necesario
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Crear instancia de TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Consultorio Médico');
$pdf->SetTitle('Factura y Detalles');
$pdf->SetSubject('Informe de Factura para Consulta Médica');
$pdf->SetKeywords('TCPDF, PDF, consulta médica, informe médico');

// Configuración de márgenes
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 15);

// Agregar página
$pdf->AddPage('P', 'A4');
$pdf->Image("img/logoconsultorio.png", 15, 15, 60);

// Información del consultorio
$pdf->SetFont('times', 'B', 12);
$pdf->SetXY(80, 15);
$pdf->Cell(0, 10, 'CONSULTORIO MÉDICO "Medicina Familiar"', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(0, 10, 'Dirección: Ruta n°8 - Simón Bolívar', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(0, 10, 'Teléfono: 0975388433', 0, 1, 'L');
$pdf->SetX(80);
$pdf->Cell(0, 10, 'Correo: medicinafamiliar2018@gmail.com', 0, 1, 'L');
$pdf->Ln(15);

// Título
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 10, 'FACTURAS Y DETALLES', 0, 1, 'C');
$pdf->Ln(10);

// Consultar facturas
$cabeceras = consultas::get_datos("SELECT * FROM v_factura WHERE pac_cod = $pac_cod order by fac_cod desc");

if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        // Información de la factura
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(0, 8, "Factura N°: " . $cabecera['fac_cod'], 0, 1, 'L');
        $pdf->Cell(0, 8, "Paciente: (" . $cabecera['pac_cod'] . ") " . strtoupper($cabecera['paciente']), 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Cell(0, 6, "Fecha: " . $cabecera['fac_fecha'], 0, 1, 'L');
        $pdf->Cell(0, 6, "Condición: " . strtoupper($cabecera['fac_condicion']), 0, 1, 'L');
        $pdf->Ln(5);

        // Línea separadora
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
        $pdf->Ln(8);

        // Consultar detalles de la factura
        $detalles = consultas::get_datos("SELECT * FROM v_detalle_factura WHERE servi_cod = $servi_cod");
        $detalles = consultas::get_datos("SELECT * FROM v_detalle_factura WHERE fac_cod = " . $cabecera['fac_cod']);
        if (!empty($detalles)) {
            // Encabezado de la tabla
            $pdf->SetFont('times', 'B', 11);
            $pdf->Cell(80, 6, 'Descripción', 1, 0, 'L');
            $pdf->Cell(30, 6, 'Cantidad', 1, 0, 'C');
            $pdf->Cell(30, 6, 'Precio Unit.', 1, 0, 'C');
            $pdf->Cell(30, 6, 'Subtotal', 1, 1, 'C');

            // Detalles
            $pdf->SetFont('times', '', 11);
            foreach ($detalles as $detalle) {
                $pdf->Cell(80, 6, $detalle['Servicio'], 1, 0, 'L');
                $pdf->Cell(30, 6, $detalle['Cantidad'], 1, 0, 'C');
                $pdf->Cell(30, 6, number_format($detalle['Precio'], 2, ',', '.'), 1, 0, 'C');
                $pdf->Cell(30, 6, number_format($detalle['Subtotal'], 2, ',', '.'), 1, 1, 'C');
            }

            // Total de la factura
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(110, 6, '', 0, 0);
            $pdf->Cell(30, 6, 'Total:', 1, 0, 'C');
            $pdf->Cell(30, 6, number_format($cabecera['total'], 2, ',', '.'), 1, 1, 'C');
            $pdf->Ln(5);
        } else {
            // Si no hay detalles
            $pdf->SetFont('times', 'I', 11);
            $pdf->Cell(0, 10, 'No se encontraron detalles para esta factura.', 0, 1, 'C');
        }
    }
} else {
    // Si no hay facturas
    $pdf->SetFont('times', 'I', 11);
    $pdf->Cell(0, 10, 'No se encontraron registros de factura para este paciente.', 0, 1, 'C');
}

// Generar el PDF
$pdf->Output('reporte_facturas.pdf', 'I');
?>
