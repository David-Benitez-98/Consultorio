<?php

// Incluir las librerías TCPDF y la clase de conexión (ajusta las rutas según tu estructura)
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
$pdf->SetTitle('FICHA MÉDICA');
$pdf->SetSubject('Prototipo de Impresión para Ficha Médica');
$pdf->SetKeywords('TCPDF, PDF, ficha médica, informe médico');
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
$pdf->Cell(0, 20, 'FICHA MÉDICA', 0, 1, 'C');

// Establecer el tamaño de fuente a 14 puntos
$pdf->SetFont('times', '', 14);

$cabeceras = consultas::get_datos("select * from v_fichamedica where fich_cod = " . $_REQUEST['vfich_cod']);

if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        $pdf->Cell(0, 10, 'DATOS DEL PACIENTE', 1, 1, 'C');
        $pdf->SetFont('times', 'B', 14); // Establecer la fuente en negrita y tamaño 14 para los datos del paciente
        $pdf->Cell(130, 2, "Paciente: " . $cabecera['paciente'] ,0, '', 'L');
        $pdf->Cell(80, 2, "CI: " . $cabecera['per_ci'], 0, 1);
        $pdf->Cell(130, 2, "Fecha de Nacimiento:" . strtoupper($cabecera['per_fecnac']), 0, '', 'L');
        $pdf->Cell(80, 2, "Género: " . $cabecera['gen_descri'], 0, 1);
        $pdf->SetFont('times', '', 14); // Restaurar la fuente a tamaño 14 para los detalles
        $pdf->Ln();

        $pdf->SetFont('', 'B', 11);
        $pdf->SetFillColor(255, 255, 0);
        $detalles = consultas::get_datos("select * from v_fichamedicaimpresion where fich_cod=" . $cabecera['fich_cod']);
        if (!empty($detalles)) {
            foreach ($detalles as $detalle) {
                $pdf->Cell(0, 20, 'DETALLES DE FICHA MÉDICA', 0, 1, 'C');
                $pdf->MultiCell(0, 10, 'Patología: ' . $detalle['pat_descri'], 0, 'L');
                $pdf->SetFont('', '', 11);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell(0, 10, 'Alergia: ' . $detalle['ale_descri'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Síntomas: ' . $detalle['ale_sintomas'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Causa: ' . $detalle['ale_causa'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Antecedentes Enfermedades: ' . $detalle['fich_antecedentes_enfermedades'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Cirugias Anteriores: ' . $detalle['fich_cirugias_anteriores'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Observacion: ' . $detalle['fich_observacion'], 0, 'L');
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
$pdf->Output('reporte_fichamedica.pdf', 'I');
?>
