<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';


class MYPDF extends TCPDF {
    public function Header() {
        // Agregar encabezado si es necesario (puedes colocar aquí el logo y la información del consultorio)
    }

    public function Footer() {
        // Agregar pie de página si es necesario
    }
}

// Crear instancia de TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurar información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Doctor o Consultorio');
$pdf->SetTitle('RECETAS - INDICACIONES');
$pdf->SetSubject('Prototipo de Impresión para Recetas - Indicaciones');
$pdf->SetKeywords('TCPDF, PDF, orden de analisis, informe médico');
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
$pdf->Cell(0, 20, 'RECETAS - INDICACIONES ', 0, 1, 'C');


// Obtener datos de recetas e indicaciones (ajusta la consulta según tu estructura de base de datos)
$recetasIndicaciones = consultas::get_datos("SELECT * FROM v_recetasindicacionesdetalle");

// Verificar si hay datos
if (!empty($recetasIndicaciones)) {
    // Configuración de la tabla de datos
    $pdf->SetFont('times', 'B', 12);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetLineWidth(0.2);

    // Cabecera de la tabla
    $pdf->Cell(15, 10, 'N°', 1, 0, 'C', 1);
    $pdf->Cell(40, 10, 'Paciente', 1, 0, 'C', 1);
    $pdf->Cell(25, 10, 'Fecha', 1, 0, 'C', 1); // Ajuste de ancho
    $pdf->Cell(40, 10, 'Medicamento', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Indicación', 1, 0, 'C', 1); // Ajuste de ancho
    $pdf->Cell(15, 10, 'Dosis', 1, 0, 'C', 1);
    $pdf->Cell(20, 10, 'Cantidad', 1, 1, 'C', 1);

    // Datos de la tabla
    $pdf->SetFont('times', '', 12);
    foreach ($recetasIndicaciones as $index => $datos) {
        $pdf->Cell(15, 10, $index + 1, 1, 0, 'C');
        $pdf->Cell(40, 10, $datos['paciente'], 1, 0, 'L');
        $pdf->Cell(25, 10, $datos['re_fecha'], 1, 0, 'C'); // Ajuste de ancho
        $pdf->Cell(40, 10, $datos['medi_descri'], 1, 0, 'L');
        $pdf->Cell(30, 10, $datos['re_indi'], 1, 0, 'L'); // Ajuste de ancho
        $pdf->Cell(15, 10, $datos['dosis'], 1, 0, 'C');
        $pdf->Cell(20, 10, $datos['det_cantidad'], 1, 1, 'C');
    }
} else {
    // Mensaje si no hay datos
    $pdf->SetFont('times', 'I', 12);
    $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
}

// Agregar la firma del doctor (puedes ajustar la posición según tu diseño)
$pdf->Ln(20);
$pdf->Cell(0, 10, '_____________________________', 0, 1, 'C');
$pdf->Cell(0, 10, 'Firma del Doctor', 0, 1, 'C');

// Salida al navegador
$pdf->Output('informe_recetas/indicaciones_detalle.pdf', 'I');
?>
