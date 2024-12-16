<?php
include_once 'tcpdf.php';
include_once 'clases/conexion.php';
class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NICOLÁS CABRERA TOLEDO');
$pdf->SetTitle('REPORTE DE CITAS MÉDICAS');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setPrintHeader(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

$pdf->SetFont('times', 'B', 14);
$pdf->AddPage('P', 'LEGAL');
$pdf->Cell(0, 0, "REPORTE DE CITAS MÉDICAS", 0, 1, 'C');
$pdf->Ln();

$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);

$pdf->SetFont('', 'B', 12);
$pdf->SetFillColor(255, 0, 0);
$pdf->Cell(50, 5, 'CÓDIGO', 1, 0, 'C', 1);
$pdf->Cell(0, 5, 'DESCRIPCIÓN', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFont('', '');
$pdf->SetFillColor(255, 255, 255);

$citas = consultas::get_datos("SELECT * FROM v_citas WHERE cita_fecha::text ILIKE '%%' ORDER BY cita_cod");

foreach ($citas as $cit) {
    $pdf->Cell(50, 5, $cit['cita_cod'], 1, 0, 'C', 1);
    $pdf->Cell(0, 5, $cit['cita_fecha'], 1, 0, 'C', 1);
    // Agregar más celdas según sea necesario con los datos de la cita
    $pdf->Ln();
}

$pdf->Output('reporte_citas.pdf', 'I');
?>


