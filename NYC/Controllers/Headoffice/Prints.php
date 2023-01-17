<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Exporter_model;
use App\Models\Datatable_model;
use App\Models\Headoffice\Prints_model;
use App\Libraries\Pdf\FPDF;
use chillerlan\QRCode\{QROptions, QRCode};
const TEMPIMGLOC = 'tempimg.png';
class Prints extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);
        $this->expo = new Exporter_model($db);
        $this->mprint = new Prints_model($db);
        $this->dt = new Datatable_model($db);

        $this->pdf = new FPDF();
		//load helper
		helper(['custom', 'text']);
	}

	public function index() 
	{
		if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Print Portable Document Format';
            $generatedMarksheetIds = $this->mprint->getgeneratedMarksheetIds();
            $generatedCertificateIds = $this->mprint->generatedCertificateIds();

            $msheetHtml = "<option value=''></option>";
            $certtHtml = "<option value=''></option>";
            $marksheets = $this->crud->select('marksheets', 'id, enrollment_number, marksheet_no', ['status' => 4, 'marksheet_file<>' => NULL], '', '', '', 'id', $generatedMarksheetIds);

            if (!empty($marksheets)) {
            	foreach ($marksheets as $msheet) {
            		$msheetHtml .= "<option value='$msheet->id'>$msheet->marksheet_no</option>";
            	}
            }
            $certificates = $this->crud->select('certificates', 'id, enrollment_number, certificate_no', ['status' => 4, 'certificate_file<>' => NULL], '', '', '', 'id', $generatedCertificateIds);
            if (!empty($certificates)) {
            	foreach ($certificates as $cert) {
            		$certtHtml .= "<option value='$cert->id'>$cert->certificate_no</option>";
            	}
            }
            $this->data['marksheets'] = $msheetHtml;
            $this->data['certificates'] = $certtHtml;
            $this->data['marksheetsCount'] = (empty($marksheets)?0:count($marksheets));
            $this->data['certificatesCount'] = (empty($certificates)?0:count($certificates));
            return view('headoffice/print/print-pdf', $this->data);
        }
	}

	public function generate()
	{
		if (($this->request->getMethod() == "post") && $this->request->isAjax()) { 
			$generateType = $this->validation();
			$this->data['success'] = false;
			$this->data['hash'] = csrf_hash();

			$msheetSwitch = $this->request->getPost('msheetSwitch');
			$certSwitch = $this->request->getPost('certSwitch');
			$marksheet = $this->request->getPost('marksheet');
			$certificate = $this->request->getPost('certificate');

			if (!is_array($marksheet) && !empty($marksheet)) {
				$marksheet = [$marksheet];
			}
			if (!is_array($certificate) && !empty($certificate)) {
				$certificate = [$certificate];
			}

			$dataArr = array(
				'is_marksheet' => $msheetSwitch,
				'is_certificate' => $certSwitch,
				'marksheet_id' => (empty($marksheet)?'':serialize($marksheet)),
				'certificate_id' => (empty($certificate)?'':serialize($certificate)),
				'created_at' => strtotime('now'),
			);

			if ($generateType == 'both') {
                $marksheetData = $this->expo->getMarksheetData($marksheet[0]);
				$certificateData = $this->expo->getCertificateData($certificate[0]);
				$dataArr['first_enrollment_number'] = $marksheetData->enrollment_number;
				$dataArr['second_enrollment_number'] = $certificateData->enrollment_number;
				$this->gdata['generateType'] = $generateType;
				$this->gdata['marksheet'] = $marksheetData;
				$this->gdata['certificate'] = $certificateData;
                $dataArr['combined_pdf'] = $fileName = $this->generate_masksheet_and_certificate_pdf($this->gdata);
			} elseif ($generateType == 'marksheet') {

                $marksheetData = $this->expo->getMarksheetData($marksheet[0]);
                $marksheetData2 = $this->expo->getMarksheetData($marksheet[1]);
             
                $dataArr['first_enrollment_number'] = $marksheetData->enrollment_number;
                $dataArr['second_enrollment_number'] = $marksheetData2->enrollment_number;
				$this->gdata['generateType'] = $generateType;
				$this->gdata['marksheet'] = $marksheetData;
				$this->gdata['marksheet2'] = $marksheetData2;
                $dataArr['combined_pdf'] = $fileName = $this->generate_two_marksheet_pdf($this->gdata);
			} elseif ($generateType == 'certificate') {
				$certificateData = $this->expo->getCertificateData($certificate[0]);
				$certificateData2 = $this->expo->getCertificateData($certificate[1]);
				$dataArr['first_enrollment_number'] = $certificateData->enrollment_number;;
				$dataArr['second_enrollment_number'] = $certificateData->enrollment_number;;
				$this->gdata['generateType'] = $generateType;
				$this->gdata['certificate'] = $certificateData;
				$this->gdata['certificate2'] = $certificateData2;
                $dataArr['combined_pdf'] = $fileName = $this->generate_two_certificate_pdf($this->gdata);
			}
			
			
			if ($this->crud->add('combined_pdf', $dataArr)) {
				$this->data['success'] = true;
				$this->data['message'] = 'Combined PDF has been successfully generated';
				echo json_encode($this->data); die;
			}
		}
	}

	private function validation()
	{
		$this->data['hash'] = csrf_hash();
		$msheetSwitch = $this->request->getPost('msheetSwitch');
		$certSwitch = $this->request->getPost('certSwitch');
		$marksheet = $this->request->getPost('marksheet');
		$certificate = $this->request->getPost('certificate');
		$generateType = '';
		if ($msheetSwitch && $certSwitch) {
			if (strlen($marksheet) == 0) {
				$this->data['message'] = 'Select a marksheet';
				error($this->data);
			}
			if (strlen($certificate) == 0) {
				$this->data['message'] = 'Select a certificate';
				error($this->data);
			}
			$generateType = 'both';
		} elseif ($msheetSwitch && !$certSwitch) {
			if (empty($marksheet) || count($marksheet) != 2) {
				$this->data['message'] = 'Select two marksheet to proceed further.';
				error($this->data);
			}
			$generateType = 'marksheet';
		} elseif (!$msheetSwitch && $certSwitch) {
			if (empty($certificate) || count($certificate) != 2) {
				$this->data['message'] = 'Select two certificate to proceed further.';
				error($this->data);
			}
			$generateType = 'certificate';
		}
		return $generateType;
	}
    private function generate_two_marksheet_pdf($data)
    {
	
    	
        $marksheet_data = (array)$data['marksheet'];
        $session = date('M Y',(int)$marksheet_data['from_session']).' - '.date('M Y',(int)$marksheet_data['to_session']) ;
        $subject_array = $total_marks_array = $mark_obtain_array = $grade_array = array();
        $subject_array = unserialize($marksheet_data['subjects']);
        $total_marks_array = unserialize($marksheet_data['marks']);
        $mark_obtain_array = unserialize($marksheet_data['marks_obtained']);
        $grade_array = unserialize($marksheet_data['grade']);
        $labels_array = ((empty($marksheet_data['labels']))?'':unserialize($marksheet_data['labels']));


        $path ='upload/files/combined-pdf';
        $background = site_url().'public/print-template/Two-Marksheet-template.jpg';
        $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$marksheet_data['student_photo'];
        $examination_controller_signature = site_url().'public/upload/settings/'. config('SiteConfig')->media['SIGN_EXAM_CONTROLLER'];
        $branch_head_signature = site_url().'public/upload/files/branch/signature/'.$marksheet_data['signature'];

        $this->pdf = new FPDF('P','mm',array(420,280));  

        //******************Marksheet 1 Section start********************//

        $this->pdf->SetAutoPageBreak(false);
        $this->pdf->AddPage('Legal');
        $this->pdf->Image($background, 0, -3.0, 420, 280);
        $this->pdf->Image($student_photo, 173.5,56.5,24,0);

        $this->pdf->Image($examination_controller_signature, 45,215,18,0);
        $this->pdf->Image($branch_head_signature, 134,214,18,0);
        
        //QR CODE
        $qrData = 'Enroll. No. : '.$marksheet_data['enrollment_number'].' Name: '.$marksheet_data['candidate_name'].'. Guardian: '.$marksheet_data['father_name'];
        $qrCode = $this->generateQrCode($qrData, 1);

        $qrCode = explode(',',$qrCode,2)[1];
        $qrCode = 'data://text/plain;base64,'. $qrCode;
        $dataPieces = explode(',',$qrCode);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);

        if( $decodedImg!==false )
        {
            if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
            {
                $this->pdf->Image(TEMPIMGLOC, 21,55.5,24,0);  
                unlink(TEMPIMGLOC);
            }
        }
        //END

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetFont('Arial','B',6.5);
        $this->pdf->SetXY(155,13);
        $this->pdf->Cell(45,4.5,$marksheet_data['marksheet_no'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(155,18);
        $this->pdf->Cell(45,4.5,$marksheet_data['academy_code'],0,0,'L');
        $this->pdf->Ln(11.5);


        $this->pdf->SetTextColor(16,38,148);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->SetX(45);
        $this->pdf->Cell(62,109,$marksheet_data['candidate_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,109,$marksheet_data['enrollment_number'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(43);
        $this->pdf->Cell(62,103,$marksheet_data['father_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,103,$marksheet_data['short_name'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(38);
        $this->pdf->Cell(63,97,$marksheet_data['atp_name'],0,0,'L');
        $this->pdf->SetX(132);
        $this->pdf->Cell(62,97,$session,0,0,'L');
        $this->pdf->Ln(3);

        $i = 1;
        $this->pdf->SetY(118);
        if (!empty($subject_array['subject'])) {
            foreach ($subject_array['subject'] as $key => $subs) {
                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(24);
                $this->pdf->Cell(89,6,($i++).') '.$subs ,0,0,'L');
                $this->pdf->SetX(130);
                $this->pdf->Cell(20,6,$total_marks_array['marks'][$key],0,0,'C');
                $this->pdf->SetX(153);
                $this->pdf->Cell(25,6,$mark_obtain_array['marks_obtained'][$key],0,0,'C');
                $this->pdf->SetX(179);
                $this->pdf->Cell(12,6,$grade_array['grade'][$key],0,0,'C');
                $this->pdf->Ln(7);
            }
        }
		
        if (!empty($labels_array)) {
            
            foreach ($labels_array as $key => $labs) {$i=1;
                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(24);
                $this->pdf->Cell(89,6,$labs,0,0,'L');
                $this->pdf->Ln(5);  
                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetX(24);
                    $this->pdf->MultiCell(100,4, ($i++).') '.$val,0,'L',false); 
                    $this->pdf->Ln(2);  
                }
                //Multiple line marks
                $this->pdf->SetY(123);
                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetX(130);
                    $this->pdf->Cell(20,6,$total_marks_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(152);
                    $this->pdf->Cell(25,6,$mark_obtain_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(180);
                    $this->pdf->Cell(12,6,$grade_array[$key][$key1],0,0,'C');
                    $this->pdf->Ln(10);  
                }
                $this->pdf->Ln(2);  
            }
        }

        $this->pdf->SetXY(133,188);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks'],0,0,'L');
        $this->pdf->SetX(152);

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(25,6,$marksheet_data['total_marks_obtained'],0,0,'C');


        $this->pdf->SetX(178.6);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(12,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetXY(53,200.3);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(25,6,$marksheet_data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(94);
        $this->pdf->Cell(30,6,$marksheet_data['overall_percentage'].'%',0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(135.5);
        $this->pdf->Cell(14,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(180);
        $this->pdf->Cell(30,6,$marksheet_data['typing_speed'],0,0,'L');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetXY(85,216); 
        $this->pdf->Cell(30,10, date('d-m-Y',(int)$marksheet_data['issued_date']),0,0,'C'); 

        //******************Marksheet 1 Section end********************//

        //******************Marksheet 2 Section start********************//
        $marksheet_data = array();
        $marksheet_data = (array)$data['marksheet2'];
        
        $session = date('M Y',(int)$marksheet_data['from_session']).' - '.date('M Y',(int)$marksheet_data['to_session']) ;
        $subject_array = $total_marks_array = $mark_obtain_array = $grade_array = array();
        $subject_array = unserialize($marksheet_data['subjects']);
        $total_marks_array = unserialize($marksheet_data['marks']);
        $mark_obtain_array = unserialize($marksheet_data['marks_obtained']);
        $grade_array = unserialize($marksheet_data['grade']);
        $labels_array = ((empty($marksheet_data['labels']))?'':unserialize($marksheet_data['labels']));


      

        $this->pdf->Image($examination_controller_signature, 248,215,18,0);
        $this->pdf->Image($branch_head_signature, 340,214,18,0);
        $this->pdf->Image($student_photo, 377,56.5,24,0);
        //QR CODE
        $qrData = 'Enroll. No. : '.$marksheet_data['enrollment_number'].' Name: '.$marksheet_data['candidate_name'].'. Guardian: '.$marksheet_data['father_name'];
        $qrCode = $this->generateQrCode($qrData, 1);

        $qrCode = explode(',',$qrCode,2)[1];
        $qrCode = 'data://text/plain;base64,'. $qrCode;
        $dataPieces = explode(',',$qrCode);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);

        if( $decodedImg!==false )
        {
            if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
            {
                $this->pdf->Image(TEMPIMGLOC, 222,55.5,24,0);  
                unlink(TEMPIMGLOC);
            }
        }
        //END

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetFont('Arial','B',6.5);
        $this->pdf->SetXY(364,13);
        $this->pdf->Cell(40,4.5,$marksheet_data['marksheet_no'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(364,18);
        $this->pdf->Cell(40,4.5,$marksheet_data['academy_code'],0,0,'L');
        $this->pdf->Ln(11.5);


        $this->pdf->SetTextColor(16,38,148);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->SetXY(250,81);
        $this->pdf->Cell(60,6,$marksheet_data['candidate_name'],0,0,'L');
        $this->pdf->SetXY(338,81);
        $this->pdf->Cell(40,6,$marksheet_data['enrollment_number'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(250,88);
        $this->pdf->Cell(62,6,$marksheet_data['father_name'],0,0,'L');
        $this->pdf->SetXY(338,88);
        $this->pdf->Cell(40,6,$marksheet_data['short_name'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(243,95);
        $this->pdf->Cell(65,6,$marksheet_data['atp_name'],0,0,'L');
        $this->pdf->SetXY(335,95);
        $this->pdf->Cell(40,6,$session,0,0,'L');
        $this->pdf->Ln(3);

        $i = 1;
         $this->pdf->SetY(118);
        if (!empty($subject_array['subject'])) {
            foreach ($subject_array['subject'] as $key => $subs) {
                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(228);
                $this->pdf->Cell(89,6,($i++).') '.$subs ,0,0,'L');
                $this->pdf->SetX(340);
                $this->pdf->Cell(15,6,$total_marks_array['marks'][$key],0,0,'L');
                $this->pdf->SetX(357);
                $this->pdf->Cell(25,6,$mark_obtain_array['marks_obtained'][$key],0,0,'C');
                $this->pdf->SetX(382);
                $this->pdf->Cell(12,6,$grade_array['grade'][$key],0,0,'C');
                $this->pdf->Ln(7);
            }
        }
    
        if (!empty($labels_array)) {
            
            foreach ($labels_array as $key => $labs) {$i=1;

                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(228);
                $this->pdf->Cell(89,6,$labs,0,0,'L');
                $this->pdf->Ln(5);  

                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetTextColor(0,0,0);
                    $this->pdf->SetFont('Arial','',9);
                    $this->pdf->SetX(228);
					$this->pdf->MultiCell(89,4, ($i++).') '.$val,0,'L',false); 
                    $this->pdf->Ln(3);  
                }
                $this->pdf->SetY(123);
                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetX(334);
                    $this->pdf->Cell(25,6,$total_marks_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(355);
                    $this->pdf->Cell(25,6,$mark_obtain_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(383);
                    $this->pdf->Cell(12,6,$grade_array[$key][$key1],0,0,'C');
                    $this->pdf->Ln(10);  
                }
                $this->pdf->Ln(2);  
            }
        }

        $this->pdf->SetXY(340,188);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks'],0,0,'L');
        $this->pdf->SetX(155);

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetXY(365,188);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetX(383);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(12,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetXY(260,200.3);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(300);
        $this->pdf->Cell(30,6,$marksheet_data['overall_percentage'].'%',0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(340);
        $this->pdf->Cell(14,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(387);
        $this->pdf->Cell(30,6,$marksheet_data['typing_speed'],0,0,'L');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetXY(287,216); 
        $this->pdf->Cell(30,10, date('d-m-Y',(int)$marksheet_data['issued_date']),0,0,'C');


        //******************Marksheet 2 Section end********************//


        $this->response->setHeader('Content-Type', 'application/pdf');
        $fileName = $marksheet_data['enrollment_number'].'.pdf';
        $this->pdf->output($path.'/'.$fileName, 'F');
        return $fileName;
    }
	private function generate_masksheet_and_certificate_pdf($data)
	{
      	$marksheet_data = (array)$data['marksheet'];
        $session = date('M Y',(int)$marksheet_data['from_session']).' - '.date('M Y',(int)$marksheet_data['to_session']) ;


        $subject_array = $total_marks_array = $mark_obtain_array = $grade_array = array();
        $subject_array = unserialize($marksheet_data['subjects']);
        $total_marks_array = unserialize($marksheet_data['marks']);
        $mark_obtain_array = unserialize($marksheet_data['marks_obtained']);
        $grade_array = unserialize($marksheet_data['grade']);
        $labels_array = ((empty($marksheet_data['labels']))?'':unserialize($marksheet_data['labels']));


        $path ='upload/files/combined-pdf';
        $background = site_url().'public/print-template/Marksheet-certificate-template.jpg';
        $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$marksheet_data['student_photo'];
        $examination_controller_signature = site_url().'public/upload/settings/'. config('SiteConfig')->media['SIGN_EXAM_CONTROLLER']; ;
        $branch_head_signature = site_url().'public/upload/files/branch/signature/'.$marksheet_data['signature'];

        $this->pdf = new FPDF('P','mm',array(420,280));  

        //******************Marksheet Section start********************//
        $this->pdf->SetAutoPageBreak(false);
        $this->pdf->AddPage('Legal');
        $this->pdf->Image($background, 0, -3.0, 420, 280);
        $this->pdf->Image($student_photo, 173.5,56.5,24,0);

        $this->pdf->Image($examination_controller_signature, 45,215,18,0);
        $this->pdf->Image($branch_head_signature, 134,214,18,0);
        
        //QR CODE
        $qrData = 'Enroll. No. : '.$marksheet_data['enrollment_number'].' Name: '.$marksheet_data['candidate_name'].'. Guardian: '.$marksheet_data['father_name'];
        $qrCode = $this->generateQrCode($qrData, 1);

        $qrCode = explode(',',$qrCode,2)[1];
        $qrCode = 'data://text/plain;base64,'. $qrCode;
        $dataPieces = explode(',',$qrCode);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);

        if( $decodedImg!==false )
        {
            if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
            {
                $this->pdf->Image(TEMPIMGLOC, 17,55.5,24,0);  
                unlink(TEMPIMGLOC);
            }
        }
        //END

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetFont('Arial','B',6.5);
        $this->pdf->SetXY(155,13);
        $this->pdf->Cell(45,4.5,$marksheet_data['marksheet_no'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(155,18);
        $this->pdf->Cell(45,4.5,$marksheet_data['academy_code'],0,0,'L');
        $this->pdf->Ln(11.5);


        $this->pdf->SetTextColor(16,38,148);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->SetX(45);
        $this->pdf->Cell(62,109,$marksheet_data['candidate_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,109,$marksheet_data['enrollment_number'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(43);
        $this->pdf->Cell(62,103,$marksheet_data['father_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,103,$marksheet_data['short_name'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(38);
        $this->pdf->Cell(63,97,$marksheet_data['atp_name'],0,0,'L');
        $this->pdf->SetX(132);
        $this->pdf->Cell(62,97,$session,0,0,'L');
        $this->pdf->Ln(3);

         $i = 1;
		 $this->pdf->SetY(118);
         if (!empty($subject_array['subject'])) {
             foreach ($subject_array['subject'] as $key => $subs) {
                 $this->pdf->SetTextColor(0,0,0);
                 $this->pdf->SetFont('Arial','',9);
                 $this->pdf->SetX(24);
                 $this->pdf->Cell(89,6,($i++).') '.$subs ,0,0,'L');
                 $this->pdf->SetX(133);
                 $this->pdf->Cell(15,6,$total_marks_array['marks'][$key],0,0,'L');
                 $this->pdf->SetX(155);
                 $this->pdf->Cell(17,6,$mark_obtain_array['marks_obtained'][$key],0,0,'L');
                 $this->pdf->SetX(179);
                 $this->pdf->Cell(12,6,$grade_array['grade'][$key],0,0,'C');
                 $this->pdf->Ln(10);
             }
         }

		if (!empty($labels_array)) {
			
			 foreach ($labels_array as $key => $labs) {$i=1;
                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(24);
                $this->pdf->Cell(89,6,$labs,0,0,'L');
                $this->pdf->Ln(5);  
                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetX(24);
                    $this->pdf->MultiCell(100,4, ($i++).') '.$val,0,'L',false); 
                    $this->pdf->Ln(2);  
                }
                //Multiple line marks
                $this->pdf->SetY(123);
                foreach ($subject_array[$key] as $key1=>$val) {
                    $this->pdf->SetX(130);
                    $this->pdf->Cell(20,6,$total_marks_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(152);
                    $this->pdf->Cell(25,6,$mark_obtain_array[$key][$key1],0,0,'C');
                    $this->pdf->SetX(180);
                    $this->pdf->Cell(12,6,$grade_array[$key][$key1],0,0,'C');
                    $this->pdf->Ln(10);  
                }
                $this->pdf->Ln(2);  
            }
        }

        $this->pdf->SetXY(133,188);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks'],0,0,'L');
        $this->pdf->SetX(155);

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetX(178.6);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(12,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetXY(53,200.3);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(30,6,$marksheet_data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(94);
        $this->pdf->Cell(30,6,$marksheet_data['overall_percentage'].'%',0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(135.5);
        $this->pdf->Cell(14,6,$marksheet_data['overall_grade'],0,0,'C');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(180);
        $this->pdf->Cell(30,6,$marksheet_data['typing_speed'],0,0,'L');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetXY(85,216); 
        $this->pdf->Cell(30,10, date('d-m-Y',(int)$marksheet_data['issued_date']),0,0,'C');


        //******************Marksheet Section end********************//

        //******************Certificate Section start********************//

        $certificate_data = (array)$data['certificate']; 
        $student_certificate_photo = site_url().'public/upload/branch-files/student/student-image/'.$certificate_data['student_photo'];
        $branch_head_certificate_signature = site_url().'public/upload/files/branch/signature/'.$certificate_data['branch_signature'];

        $secretary = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_SECRETARY'];
        $chairman = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];

        $certificate_qrData = 'Enroll. No. : '.$certificate_data['enrollment_number'].' Name: '.$certificate_data['candidate_name'].'. Guardian: '.$certificate_data['father_name'];
        $certificate_qrData = $this->generateQrCode($certificate_qrData, 1);
        $certificate_qrData = explode(',',$certificate_qrData,2)[1];
        $certificate_qrData = 'data://text/plain;base64,'. $certificate_qrData;
        $certificate_dataPieces = explode(',',$certificate_qrData);
        $certificate_encodedImg = $certificate_dataPieces[1];
        $certificate_encodedImg = base64_decode($certificate_encodedImg);

        if( $certificate_encodedImg!==false )
        {
            if( file_put_contents(TEMPIMGLOC,$certificate_encodedImg)!==false )
            {
                $this->pdf->Image(TEMPIMGLOC, 230,80,24,0);
                unlink(TEMPIMGLOC);
            }
        }
        //END
        $this->pdf->Image($examination_controller_signature, 340,202,18,0);
        $this->pdf->Image($secretary, 295,202,18,0);
        $this->pdf->Image($chairman, 248,202,18,0);

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetFont('Arial','B',8);
        $this->pdf->SetXY(247,14);
        $this->pdf->Cell(65,7,$certificate_data['certificate_no'],0,0,'C');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(364,14);
        $this->pdf->Cell(40,7,$certificate_data['academy_code'],0,0,'C');
        $this->pdf->Ln(10);

        $this->pdf->Image($student_certificate_photo, 372,83.5,24,0);

        $this->pdf->SetTextColor(16,38,148);
        $this->pdf->SetFont('Arial','B',9);

        $this->pdf->SetXY(255,111);
        $this->pdf->Cell(110,6,$certificate_data['candidate_name'],0,0,'L');

        $this->pdf->SetXY(250,125);
        $this->pdf->Cell(116,6,$certificate_data['father_name'],0,0,'L');

        $this->pdf->SetXY(278,139);
        $this->pdf->Cell(105,6,$certificate_data['course_name'],0,0,'L');


        $this->pdf->SetXY(262,153);
        $this->pdf->Cell(29,6,'Three Months',0,0,'L');

        $this->pdf->SetXY(297,153);
        $this->pdf->Cell(80,6,date('M Y',(int)$certificate_data['from_session']).' - '.date('M Y',(int)$certificate_data['to_session']),0,0,'C');

        $this->pdf->SetXY(240,167);
        $this->pdf->Cell(70,6,$certificate_data['branch_name'],0,0,'L');

        $this->pdf->SetXY(363,167);
        $this->pdf->Cell(8,6,$certificate_data['grade'],0,0,'C');

        $this->pdf->SetXY(255,184);
        $this->pdf->Cell(35,6,date('j F Y',$certificate_data['issued_date']),0,0,'L');

        $this->pdf->SetXY(330,184);
        $this->pdf->Cell(40,6,$certificate_data['enrollment_number'],0,0,'L');
        //******************Certificate Section end********************//


        $this->response->setHeader('Content-Type', 'application/pdf');
        $fileName = $marksheet_data['enrollment_number'].'.pdf';
        $this->pdf->output($path.'/'.$fileName, 'F');
        return $fileName;
	}
    private function generate_two_certificate_pdf($data)
    {
    	$certificate_data = array();
        $certificate_data = (array)$data['certificate2'];

		$path ='upload/files/combined-pdf';
		$background = site_url().'public/print-template/Two-Certificate-Template.jpg';
		$examination_controller_signature = site_url().'public/upload/settings/'. config('SiteConfig')->media['SIGN_EXAM_CONTROLLER'];
		
		$secretary = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_SECRETARY'];
		$chairman = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];
		$student_photo = site_url().'public/upload/branch-files/student/student-image/'.$certificate_data['student_photo'];

		$this->pdf = new FPDF('P','mm',array(420,280));
	
		//******************Certificate Section 1 start********************//
		$this->pdf->SetAutoPageBreak(false);
        $this->pdf->AddPage('Legal');
        $this->pdf->Image($background, 0, -3.0, 420, 280);
		$this->pdf->Image($examination_controller_signature, 130,202,18,0);
		$this->pdf->Image($secretary, 85,202,18,0);
		$this->pdf->Image($chairman, 40,202,18,0);
		
		
		
		//QR CODE
		$qrData = 'Enroll. No. : '.$certificate_data['enrollment_number'].' Name: '.$certificate_data['candidate_name'].'. Guardian: '.$certificate_data['father_name'];
		$qrCode = $this->generateQrCode($qrData, 1);

		$qrCode = explode(',',$qrCode,2)[1];
		$qrCode = 'data://text/plain;base64,'. $qrCode;
		$dataPieces = explode(',',$qrCode);
		$encodedImg = $dataPieces[1];
		$decodedImg = base64_decode($encodedImg);

		if ( $decodedImg!==false ) {
			if ( file_put_contents(TEMPIMGLOC,$decodedImg)!==false ) {
				$this->pdf->Image(TEMPIMGLOC, 27,80,24,0);
				unlink(TEMPIMGLOC);
			}
		}
		//END
		
		$this->pdf->SetTextColor(255,0,0);
		$this->pdf->SetFont('Arial','B',8);
        $this->pdf->SetXY(41,14.5);
		$this->pdf->Cell(62,5,$certificate_data['certificate_no'],0,0,'C');

        $this->pdf->SetXY(160,14.5);
		$this->pdf->Cell(38,5,$certificate_data['academy_code'],0,0,'C');
		$this->pdf->Ln(10);

		$this->pdf->Image($student_photo, 168,84,24,0);

		$this->pdf->SetTextColor(16,38,148);
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetXY(50,111);
		$this->pdf->Cell(110,6,$certificate_data['candidate_name'],0,0,'L');

		$this->pdf->SetXY(45,125);
		$this->pdf->Cell(116,6,$certificate_data['father_name'],0,0,'L');

		$this->pdf->SetXY(73,139);
		$this->pdf->Cell(100,6,$certificate_data['course_name'],0,0,'L');


		$this->pdf->SetXY(57,153);
		$this->pdf->Cell(33,6,'Three Months',0,0,'C');

		$this->pdf->SetXY(103,153);
		$this->pdf->Cell(60,6,date('M Y',(int)$certificate_data['from_session']).' - '.date('M Y',(int)$certificate_data['to_session']),0,0,'C');

        if( strlen($certificate_data['branch_name']) < 45 ){
            $this->pdf->SetXY(31,167);
            $this->pdf->Cell(75,6,$certificate_data['branch_name'],0,0,'C');
        }else{
            $this->pdf->SetXY(35,164);
            $this->pdf->MultiCell(70,4, $certificate_data['branch_name'] ,0,'L',false);
        }

		$this->pdf->SetXY(160,167);
		$this->pdf->Cell(8,6,$certificate_data['grade'],0,0,'L');

		$this->pdf->SetXY(50,184);
		$this->pdf->Cell(37,6,date('j F Y',(int)$certificate_data['issued_date']),0,0,'C');

		$this->pdf->SetXY(125,184);
		$this->pdf->Cell(40,6,$certificate_data['enrollment_number'],0,0,'C');
		
		
		
		//******************Certificate Section 1 end********************//
		
		
		
		//******************Certificate Section 2 start********************//
		
		$certificate_data = array();
		$certificate_data = (array)$data['certificate'];
		$student_certificate_photo = site_url().'public/upload/branch-files/student/student-image/'.$certificate_data['student_photo'];
	
		
		$certificate_qrData = 'Enroll. No. : '.$certificate_data['enrollment_number'].' Name: '.$certificate_data['candidate_name'].'. Guardian: '.$certificate_data['father_name'];
		$certificate_qrData = $this->generateQrCode($certificate_qrData, 1);
		$certificate_qrData = explode(',',$certificate_qrData,2)[1];
		$certificate_qrData = 'data://text/plain;base64,'. $certificate_qrData;
		$certificate_dataPieces = explode(',',$certificate_qrData);
		$certificate_encodedImg = $certificate_dataPieces[1];
		$certificate_encodedImg = base64_decode($certificate_encodedImg);

		if ( $certificate_encodedImg!==false ) {
			if ( file_put_contents(TEMPIMGLOC,$certificate_encodedImg)!==false ) {
				$this->pdf->Image(TEMPIMGLOC, 230,80,24,0);
				unlink(TEMPIMGLOC);
			}
		}
		//END
		$this->pdf->Image($examination_controller_signature, 340,202,18,0);
		$this->pdf->Image($secretary, 295,202,18,0);
		$this->pdf->Image($chairman, 248,202,18,0);

		$this->pdf->SetTextColor(255,0,0);
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->SetXY(247,14);
		$this->pdf->Cell(65,7,$certificate_data['certificate_no'],0,0,'C');
		$this->pdf->Ln(10);

		$this->pdf->SetXY(364,14);
		$this->pdf->Cell(40,7,$certificate_data['academy_code'],0,0,'C');
		$this->pdf->Ln(10);

		$this->pdf->Image($student_certificate_photo, 372,83.5,24,0);

		$this->pdf->SetTextColor(16,38,148);
		$this->pdf->SetFont('Arial','B',9);

		$this->pdf->SetXY(255,111);
		$this->pdf->Cell(110,6,$certificate_data['candidate_name'],0,0,'L');

		$this->pdf->SetXY(250,125);
		$this->pdf->Cell(116,6,$certificate_data['father_name'],0,0,'L');

		$this->pdf->SetXY(278,139);
		$this->pdf->Cell(105,6,$certificate_data['course_name'],0,0,'L');


		$this->pdf->SetXY(262,153);
		$this->pdf->Cell(29,6,'Three Months',0,0,'L');

		$this->pdf->SetXY(297,153);
		$this->pdf->Cell(80,6,date('M Y',(int)$certificate_data['from_session']).' - '.date('M Y',(int)$certificate_data['to_session']),0,0,'C');

		$this->pdf->SetXY(240,167);
		$this->pdf->Cell(70,6,$certificate_data['branch_name'],0,0,'L');

		$this->pdf->SetXY(363,167);
		$this->pdf->Cell(8,6,$certificate_data['grade'],0,0,'C');

		$this->pdf->SetXY(255,184);
		$this->pdf->Cell(35,6,date('j F Y',(int)$certificate_data['issued_date']),0,0,'L');

		$this->pdf->SetXY(330,184);
		$this->pdf->Cell(40,6,$certificate_data['enrollment_number'],0,0,'L');
		//******************Certificate Section 1 end********************//
		

		$this->response->setHeader('Content-Type', 'application/pdf');
		$fileName = $certificate_data['enrollment_number'].'.pdf';
		$this->pdf->output($path.'/'.$fileName, 'F');
		return $fileName;
        
    }

     private function generateQrCode($data , $type = 0)
    {
        if ($type) {
            return (new QRCode)->render($data);
        }else{
            return '<img src="' . (new QRCode)->render($data) . '" alt="NYCTA QR Code" />';

        }
    }
	public function delete_combined_pdf($id = 0)
	{
		if ($this->request->getMethod() == 'get') {
			define('PATH', 'upload/files/combined-pdf/');
            if (is_numeric($id)){
            	$data = $this->crud->select('combined_pdf', '', ['id' => $id], '', true);
                if (!empty($data)) {
                	if (file_exists(PATH.$data->combined_pdf)) {
                		if ($this->crud->deleteData('combined_pdf', ['id' => $id]) && unlink(PATH.$data->combined_pdf)) {
                			$this->session->setFlashData('message', 'Combined PDF has been deleted successfully');
                			$this->session->setFlashData('message_type', 'success');
                			return redirect()->to('/head-office/print-pdf'); die;
                		}
                	}
                } else {
                	$this->session->setFlashData('message', 'Something went wrong!');
                	$this->session->setFlashData('message_type', 'error');
                	return redirect()->to('/head-office/print-pdf'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Access Denied!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('head-office/print-pdf'); die;
            }
        }
	}

	public function ajax_dt_get_combined_pdf_list()
	{
		$postData = $this->request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
        $where = '';
        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length'];
        $columnIndex = $dtpostData['order'][0]['column'];
        $columnName = $dtpostData['columns'][$columnIndex]['data'];
        $columnSortOrder = $dtpostData['order'][0]['dir'];
        $keyword = $dtpostData['keyword'];

        ## Total number of records without filtering
        $totalRecords = get_count('combined_pdf');
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;

        if (!empty($keyword)) {
            $where .= empty($where)?"`first_enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `second_enrollment_number` LIKE '%$keyword%' ESCAPE '!'":" AND `first_enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `second_enrollment_number` LIKE '%$keyword%' ESCAPE '!'";
        }

        if (!empty($where)) {
        	$totalRecordwithFilter = get_count('combined_pdf', $where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableCombinedPdfList($where, $columnSortOrder, $rowperpage, $start);

        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = '';

            $actions .= '<a href="javascript:void(0)" onclick="printCombinedPdf('."'".site_url('public/upload/files/combined-pdf/'.$record->combined_pdf)."'".')" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Print"><i class="fas fa-print"></i></a>';
            $actions .= '<a href="'.site_url('public/upload/files/combined-pdf/'.$record->combined_pdf).'" class="btn btn-success btn-sm btn-icon" data-toggle="tooltip" title="Download Combined PDF" download><i class="fa-solid fa-download"></i></a>';
            $actions .= '<a href="javascript:void(0)" data-id="'."$record->id".'" class="btn btn-danger btn-sm btn-icon deleteCombinedPdf" data-toggle="tooltip" title="Delete" download><i class="fa-solid fa-trash"></i></a>';


            $data[] = array( 
                "slNo" => $i++,
                "enrollment_number_1" => $record->first_enrollment_number,
                "enrollment_number_2" => $record->second_enrollment_number,
                "created_at" => date('M j, Y', $record->created_at),
                'action' => $actions,
            ); 
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "hash" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
	}

}
