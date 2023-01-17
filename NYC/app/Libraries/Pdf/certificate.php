<?php
/***************************/
/* Radek HULAN             */
/* http://hulan.info/blog/ */
/***************************/

require('fpdf.php');

$pdf = new FPDF('P','mm',array(215,210));
$pdf->AddPage();

$pdf->SetTextColor(81,81,81);
$pdf->AddFont('Poppins-Regular','','Poppins-Regular.php'); //Font 2
$pdf->SetFont('Poppins-Regular','',35);
$pdf->Cell(120,20,"CERTIFICATE",0,0,'R');
$pdf->Cell(70,20,$pdf->Image('images/logo-citificate.jpg',150,15,35,35),0,0,'R');
$pdf->Ln();
$pdf->SetFont('Poppins-Regular','',18);
$pdf->Cell(170,5,"OF COMPLETION",0,0,'C');
$pdf->Cell(70,0,"",0,0,'R');
$pdf->Ln();

$pdf->AddFont('GreatVibes-Regular','','GreatVibes-Regular.php'); //Font 1
$pdf->SetFont('GreatVibes-Regular','',35);
$pdf->SetTextColor(2,175,233);
$pdf->Cell(165,50,"Suraj Dalavi",0,0,'C');
$pdf->Ln();
$pdf->SetTextColor(81,81,81);
//$pdf->AddFont('Poppins-Regular','','Poppins-Regular.php'); //Font 2
$pdf->SetFont('Poppins-Regular','',16);
$pdf->Cell(165,20,"Is certified by TestoMeter! as",0,0,'C');
$pdf->Ln();
$pdf->SetFontSize(20);
$pdf->Cell(180,10,"Automation Tester using Selenium",0,0,'C');
$pdf->Ln();
$pdf->SetFontSize(16);
$pdf->Cell(100,20,"with Grade A",0,0,'R');
$pdf->Cell(70,40,$pdf->Image('images/certified-logo.png',130,112,30,30),0,0,'C');
$pdf->Ln();

$pdf->SetFontSize(12);
$pdf->Cell(50,30,"Certificate ID : T9E37XCU",0,0,'R');
$pdf->Cell(70,30,"Date : Nov 24, 2021 / Nov 30, 2021",0,0,'R');
$pdf->Cell(70,30,"Director : ".$pdf->Image('images/sign.jpg',157,157,40,0),0,0,'L');
$pdf->Ln();
$pdf->SetFont('Poppins-Regular','',10.5);

$pdf->Cell(67,10,"The Certificate ID can be verified at",0,0,'L');
$pdf->SetTextColor(2,175,233);
$pdf->Write(10,'www.testometer.co.in','https://testometer.co.in/verify');
$pdf->SetTextColor(81,81,81);
$pdf->Cell(70,10," to check the authenticity of this certificate",0,0,'L');
$pdf->Ln();

$file = time().'.pdf';
$pdf->output($file,'D');
?>
