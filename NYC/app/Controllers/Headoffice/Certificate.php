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

class Certificate extends BaseController
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
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Student Certificate List';
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id', array('status' => 1));
            return view('headoffice/certificate/manage-certificate', $this->data);
         }
    }

    public function certificate_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('certificates', '', array('id' => $id), '', true);
               if (!empty($details)) {
                   $this->data['title'] = 'Certificate Details';
                   return view('headoffice/certificate/certificate-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/head-office/certificate'); die;
               }
            }
        }
    }

    public function change_status($type, $id)
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX() && is_headoffice()) {

            if(isset($_GET['d'])){
                $issue_date_update = array();
                $issue_date_update['issued_date'] = strtotime($_GET['d']);
                $this->crud->updateData('certificates', array('id' => $id), $issue_date_update);
            }
            

            if (!empty($details = $this->crud->select('certificates', '', array('id' => $id), '', true))) {
                $is_urgent = fieldValue('admission', 'is_urgent_certificate_required', ['enrollment_number' => $details->enrollment_number]);
                if ($type == 'a') {
                    $data['status'] = 2;
                    $message = 'Certificate has been successfully approved.';
                }elseif ($type == 'r') {
                    $data['status'] = 3;
                    $message = 'Certificate has been successfully rejected.';
                }elseif ($type == 'p') {
                    $data['status'] = 4;
                    $message = 'Certificate has been successfully published.';
                    //$data['issued_date'] = strtotime('now');
                    $walletBal = getWalletBalance($details->branch_id);
                    if ($is_urgent == 'Yes') {
                        $reqBal = config('SiteConfig')->general['URGENT_CERTIFICATE_CHARGE'];
                    }else {
                        $reqBal = config('SiteConfig')->general['CERTIFICATE_GENERATE_CHARGE'];
                    }
                    if ($walletBal < $reqBal) {
                        $this->session->setFlashData('message', 'Branch does not have sufficient wallet balance!');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('/head-office/certificate/certificate-details/'.$id); die; 
                    }else {

                        $walletArr = array(
                            'branch' => $details->branch_id,
                            'amount' => $reqBal,
                            'transaction_type' => 2,
                            'notes' => (($is_urgent == 'Yes')?'Urgent Student Certificate':'Student Certificate'),
                            'created_at' => strtotime('now'),
                            'added_by' => $this->session->userData['id'],
                        );
                    }
                }else {
                    $this->session->setFlashData('message', 'Something went Wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/certificate/certificate-details/'.$id); die; 
                }
                if ($this->crud->updateData('certificates', array('id' => $id), $data)) {
                    if ($type == 'p') {
                        if ($this->crud->add('wallet', $walletArr)) {

                            //To send published notification
                            $notiArr = array(
                                'from_id' => $this->session->userData['id'],
                                'form_id_type' => 1,
                                'to_id' => $details->branch_id,
                                'to_id_type' => 2,
                                'type' => 10,
                                'slug' => 'certificate-publish',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);

                             //To send wallet balance deduction notification
                             $notiArr = array(
                                'from_id' => $this->session->userData['id'],
                                'form_id_type' => 1,
                                'to_id' => $details->branch_id,
                                'to_id_type' => 2,
                                'type' => 11,
                                'slug' => 'certificate-wallet-balance-deduction',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                            //$this->generate_certificate($id);
                        }
                    }
                    //12-05-2022
                    if ($type == 'a') {
                        $this->generate_certificate($id);
                    }
                    //end
                    $this->session->setFlashData('message', $message);
                    $this->session->setFlashData('message_type', 'success');
                    return redirect()->to('/head-office/certificate/certificate-details/'.$id); die; 
                }
            }else{
                $this->session->setFlashData('message', 'No Data Found');
                $this->session->setFlashData('message_type', 'success');
                return redirect()->to('/head-office/certificate'); die;
            }
        }
    }


    public function ajax_dt_get_certificate_list()
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
        $totalRecords = get_count('certificates');
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($branchId)) {
            $where .= "`certificates.branch_id`=$branchId";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"`certificates.certificate_no` LIKE '%$keyword%' ESCAPE '!' OR `certificates.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `certificates.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `certificates.grade` LIKE '%$keyword%' ESCAPE '!'":" AND `certificates.certificate_no` LIKE '%$keyword%' ESCAPE '!' OR `certificates.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `certificates.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `certificates.grade` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($status)) {
            $where .= empty($where)?"`certificates.status`=$status":" AND `certificates.status`=$status";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getCertificateListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoCertificateList($keyword, $columnSortOrder, $rowperpage, $start, $branchId, $status);
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

            $actions = '<a href="'.site_url('head-office/certificate/certificate-details/').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';

            if ($record->is_urgent_certificate_required == 'Yes') {
                $req = 'Certificate: <b class="text-muted">Urgent</b>';
            }else {
                $req = 'Certificate: <b class="text-muted">Regular</b>';
            }

            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number.'</br>'.$req,
                "certificate" => $record->certificate_no,
                "course" => $record->short_name,
                "grade" => $record->grade,
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

    public function typing_certificate_generate($data = array()){

            $path ='upload/branch-files/student/certificate';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $background = site_url().'public/certificate-image/Certificate-Template-Typing.jpg';
            $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$data->student_photo;
            $examination_controller_signature = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_EXAM_CONTROLLER'];
            $secretary = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_SECRETARY'];
            $chairman = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];

            $this->pdf = new FPDF('P','mm',array(210,278));
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AddPage();
            $this->pdf->Image($background, 0, -2.0, 210, 280);

            $this->pdf->Image($examination_controller_signature, 130,213,18,0);
            $this->pdf->Image($secretary, 85,213,18,0);
            $this->pdf->Image($chairman, 40,213,18,0);

            //QR CODE
            $qrData = 'Enroll. No. : '.$data->enrollment_number.' Name: '.$data->candidate_name.'. Guardian: '.$data->father_name;
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
                    $this->pdf->Image(TEMPIMGLOC, 17,80,24,0);
                    unlink(TEMPIMGLOC);
                }
            }
            //END

            $this->pdf->SetTextColor(255,0,0);
            $this->pdf->SetFont('Arial','B',7);

            $this->pdf->Cell(62,6.5,$data->certificate_no,0,0,'R');
            $this->pdf->Ln(10);

            $this->pdf->Cell(173,-13,$data->academy_code,0,0,'R');
            $this->pdf->Ln(10);

            $this->pdf->Image($student_photo, 166,82.5,24,0);

            $this->pdf->SetTextColor(16,38,148);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->SetXY(50,57);
            $this->pdf->Cell(62,109,$data->candidate_name,0,0,'L');

            $this->pdf->SetXY(50,70);
            $this->pdf->Cell(62,109,$data->father_name,0,0,'L');

            $this->pdf->SetXY(68,82);
            $this->pdf->Cell(62,109,$data->course_name,0,0,'L');


            $this->pdf->SetXY(58,94);
             $this->pdf->Cell(62,109,ucfirst(numbertoWords($data->course_duration)).' Months',0,0,'L');

            $this->pdf->SetXY(100,94);
            $this->pdf->Cell(62,109,date('M Y',(int)$data->from_session).' - '.date('M Y',(int)$data->to_session),0,0,'L');

            $this->pdf->SetXY(29,158);
            $this->pdf->Cell(80,6,$data->branch_name,0,0,'L');

            $this->pdf->SetXY(158,106);
            $this->pdf->Cell(62,109,$data->grade,0,0,'L');

            $this->pdf->SetXY(49,119);
            $this->pdf->Cell(62,109,date('j F Y',(int)$data->issued_date),0,0,'L');

            $this->pdf->SetXY(123,119);
            $this->pdf->Cell(62,109,$data->enrollment_number,0,0,'L');

            $language = unserialize($data->language);
            $speed = unserialize($data->speed);
            $accuracy = unserialize($data->accuracy);
            $time = unserialize($data->time);
			
			
            $this->pdf->SetXY(24,190);
            $this->pdf->Cell(35,8,$language[0],0,0,'C');
            
			$this->pdf->SetXY(24,197);
			$this->pdf->Cell(35,8,$language[1],0,0,'C');
			
			$this->pdf->SetXY(60,190);
			$this->pdf->Cell(35,8,$speed[0],0,0,'C');

			$this->pdf->SetXY(60,197);
			$this->pdf->Cell(35,8,$speed[1],0,0,'C');
			
			$this->pdf->SetXY(96,190);
			$this->pdf->Cell(35,8,$accuracy[0],0,0,'C');

			$this->pdf->SetXY(96,197);
			$this->pdf->Cell(35,8,$accuracy[1],0,0,'C');
			
			$this->pdf->SetXY(131,190);
			$this->pdf->Cell(35,8,$time[0],0,0,'C');

			$this->pdf->SetXY(131,197);
			$this->pdf->Cell(35,8,$time[1],0,0,'C');

            


            $this->response->setHeader('Content-Type', 'application/pdf');
            $fileName = str_replace('/','-',trim($data->certificate_no)).'.pdf';
            $this->pdf->output($path.'/'.$fileName, 'F');
            return $fileName;
        
    }
    public function general_certificate_generate($data = array())
    {
      
            $path ='upload/branch-files/student/certificate';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $background = site_url().'public/certificate-image/Certificate-Template.jpg';
            $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$data->student_photo;
            $examination_controller_signature = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_EXAM_CONTROLLER'];
            $secretary = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_SECRETARY'];
            $chairman = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];

            $this->pdf = new FPDF('P','mm',array(210,278));
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AddPage();
            $this->pdf->Image($background, 0, -2.0, 210, 280);

            $this->pdf->Image($examination_controller_signature, 130,202,18,0);
            $this->pdf->Image($secretary, 85,202,18,0);
            $this->pdf->Image($chairman, 40,202,18,0);

            //QR CODE
            $qrData = 'Enroll. No. : '.$data->enrollment_number.' Name: '.$data->candidate_name.'. Guardian: '.$data->father_name;
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
                    $this->pdf->Image(TEMPIMGLOC, 17,80,24,0);
                    unlink(TEMPIMGLOC);
                }
            }
            //END

            $this->pdf->SetTextColor(255,0,0);
            $this->pdf->SetFont('Arial','B',7);
            $this->pdf->SetX(40);
            $this->pdf->Cell(62,6.5,$data->certificate_no,0,0,'L');
            $this->pdf->Ln(10);

            $this->pdf->Cell(173,-13,$data->academy_code,0,0,'R');
            $this->pdf->Ln(10);

            $this->pdf->Image($student_photo, 166,82.5,24,0);

            $this->pdf->SetTextColor(16,38,148);
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->SetXY(50,59.5);
            $this->pdf->Cell(62,109,$data->candidate_name,0,0,'L');

            $this->pdf->SetXY(50,73.5);
            $this->pdf->Cell(62,109,$data->father_name,0,0,'L');

            $this->pdf->SetXY(68,88);
            $this->pdf->Cell(62,109,$data->course_name,0,0,'L');


            $this->pdf->SetXY(58,102.5);
            $this->pdf->Cell(62,109,ucfirst(numbertoWords($data->course_duration)).' Months',0,0,'L');

            $this->pdf->SetXY(100,103);
            $this->pdf->Cell(62,109,date('M Y',(int)$data->from_session).' - '.date('M Y',(int)$data->to_session),0,0,'L');

            if( 0){
                $this->pdf->SetXY(29,169);
                $this->pdf->Cell(80,6,$data->branch_name,0,0,'L');
            }else{
                $this->pdf->SetXY(29,170);
                $this->pdf->MultiCell(80,4, $data->branch_name ,0,'T',false);
            }
            
            $this->pdf->SetXY(158,118);
            $this->pdf->Cell(62,109,$data->grade,0,0,'L');

            $this->pdf->SetXY(49,135.5);
            $this->pdf->Cell(62,109,date('j F Y',(int)$data->issued_date),0,0,'L');
            
            $this->pdf->SetXY(123,135.5);
            $this->pdf->Cell(62,109,$data->enrollment_number,0,0,'L');

            $this->response->setHeader('Content-Type', 'application/pdf');
            $fileName = str_replace('/','-',trim($data->certificate_no)).'.pdf';
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
    private function generate_certificate($id)
    {
        
        if (!empty($id)) {
            if ($id && is_numeric($id)) {
                /*START FETCHING INVOICE DATA*/
                $details = $this->expo->getCertificateData($id); 
             
                if (!empty($details)) {
                    
                    if($details->typing_test){
                        $certificate = $this->typing_certificate_generate($details);
                    }else{
                        $certificate = $this->general_certificate_generate($details);
                    }
                    
                    $dataArr = array();
                    $dataArr = array(
                        'certificate_file' => $certificate,
                    );
                    if ($this->crud->updateData('certificates', array('id' => $details->id), $dataArr)) {
                        $this->crud->updateData('admission', ['id' => $details->admission_id], ['status' => 3]);
                        return true;
                    }else {
                        $this->session->setFlashData('message', 'Something went wrong!');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('/head-office/certificate/certificate-details/'.$id); die;
                    }
                    
                }else {
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/certificate/certificate-details/'.$id); die;
                }
            }else {
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/head-office/certificate/certificate-details/'.$id); die;
            }
        }else {
            $this->session->setFlashData('message', 'Something went wrong!');
            $this->session->setFlashData('message_type', 'error');
            return redirect()->to('/head-office/certificate/certificate-details/'.$id); die;
        }
    }
}
