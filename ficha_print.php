<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document // CODIFICACION POR DEFECTO ES UTF-8
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NICOLÁS CABRERA TOLEDO');
$pdf->SetTitle('REPORTE DE PEDIDO DE COMPRA');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setPrintHeader(false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins POR DEFECTO
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(8,10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks SALTO AUTOMATICO Y MARGEN INFERIOR
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------
// TIPO DE LETRA
$pdf->SetFont('times', 'B', 20);

// AGREGAR PAGINA
$pdf->AddPage('P', 'LEGAL');
$pdf->Cell(0, 0, "REPORTE DE PEDIDO DE COMPRA", 0, 1, 'C');
//SALTO DE LINEA
$pdf->Ln();
//COLOR DE TABLA
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);

$pdf->SetFont('', '');
$pdf->SetFillColor(255, 255, 255);
//CONSULTAS DE LOS REGISTROS
if (!empty(isset($_REQUEST['opcion']))) {
    switch ($_REQUEST['opcion']) {
        case 1:
            $cabeceras = consultas::get_datos("select * from vpedido_cabcompra "
                            . "where ped_fecha::date between '" . $_REQUEST['vdesde'] . "' and '" . $_REQUEST['vhasta'] . "'");
            break;
        case 2:
            $cabeceras = consultas::get_datos("select * from vpedido_cabcompra "
                            . "where prv_cod =" . $_REQUEST['vproveedor']);
            break;
        case 3:
            $cabeceras = consultas::get_datos("select * from vpedido_cabcompra "
                            . "where ped_com in(select ped_com from detalle_pedcompra where art_cod=" . $_REQUEST['varticulo'] . ")");
            break;
        case 4:
            $cabeceras = consultas::get_datos("select * from vpedido_cabcompra "
                            . "where emp_cod =" . $_REQUEST['vempleado']);
            break;
    }
} else {
    $cabeceras = consultas::get_datos("select * from v_fichamedica where fich_cod = " . $_REQUEST['vfich_cod']);
}
if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        $pdf->SetFont('', '', 11);
        $pdf->MultiCell(0, 10, 'Paciente: ' . $cabecera['paciente'], 0, 'L');
        $pdf->MultiCell(0, 10, 'CI: ' . $cabecera['per_ci'], 0, 'L');
        $pdf->MultiCell(0, 10, 'Fecha de Nacimiento: ' . $cabecera['per_fecnac'], 0, 'L');
        $pdf->MultiCell(0, 10, 'Género: ' . $cabecera['gen_descri'], 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('', 'B', 11);
        $pdf->SetFillColor(255, 255, 0);
        $detalles = consultas::get_datos("select * from v_fichamedicaimpresion where fich_cod=" . $cabecera['fich_cod']);
        if (!empty($detalles)) {
        foreach ($detalles as $detalle) {    
            $pdf->MultiCell(0, 10, 'Patología:', 0, 'L');
            $pdf->MultiCell(0, 10, 'Código: ' . $detalle['pat_cod'], 0, 'L');
            $pdf->MultiCell(0, 10, 'Descripción: ' . $detalle['pat_descri'], 0, 'L');
            $pdf->Ln();
            $pdf->SetFont('', '', 11);
            $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell(0, 10, 'Alergia:', 0, 'L');
                $pdf->MultiCell(0, 10, 'Código: ' . $detalle['ale_cod'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Descripción: ' . $detalle['ale_descri'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Síntomas: ' . $detalle['ale_sintomas'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Causa: ' . $detalle['ale_causa'], 0, 'L');
                $pdf->Ln();
        }
        } else {
            $pdf->Cell(135, 5, 'La ficha no tiene detalles cargados', 0, '', 'L', 1);
        }
        $pdf->Ln();
        $pdf->Ln();
    }
} else {
    $pdf->Cell(135, 5, 'No se encontraron datos de la ficha', 0, '', 'L', 1);
}


//SALIDA AL NAVEGADOR
$pdf->Output('reporte_pedcompra.pdf', 'I');
?>

