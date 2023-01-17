<?php
namespace App\Controllers;

use App\Models\Crud_model;
use App\Models\Exporter_model;
use App\Libraries\Pdf\FPDF;
use chillerlan\QRCode\{QROptions, QRCode};
const TEMPIMGLOC = 'tempimg.png';
use App\Models\Notification_model;




class Exporter extends BaseController
{
    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->agent = $this->request->getUserAgent();
        $this->crud = new Crud_model($db);
        $this->expo = new Exporter_model($db);
        $this->pdf = new FPDF();
        $this->notification = new Notification_model($db);

      
        //load helper
        helper(array('custom', 'text'));
    }

    public function generate_identity_card($id = 0, $type = false)
    {
        if (!empty($id)) {
            $id = decrypt($id);
            if ($id && is_numeric($id)) {
                /*START FETCHING STUD DATA*/
                $details = $this->expo->getIdentityCardData($id, $this->session->branchData['id']);
                if (!empty($details)) {
                    $qrData = 'Branch : '.$details->branch_code.', Enroll. No. : '.$details->enrollment_number;
                    $qrCode = $this->generateQrCode($qrData, 1);

                    $qrCode = explode(',',$qrCode,2)[1];
                    $qrCode = 'data://text/plain;base64,'. $qrCode;
                    $studName = $details->student_name;
                    $enrollNo = $details->enrollment_number;
                    $fatherName = $details->father_name;
                    $branchName = $details->branch_name;
                    $branchCode = $details->branch_code;
                    $phone = $details->academy_phone;
                    $course = $details->short_name;
                    $expiryDtae = $details->icard_expired_date;
                    $studImg = base_url('public/upload/branch-files/student/student-image').'/'.$details->student_photo;
                    //$secretary = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];
                    $secretary = site_url().'public/upload/files/branch/signature/'.$details->branch_signature;

                    $path ='upload/branch-files/student/identity-card';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $background = site_url().'public/branch/img/Student-I-Card.jpg';
                    $this->pdf->SetAutoPageBreak(false);
                    $this->pdf->AddPage('L',array(110,158.5));
                    $this->pdf->Image($background, 0, 0);

                    $this->pdf->SetFont('Arial','',11);
                    $dataPieces = explode(',',$qrCode);
                    $encodedImg = $dataPieces[1];
                    $decodedImg = base64_decode($encodedImg);

                    if( $decodedImg!==false )
                    {
                        if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
                        {
                            $this->pdf->Cell(22,21,$this->pdf->Image(TEMPIMGLOC,126.5,83,22,24.5),0,0,'C');
                            unlink(TEMPIMGLOC);
                        }
                    }

                    $this->pdf->SetXY(38,28);
                    $this->pdf->Cell(77,6,$studName,0,0,'L');

                    $this->pdf->SetXY(38,37);
                    $this->pdf->Cell(77,6,$fatherName,0,0,'L');

                    $this->pdf->SetXY(38,44.5); 
                    $this->pdf->Cell(77,6,$enrollNo,0,0,'L');

                    $this->pdf->SetXY(38,52.5); 
                    $this->pdf->Cell(77,6,$course,0,0,'L');

                    $this->pdf->SetXY(38,60); 
                    $this->pdf->Cell(77,6,$branchCode,0,0,'L');

                    $this->pdf->SetXY(38,69); 
                    $this->pdf->Cell(77,6, date('F Y',(int)$expiryDtae) ,0,0,'L');

                    $this->pdf->Image($studImg, 120,28,31,32.5);
                    $this->pdf->Image($secretary, 125,66,30,0);

                    $this->pdf->SetFont('Arial','B',9);
                    $this->pdf->SetTextColor(255,255,255);
                    $this->pdf->SetXY(3,98); 
                    $this->pdf->Cell(120,4,$branchName,0,0,'L');

                    $this->pdf->SetXY(3,102); 
                    $this->pdf->Cell(120,4,$phone,0,0,'L');


                    $this->response->setHeader('Content-Type', 'application/pdf');
                    $rawFileName = encrypt($details->enrollment_number);
                    $fileName = $path.'/'.$rawFileName.'.pdf';
                    $this->pdf->output($fileName, 'F');
                    $dataArr = array(
                        'nycta_icard' => $rawFileName,
                    );
                    if ($this->crud->updateData('admission', array('id' => $details->id), $dataArr)) {
                        if($type){
                            //regenerate notify
                            $notiArr = array(
                                'from_id' => $this->session->branchData['id'],
                                'form_id_type' => 2,
                                'to_id' => 1,
                                'to_id_type' => 1,
                                'type' => 'regenerate_icard',
                                'slug' => 'regenerate-icard',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                            return true;
                        }else{
                            //new generate notify
                            $notiArr = array(
                                'from_id' => $this->session->branchData['id'],
                                'form_id_type' => 2,
                                'to_id' => 1,
                                'to_id_type' => 1,
                                'type' => 'generate_icard',
                                'slug' => 'generate-icard',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                        }


                        $this->session->setFlashData('message', 'Identity card has been successfully generated');
                        $this->session->setFlashData('message_type', 'success');
                        return redirect()->to('/branch/student/manage-admission'); die;
                    }else {
                        $this->session->setFlashData('message', 'Something went wrong!');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('/branch/student/manage-admission'); die;
                    }
                    
                }else {
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/branch/student/manage-admission'); die;
                }
            }else {
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/branch/student/manage-admission'); die;
            }
        }else {
            $this->session->setFlashData('message', 'Something went wrong!');
            $this->session->setFlashData('message_type', 'error');
            return redirect()->to('/branch/student/manage-admission'); die;
        } 
    } 


    function regenerate_identity_card($id = 0)
    {
        if ($this->generate_identity_card($id, true)) {
            $this->session->setFlashData('message', 'Identity card has been successfully regenerated');
            $this->session->setFlashData('message_type', 'success');
            return redirect()->to('/branch/student/manage-admission'); die;
        }
        
    }

    public function generate_invoice($id = 0)
    {

        if (!empty($id)) {
            $id = decrypt($id);
            if ($id && is_numeric($id)) {
                /*START FETCHING INVOICE DATA*/
                $details = $this->expo->getInvoiceData($id, $this->session->branchData['id']);
                $branch_details = $this->expo->getBranchData($this->session->branchData['id']);
                if (!empty($details)) {
                    $pendingAmount = number_format( ($details->course_fees - ($details->amount + $details->discount)),2) ;
                    $path ='upload/branch-files/student/invoice';
                    $background = site_url().'public/branch/img/invoice-format.jpg';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $this->pdf->SetAutoPageBreak(false);
                    $this->pdf->AddFont('Gotham','M','GothamMedium.php');
                    $this->pdf->AddFont('Gotham','L','GothamLight.php');
                    $this->pdf->AddFont('Gotham','B','GothamBold.php');

                    $this->pdf->AddPage('P','A4');
                    $this->pdf->Image($background, -2, 0,213,0);

                    $this->pdf->Ln(6);
                    $this->pdf->SetXY(33,57);
                    $this->pdf->SetFont('Gotham','M',10);
                    $this->pdf->Cell(53,7, $details->invoice_no,0,0,'C');

                    $this->pdf->SetXY(102,57);
                    $this->pdf->Cell(37,7, date('Y/m/d'),0,0,'C');

                    $this->pdf->SetXY(170,57);
                    $this->pdf->Cell(33,7, 'Rs. '.$pendingAmount,0,0,'C');



                    //Bill to
                    $this->pdf->SetFont('Gotham','L',10);
                    $this->pdf->SetXY(7,73);
                    $this->pdf->Cell(80,30,$details->student_name,0,0,'L');

                    $this->pdf->Ln(5);
                    $this->pdf->SetX(7);
                    $this->pdf->Cell(80,30,$details->mobile,0,0,'L');

                    $this->pdf->Ln(5);
                    $this->pdf->SetX(7);
                    $this->pdf->Cell(80,30, $details->residential_address,0,0,'L');

                    $this->pdf->Ln(5);
                    $this->pdf->SetX(7);
                    $this->pdf->Cell(80,30, $details->pin,0,0,'L');


                    //Bill from
                    $this->pdf->SetXY(146,85);
                    if( strlen($branch_details->branch_name) > 24 ){
                        $this->pdf->MultiCell(50,5,$branch_details->branch_name,0);
                    }else{
                        $this->pdf->Cell(50,6,$branch_details->branch_name,0,0,'L');
                        $this->pdf->Ln(5);
                    }
                    $this->pdf->SetX(146);
                    $this->pdf->Cell(50,6,$branch_details->academy_address,0,0,'L');
                    $this->pdf->Ln(5);
                    $this->pdf->SetX(146);
                    $this->pdf->Cell(50,6,$branch_details->academy_phone,0,0,'L');
                    $this->pdf->Ln(5);
                    $this->pdf->SetX(146);
                    $this->pdf->Cell(50,6,$branch_details->branch_email,0,0,'L');


                    $this->pdf->SetXY(7,121);
                    $this->pdf->Cell(20,6, '1.',0,0,'C');

                    $this->pdf->SetXY(45,120);
                    $this->pdf->Cell(90,10, $details->course_name_text,0,0,'C');

                    $this->pdf->SetX(137);
                    $this->pdf->Cell(30,10, 'Rs. '.$details->amount,0,0,'L');


                    $this->pdf->SetXY(175,155.5);
                    $this->pdf->Cell(30,6, 'Rs. '.$details->amount,0,0,'L');

                    $this->pdf->SetXY(175,161);
                    $this->pdf->Cell(30,6, 'Rs. '.$details->amount,0,0,'L');

                    $this->pdf->SetXY(175,166);
                    $this->pdf->Cell(30,6, 'Rs. '.$details->amount,0,0,'L');

                    $this->pdf->SetXY(175,171.5);
                    $this->pdf->Cell(30,6, 'Rs. '.$pendingAmount,0,0,'L');

                    $this->pdf->SetXY(37,240);
                    $this->pdf->Cell(50,6, $branch_details->academy_phone,0,0,'L');


                    $signature = site_url().'public/upload/files/branch/signature/'.$branch_details->signature;
                    $this->pdf->SetXY(100,260);
                    $this->pdf->Image($signature, 160,190,35,0); 

                    $this->response->setHeader('Content-Type', 'application/pdf');
                    $rawFileName = encrypt($details->invoice_no);
                    $fileName = $path.'/'.$rawFileName.'.pdf';
                    $this->pdf->output($fileName, 'F');
                    $dataArr = array(
                        'invoice_file' => $rawFileName,
                    );
 
                    if ($this->crud->updateData('payment', array('id' => $details->id), $dataArr)) {
                        $this->session->setFlashData('message', 'Invoice has been successfully generated');
                        $this->session->setFlashData('message_type', 'success');
                        return redirect()->to('/branch/payment'); die;
                    }else {
                        $this->session->setFlashData('message', 'Something went wrong!');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('/branch/payment'); die;
                    }
                    
                 }else {
                     $this->session->setFlashData('message', 'Something went wrong!');
                     $this->session->setFlashData('message_type', 'error');
                     return redirect()->to('/branch/payment'); die;
                 }
            }else {
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/branch/payment'); die;
            }
        }else {
            $this->session->setFlashData('message', 'Something went wrong!');
            $this->session->setFlashData('message_type', 'error');
            return redirect()->to('/branch/payment'); die;
        } 
    }

    private function generateQrCode($data , $type = 0)
    {
        if ($type) {
            return (new QRCode)->render($data);
        }else{
            return '<img src="' . (new QRCode)->render($data) . '" alt="NYCTA QR Code" />';

        }
    }
}