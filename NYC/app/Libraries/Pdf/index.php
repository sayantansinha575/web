<?php
/***************************/
/* Radek HULAN             */
/* http://hulan.info/blog/ */
/***************************/

require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('GreatVibes-Regular','','GreatVibes-Regular.php'); //Font 1

$pdf->SetFont('GreatVibes-Regular','',12);
$pdf->Cell(0,10,"Contact Details",1,1,'C');


$pdf->AddFont('Forum','','Forum.php'); //Font 2
$pdf->SetFont('Forum','',12);
$pdf->Cell(40,10,"has successfully completed JMeter",1,0);
$pdf->Cell(75,10,"Email",1,0);
$pdf->Cell(75,10,"Message",1,0);

$pdf->Ln();

$pdf->AddFont('AbhayaLibre-Regular','','AbhayaLibre-Regular.php'); //Font 2
$pdf->SetFont('AbhayaLibre-Regular','',12);
$pdf->Cell(40,10,"TestoMeter",1,0);
$pdf->Cell(75,10,"Email",1,0);
$pdf->Cell(75,10,"Message",1,0);
$pdf->Ln();

$file = time().'.pdf';
$pdf->output($file,'D');
?>
	