<?php
namespace App\Controllers\Headoffice;

use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Libraries\Pdf\FPDF;
use App\Models\Exporter_model;
use App\Models\Notification_model;

use chillerlan\QRCode\{QROptions, QRCode};
const TEMPIMGLOC = 'tempimg.png';

use Config\Services;

class Marksheet extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->crud = new Crud_model($db);
        $this->dt = new Datatable_model($db);
        $this->notification = new Notification_model($db);

        $this->expo = new Exporter_model($db);
        $this->pdf = new FPDF();


        //load helper
        helper('custom');
        if (!$this->session->isBranchLoggedIn) {
            return redirect()->to('branch');
        }
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Student Marksheet List';
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id', array('status' => 1));
            return view('headoffice/marksheet/manage-marksheet', $this->data);
         }
    }

    public function marksheet_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('marksheets', '', array('id' => $id), '', true);
               if (!empty($details)) {
                   $this->data['title'] = 'Marksheet Details';
                   return view('headoffice/marksheet/marksheet-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/head-office/marksheet'); die;
               }
            }
        }
    }

    public function change_status($type, $id)
    {
        $details = $this->crud->select('marksheets', '', array('id' => $id), '', true);
        if ($this->request->getMethod('get') && !$this->request->isAJAX() && is_headoffice()) {
            if (!empty($this->crud->select('marksheets', 'id', array('id' => $id)))) {

                if ($type == 'a') {
                    $data['status'] = 2;
                    $data['issued_date'] = strtotime($_GET['date']);
                    $message = 'Marksheet has been successfully approved.';
                }elseif ($type == 'r') {
                    $data['status'] = 3;
                    $message = 'Marksheet has been successfully rejected.';
                }elseif ($type == 'p') {

                     //To send published notification
                     $notiArr = array(
                        'from_id' => $this->session->userData['id'],
                        'form_id_type' => 1,
                        'to_id' => $details->branch_id,
                        'to_id_type' => 2,
                        'type' => 12,
                        'slug' => 'marksheet-publish',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                     //To send wallet balance deduction notification
                     $notiArr = array(
                        'from_id' => $this->session->userData['id'],
                        'form_id_type' => 1,
                        'to_id' => $details->branch_id,
                        'to_id_type' => 2,
                        'type' => 13,
                        'slug' => 'marksheet-wallet-balance-deduction',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $data['status'] = 4;
                    $message = 'Marksheet has been successfully published.';
                }else {
                    $this->session->setFlashData('message', 'Something went Wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die; 
                }
                
                if (!empty($data)) {
                    if ($this->crud->updateData('marksheets', array('id' => $id), $data)) {
                        if ($type == 'a') {
                            $this->generate_marksheet($id);
                        }
                        $this->session->setFlashData('message', $message);
                        $this->session->setFlashData('message_type', 'success');
                        return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die; 
                    }
                }
                
            }else{
                $this->session->setFlashData('message', 'No Data Found');
                $this->session->setFlashData('message_type', 'success');
                return redirect()->to('/head-office/marksheet'); die;
            }
        }
    }

    public function ajax_dt_get_marksheet_list()
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
        $status = $dtpostData['status'];
        $branchId = $dtpostData['branch'];

        ## Total number of records without filtering
        $totalRecords = get_count('marksheets');
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($branchId)) {
            $where .= "`marksheets.branch_id`=$branchId";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"`marksheets.marksheet_no` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!'":" AND `marksheets.marksheet_no` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($status)) {
            $where .= empty($where)?"`marksheets.status`=$status":" AND `marksheets.status`=$status";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getMarksheetListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoMarksheetList($keyword, $columnSortOrder, $rowperpage, $start, $branchId, $status);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = '';

            if ($record->status == 1) {
                $status = '<span class="badge badge-warning-lighten">Processing</span>';
            }elseif ($record->status == 2) {
                $status = '<span class="badge badge-secondary-lighten">Under Preview</span>';                
            }elseif ($record->status == 4) {
                $status = '<span class="badge badge-success-lighten">Published</span>';                
            }else {
                $status = '<span class="badge badge-danger-lighten">Rejected</span>';
            }

            $actions = '<a href="'.site_url('head-office/marksheet/marksheet-details/').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';

            if ($record->is_urgent_certificate_required == 'Yes') {
                $req = 'Marksheet: <b class="text-muted">Urgent</b>';
            }else {
                $req = 'Marksheet: <b class="text-muted">Regular</b>';
            }

            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number.'</br>'.$req,
                "marksheet_number" => $record->marksheet_no,
                "course" => $record->short_name,
                "session" => date('M y', $record->from_session).'-'.date('M y', $record->to_session),
                "status" => $status,
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
    public function pdf_generate($type='',$data = array()){
 
		$total_row=0;
		if (!empty($data['subjects']['subject'])) {
			$total_row += count($data['subjects']['subject']);
		}
        if (!empty($data['labels'])) {
    		foreach ($data['labels'] as $d=>$v) {
    			$total_row += count($data['subjects'][$d]);
    		}
        }


        $path ='upload/branch-files/student/marksheet';
        $background = site_url().'public/marksheet-images/Marksheet-Template.jpg';
        $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$data['student_photo'];
        $examination_controller_signature = site_url().'public/upload/settings/'.$data['examination_controller_signature'];
        $branch_head_signature = site_url().'public/upload/files/branch/signature/'.$data['branch_head_signature'];

        $this->pdf = new FPDF('P','mm',array(210,278));        
       // $this->pdf=new PDF_Code128('P','mm',array(210,278));
        $this->pdf->SetAutoPageBreak(false);
        $this->pdf->AddPage();
        $this->pdf->Image($background, 0, -2.0, 210, 280);
        $this->pdf->Image($student_photo, 173.5,55.5,24,0);

        $this->pdf->Image($examination_controller_signature, 45,219,18,0);
        $this->pdf->Image($branch_head_signature, 134,217,18,0);
        
        //QR CODE
        $qrData = 'Enroll. No. : '.$data['enrollment_number'].' Name: '.$data['candidate_name'].'. Guardian: '.$data['father_name'];
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
        $this->pdf->SetX(168);
        $this->pdf->Cell(33,4.5,$data['marksheet_no'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetXY(168,20.5);
        $this->pdf->Cell(33,-7.7,$data['center_code'],0,0,'L');
        $this->pdf->Ln(8);

        $this->pdf->SetTextColor(16,38,148);
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->SetX(43);
        $this->pdf->Cell(62,109,$data['candidate_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,109,$data['enrollment_number'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(43);
        $this->pdf->Cell(62,103,$data['father_name'],0,0,'L');
        $this->pdf->SetX(134);
        $this->pdf->Cell(62,103,$data['course_name'],0,0,'L');
        $this->pdf->Ln(10);

        $this->pdf->SetX(36);
        $this->pdf->Cell(62,97,$data['atp_name'],0,0,'L');
        $this->pdf->SetX(132);
        $this->pdf->Cell(62,97,$data['session'],0,0,'L');
        $this->pdf->Ln(3);

        $i = 1;
		$this->pdf->SetY(118);
        if (!empty($data['subjects']['subject'])) {
            foreach ($data['subjects']['subject'] as $key => $subs) {
                $this->pdf->SetTextColor(0,0,0);
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->SetX(20);
                $this->pdf->Cell(89,6,($i++).') '.$subs ,0,0,'L');
                $this->pdf->SetX(133);
                $this->pdf->Cell(15,6,$data['totalMarks']['marks'][$key],0,0,'L');
                $this->pdf->SetX(155);
                $this->pdf->Cell(17,6,$data['marksObtained']['marks_obtained'][$key],0,0,'L');
                $this->pdf->SetX(179);
                $this->pdf->Cell(12,6,$data['grade']['grade'][$key],0,0,'C');
                $this->pdf->Ln(10);
            }
        }

		if (!empty($data['labels'])) {
			
			foreach ($data['labels'] as $key => $labs) {$i=1;
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetFont('Arial','',9);
				$this->pdf->SetX(20);
				$this->pdf->Cell(89,6,$labs,0,0,'L');
				$this->pdf->Ln(5);	
				foreach ($data['subjects'][$key] as $key1=>$val) {
					$this->pdf->SetTextColor(0,0,0);
					$this->pdf->SetFont('Arial','',9);
					$this->pdf->SetX(20);
                    $this->pdf->MultiCell(89,4, ($i++).') '.$val,0,'L',false); 
					$this->pdf->Ln(2);	
				}
                $this->pdf->SetY(123);
                foreach ($data['subjects'][$key] as $key1=>$val) {
                    $this->pdf->SetX(133);
                    $this->pdf->Cell(89,6,$data['totalMarks'][$key][$key1],0,0,'L');
                    $this->pdf->SetX(155);
                    $this->pdf->Cell(89,6,$data['marksObtained'][$key][$key1],0,0,'L');
                    $this->pdf->SetX(182);
                    $this->pdf->Cell(89,6,$data['grade'][$key][$key1],0,0,'L');
                    $this->pdf->Ln(10);  
                }
				$this->pdf->Ln(2);  
            }
        }
           
        $this->pdf->SetXY(133,190);
        $this->pdf->Cell(30,6,$data['total_marks'],0,0,'L');
        $this->pdf->SetX(155);

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(30,6,$data['total_marks_obtained'],0,0,'L');


        $this->pdf->SetX(178.6);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(12,6,$data['overall_grade'],0,0,'C');

        $this->pdf->SetXY(53,204);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(30,6,$data['total_marks_obtained'],0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(94);
        $this->pdf->Cell(30,6,$data['overall_percentage'].'%',0,0,'L');

        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetX(135.5);
        $this->pdf->Cell(14,6,$data['overall_grade'],0,0,'C');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(180);
        $this->pdf->Cell(30,6,$data['typing_speed'],0,0,'L');

        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetXY(85,220); 
        $this->pdf->Cell(30,10,$data['issued_date'],0,0,'C');

        //barcode
        //$this->pdf->Code128(97,200,$data['enrollment_number'],80,8,true);
        //end barcode

        $this->response->setHeader('Content-Type', 'application/pdf');
        $fileName = $data['enrollment_number'].'.pdf';
        $this->pdf->output($path.'/'.$fileName, 'F');
        return $fileName;
    }
    private function generate_marksheet($id)
    {

        if (!empty($id)) {
            if ($id && is_numeric($id)) {
                /*START FETCHING INVOICE DATA*/
                $details = $this->expo->getMarksheetData($id);

                $markshet_data = array();
                $markshet_data['marksheet_no'] = $details->marksheet_no;
                $markshet_data['center_code'] = $details->academy_code;
                $markshet_data['candidate_name'] = $details->candidate_name;
                $markshet_data['enrollment_number'] = $details->enrollment_number;
                $markshet_data['father_name'] = $details->father_name;
                $markshet_data['course_name'] = $details->short_name;
                $markshet_data['atp_name'] = $details->atp_name;
                $markshet_data['student_photo'] = $details->student_photo;
                $markshet_data['session'] = date('M Y',(int)$details->from_session).' - '.date('M Y',(int)$details->to_session) ;
                $markshet_data['total_marks'] = $details->total_marks; 
                $markshet_data['total_marks_obtained'] = $details->total_marks_obtained; 
                $markshet_data['overall_grade'] = $details->overall_grade; 
                $markshet_data['overall_percentage'] = $details->overall_percentage; 
                $markshet_data['issued_date'] = date('d-m-Y',(int)$details->issued_date); 
                $markshet_data['typing_speed'] = $details->typing_speed; 
                $markshet_data['examination_controller_signature'] = config('SiteConfig')->media['SIGN_EXAM_CONTROLLER']; 
                $markshet_data['branch_head_signature'] = $details->signature;

                $subject_array = $total_marks_array = $mark_obtain_array = $grade_array = array();
                $subject_array = unserialize($details->subjects);
                $total_marks_array = unserialize($details->marks);
                $mark_obtain_array = unserialize($details->marks_obtained);
                $grade_array = unserialize($details->grade);
                $labels_array = ((empty($details->labels))?'':unserialize($details->labels));

                $markshet_data['subjects'] = $subject_array;
                $markshet_data['totalMarks'] = $total_marks_array;
                $markshet_data['marksObtained'] = $mark_obtain_array;
                $markshet_data['grade'] = $grade_array;
                $markshet_data['labels'] = $labels_array;
				
                if (!empty($details)) {

                    $marksheet = $this->pdf_generate('marksheet',$markshet_data);

                    $dataArr = array(
                        'marksheet_file' => $marksheet,
                    );
                    if ($this->crud->updateData('marksheets', array('id' => $details->id), $dataArr)) {
                        return true;
                    }else {
                        $this->session->setFlashData('message', 'Something went wrong!');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die;
                    }
                    
                }else {
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die;
                }
            }else {
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die;
            }
        }else {
            $this->session->setFlashData('message', 'Something went wrong!');
            $this->session->setFlashData('message_type', 'error');
            return redirect()->to('/head-office/marksheet/marksheet-details/'.$id); die;
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
