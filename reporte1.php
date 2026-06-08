<?php
require "fpdf186/fpdf.php";
require "models/conexion.php";

$SqlSelect = "SELECT * FROM estudiantes";
$respuesta = $conn->query($SqlSelect);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetTitle("Reporte General de Estudiantes");

// Título
$pdf->SetFont('Times','B',16);
$pdf->Cell(0,10,utf8_decode('REPORTE GENERAL DE ESTUDIANTES'),0,1,'C');

$pdf->SetFont('Times','',11);
$pdf->Cell(0,8,'Universidad Tecnica de Ambato',0,1,'C');

$pdf->Ln(3);

// Encabezados
$pdf->SetFillColor(141,14,14);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Times','B',11);

$pdf->Cell(35,10,'Cedula',1,0,'C',true);
$pdf->Cell(35,10,'Nombre',1,0,'C',true);
$pdf->Cell(35,10,'Apellido',1,0,'C',true);
$pdf->Cell(35,10,'Telefono',1,0,'C',true);
$pdf->Cell(50,10,'Direccion',1,1,'C',true);

// Datos
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',10);

$fill = false;

while($fila = $respuesta->fetch_array()){

    $pdf->Cell(35,8,utf8_decode($fila["ced_est"]),1,0,'C');
    $pdf->Cell(35,8,utf8_decode($fila["nom_est"]),1,0,'C');
    $pdf->Cell(35,8,utf8_decode($fila["ape_est"]),1,0,'C');
    $pdf->Cell(35,8,utf8_decode($fila["tel_est"]),1,0,'C');
    $pdf->Cell(50,8,utf8_decode($fila["dir_est"]),1,1,'C');
}

$pdf->Output();
?>