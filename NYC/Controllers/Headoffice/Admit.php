<?php
namespace App\Controllers\Headoffice;

use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Libraries\Pdf\FPDF;
use App\Models\Exporter_model;



use Config\Services;

class Admit extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->crud = new Crud_model($db);
        $this->dt = new Datatable_model($db);

        $this->expo = new Exporter_model($db);
        $this->pdf = new FPDF();


        //load helper
        helper('custom');
    }

    public function index()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Admit List';
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id, branch_code', array('status' => 1));
            return view('headoffice/admit/manage-admit', $this->data);
        }
    }

    public function deleteAdmit()
    {
        if (($this->request->getMethod() == "post") && $this->request->isAjax()) {

            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $data = $this->request->getPost('data');
            if (!empty($data)) {
                $dataArr = explode('||', $data);
                $enrollNo = end($dataArr);
                $id = $dataArr[0];
                $details = $this->crud->select('admits', '', array('id' => $id), '', true);
                if (!empty($details)) {
                    $hasMatrksheet = get_count('marksheets', array('enrollment_number' => $enrollNo));
                    $hasCerififcate = get_count('certificates', array('enrollment_number' => $enrollNo));
                    if ($hasMatrksheet || $hasCerififcate) {
                        $this->data['message'] = 'You can\'t delete this admit, in order to delete this admit card, first delete generated marksheets or certificates first.';
                        error($this->data);
                    }

                    if ($this->crud->deleteData('admits', ['id' => $id])) {
                        $path = 'upload/branch-files/student/admit/'.$details->admit_file;
                        unlink($path);
                        $this->data['success'] = true;
                        $this->data['message'] = 'Admit card has been succesfully deleted';
                        echo json_encode($this->data);
                    }
                }else {
                    $this->data['message'] = 'No data found';
                    error($this->data);
                }                
            }else {
                $this->data['message'] = 'Error 404! Id not found';
                error($this->data);
            }
        }
    }

    public function edit_admit($id = 0)
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Edit Admit';

            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->crud->select('admits', '', array('id' => $id), '', true)))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/admit');
                }
            }
            return view('headoffice/admit/edit-admit-card', $this->data);
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
                

                $data = $this->request->getPost();
                $dataArr = array(
                    'enrollment_number' => $data['enrollment_number'],
                    'registration_number' => $data['registration_number'],
                    'candidate_name' => $data['candidate_name'],
                    'exam_name' => $data['exam_name'],
                    'branch_code' => $data['branch_code'],
                    'exam_date' => strtotime($data['exam_date']),
                    'exam_day' => $data['exam_day'],
                    'exam_time' => $data['exam_time'],
                    'updated_at' => strtotime('now'),
                );
                if ($this->crud->updateData('admits', array('id' => $id), $dataArr)) {
                    $this->generate_admit($id);
                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('head-office/admit/admit-details/'.$id);
                    $this->data['message'] = 'Admit card has been successfully created.';
                    echo json_encode($this->data); die;
                }
            }
        }
    }

    public function admit_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('admits', '', array('id' => $id), '', true);
               if (!empty($details)) {
                   $this->data['title'] = 'Admit Details';
                   return view('headoffice/admit/admit-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/head-officeadmit'); die;
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
        $branchId = $dtpostData['branch'];

        ## Total number of records without filtering
        $totalRecords = get_count('admits');
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($branchId)) {
            $where .= "`admits.branch_id`=$branchId";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"`admits.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_time` LIKE '%$keyword%' ESCAPE '!'":" AND `admits.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_name` LIKE '%$keyword%' ESCAPE '!' OR `admits.exam_time` LIKE '%$keyword%' ESCAPE '!'";
        }

        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getAdmitsListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoAdmitList($keyword, $columnSortOrder, $rowperpage, $start, $branchId);

        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = '';

            $actions .= '<a href="'.site_url('head-office/admit/admit-details/').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';
            // $actions .= '<a href="'.site_url('head-office/admit/edit-admit/').$record->id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $actions .= '<a href="'.site_url('public/upload/branch-files/student/admit/'.$record->admit_file).'" class="btn btn-success btn-sm btn-icon" data-toggle="tooltip" title="Download Admit" download><i class="fa-solid fa-download"></i></a>';
            $actions .= '<a href="javascript:void(0)" data-id="'."$record->id||$record->enrollment_number".'" class="btn btn-danger btn-sm btn-icon deleteAdmit" data-toggle="tooltip" title="Delete Admit" download><i class="fa-solid fa-trash"></i></a>';


            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number,
                "branch_code" => $record->branch_code,
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
            $barcodeCodeData = $data->exam_name.' '.$data->enrollment_number.' '.date("M d, Y", $data->exam_date);
            $barcode = barcodes($barcodeCodeData);

            $this->pdf = new FPDF('P','mm',array(210,278));
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

            $this->pdf->Image($barcode, 40,162,18,0);


            $this->pdf->Image($branch_signature,158,167,18,0);
            $this->pdf->Image($examination_controller_signature, 40,162,18,0);
            

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
                    if ($this->crud->updateData('admits', array('id' => $id), $dataArr)) {
                        return true;
                    }                    
                }
            }
        }
    }
}
