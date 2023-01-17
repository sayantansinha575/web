<?php
namespace App\Controllers\Branch;

use App\Models\Branch\Admit_model;
use App\Libraries\Pdf\FPDF;
use App\Libraries\Pdf\PDF_Code128;
use App\Models\Exporter_model;
use App\Models\Notification_model;



use Config\Services;

class Admit extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->admit = new Admit_model($db);
        $this->expo = new Exporter_model($db);
        $this->pdf = new FPDF();
        $this->notification = new Notification_model($db);
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Admits';
            return view('branch/admit/manage-admit', $this->data);
         }
    }

    public function new_admit_card()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'New Admit';

            if (!empty($_REQUEST['enrollNo'])) {
                $enrollNo = $_REQUEST['enrollNo'];
                // $existingData = $this->crud->select('admits', '', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']), '', true);
                // if (!empty($existingData)) {
                //    return redirect()->to(site_url('branch/admit/admit-details/'.encrypt($existingData->id)));  die;
                // }
                if (!empty($details = $this->admit->getDetailsToApply($enrollNo, $this->session->branchData['id'])))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/admit/new-admit-card');
                }
            }
            return view('branch/admit/new-admit-card', $this->data);
        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) { 
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                if (strlen($this->request->getPost('exam_date')) == 0) {
                    $this->data['id'] = '#exam_date';
                    $this->data['message'] = 'Select examination date.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('exam_time')) == 0) {
                    $this->data['id'] = '#exam_time';
                    $this->data['message'] = 'Select examination time.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('exam_fees')) == 0) {
                    $this->data['id'] = '#exam_fees';
                    $this->data['message'] = 'Enter examination fees.';
                    error($this->data);
                }
                

                $data = $this->request->getPost();
                $dataArr = array(
                    'branch_id' => $this->session->branchData['id'],
                    'admission_id' => $data['admission_id'],
                    'course_id' => $data['course_id'],
                    'enrollment_number' => $data['enrollment_number'],
                    'registration_number' => $data['registration_number'],
                    'candidate_name' => $data['candidate_name'],
                    'exam_name' => $data['exam_name'],
                    'branch_code' => $data['branch_code'],
                    'exam_date' => strtotime($data['exam_date']),
                    'exam_day' => $data['exam_day'],
                    'exam_time' => $data['exam_time'],
                    'exam_fees' => $data['exam_fees'],
                    'student_photo' => $data['student_photo'],
                    'created_at' => strtotime('now'),
                );
                if ($lastId = $this->crud->add('admits', $dataArr)) {
                    $this->generate_admit($lastId);

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'admit_card_generate',
                        'slug' => 'admit-card-generate',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('branch/admit/admit-details/'.encrypt($lastId));
                    $this->data['message'] = 'Admit card has been successfully created.';
                    echo json_encode($this->data); die;
                }
            }
        }
    }

    public function pdf_generate($type='',$data = array())
    {   

        if($type == 'admit'){
            $path ='upload/branch-files/student/admit';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
          
            $background = site_url().'public/admin-image/student-admit-card.jpg';
            $student_photo = site_url().'public/upload/branch-files/student/student-image/'.$data->student_photo;
            $examination_controller_signature = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_EXAM_CONTROLLER'];
            $branch_signature = site_url().'/public/upload/files/branch/signature/'.$data->branch_signature;
            $barcodeCodeData = date("M d, Y", $data->exam_date);

            //die;

            //$this->pdf = new FPDF('P','mm',array(210,278));
            $this->pdf=new PDF_Code128('P','mm',array(210,278));
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AddPage();
            $this->pdf->Image($background, 0, -2.0, 210, 280);

            $this->pdf->SetXY(22,88);
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(55,15, date('d.m.Y',$data->exam_date),0,0,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetXY(75,88);
            $this->pdf->Cell(40,15,$data->exam_day,0,0,'C');

            $this->pdf->SetXY(115,88);
            $this->pdf->Cell(40,15,$data->exam_time,0,0,'C');

        
            $this->pdf->Image($student_photo, 158,85,26,0);

            $this->pdf->SetFont('Arial','',9);
            $this->pdf->SetXY(78,110);
            $this->pdf->Cell(75,10,$data->candidate_name,0,0,'L');

            $this->pdf->SetXY(78,120);
            $this->pdf->Cell(75,10,$data->registration_number,0,0,'L');
  
            $this->pdf->SetXY(78,129);
            $this->pdf->Cell(75,10,$data->enrollment_number,0,0,'L');

            $this->pdf->SetXY(78,139);
            $this->pdf->Cell(75,10,$data->exam_name,0,0,'L');
            
            $this->pdf->SetXY(78,149);
            $this->pdf->Cell(75,10,$data->branch_code,0,0,'L');

            $this->pdf->SetFont('Arial','',12);
            $this->pdf->SetXY(22,157);
            $this->pdf->Cell(75,10,'Examination Fees: ',0,0,'L');
            $this->pdf->SetXY(60,157);
            $this->pdf->Cell(75,10,'Rs '.number_format($data->exam_fees) ,0,0,'L');

            $this->pdf->Image($branch_signature,151,169,30,0);
            $this->pdf->Image($examination_controller_signature, 35,168,30,0);


           // $this->pdf->Code128(92.5,200,'ABCDEFG1234567890AbCdEf',90,8);

            $this->pdf->Code128(97,200,$barcodeCodeData,80,8);
        
            $this->response->setHeader('Content-Type', 'application/pdf');
            $fileName = str_replace('/','-',trim($data->enrollment_number.$data->id)).'.pdf';
            $this->pdf->output($path.'/'.$fileName, 'F');
            return $fileName;
        }
    }

    private function generate_admit($id)
    {
        if (!empty($id)) {
            if ($id && is_numeric($id)) {
                /*START FETCHING ADMIT DATA*/
                $details = $this->crud->select('admits', '', array('id' => $id), '', true);

                $branch_details = $this->crud->select('branch', '', array('branch_code' => $details->branch_code), '', true);
                $details->branch_signature = $branch_details->signature;
                if (!empty($details)) {
                    $admit = $this->pdf_generate('admit',$details);
                    $dataArr = array(
                        'admit_file' => $admit,
                    );
                    if ($this->crud->updateData('admits', array('id' => $details->id), $dataArr)) {
                        return true;
                    }                    
                }
            }
        }
    }

    public function admit_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            $id = decrypt($id);
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('admits', '', array('id' => $id, 'branch_id' => $this->session->branchData['id']), '', true);
               if (!empty($details)) {
                   $this->data['title'] = 'Admit Details';
                   return view('branch/admit/admit-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/branch/admit'); die;
               }
            }
        }
    }


    public function ajax_dt_get_admit_list()
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
        $branchId = $this->session->branchData['id'];

        ## Total number of records without filtering
        $totalRecords = get_count('admits', array('branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`admits.branch_id`=$branchId";
        if (!empty($keyword)) {
            $where .= empty($where)?"`admits.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_time` LIKE '%$keyword%' ESCAPE '!'":" AND `admits.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_time` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getAdmitsListCount($where);
        }

        ## Fetch records
        $records = $this->dt->getAjaxDatatableAdmitsList($keyword, $columnSortOrder, $rowperpage, $start, $branchId);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            if (!empty($record->admit_file)) {
                $subAction .= '<a class="dropdown-item" href="'.site_url('public/upload/branch-files/student/admit/'.$record->admit_file).'" download>Download Admit</a>';
            }
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/admit/admit-details/'.encrypt($record->id)).'">Details</a>
            '.$subAction.'
            </div>
            </div>';


            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number,
                "exam_name" => $record->exam_name,
                "date" => date('M d, Y', $record->exam_date),
                "time" => $record->exam_time,
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
