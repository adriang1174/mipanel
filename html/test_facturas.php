<?php

$path_efacturas = '../beta-cuenta/inc/efacturas/';

require($path_efacturas.'efactura.class.php');


$factura['razon_social'] = "PROYECTOS AUSTRALES SRL";
$factura['domicilio'] = "SAN MARTIN 1009 PISO 6 DEPTO B\n(1004) CAPITAL FEDERAL\n CAPITAL FEDERAL";
$factura['cuit'] = "30-70783164-9";

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',7.7);

$pdf->Image($path_efacturas.'background-red.jpg', 0, 0, 210);

$pdf->Text(25,50, $factura['razon_social']);
$pdf->SetY(51.2);
$pdf->SetX(24.3);
$pdf->MultiCell(50,4, $factura['domicilio']);
$pdf->Text(110, 35, $factura['cuit']);


$pdf->Output();


?>
