<?php
namespace App\Controllers\Headoffice;

use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Libraries\Pdf\FPDF;

use Config\Services;

class Authletter extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->crud = new Crud_model($db);
        $this->dt = new Datatable_model($db);


        //load helper
        helper('custom');
    }
    public function index()
    {
        $code = @($_GET['branch_code'])?($_GET['branch_code']):'';
        if ($this->request->getMethod() == 'post' && !$this->request->isAjax()) {
            $postData = $this->request->getPost();
            $branches = $this->crud->select('branch', 'branch_code', array('status' => 1,'branch_code'=>$postData['branch_code']),array(),true);
            if(!empty($branches)){
                 return redirect()->to('/head-office/auth-letter/'.$branches->branch_code); die;
            }else{
                $this->session->setFlashdata('message', 'Please Enter a valid branch code.');
                $this->session->setFlashdata('message_type', 'error');
                return redirect()->to('/head-office/auth-letter'); die;
            }
        }
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Authorization Letter List';
            $this->data['code'] = $code;
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id', array('status' => 1));
            return view('headoffice/letter/auth-letter', $this->data);
         }
    }

    public function delete_auth_letter()
    {
        if (($this->request->getMethod() == "post") && $this->request->isAjax()) {

            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $id = $this->request->getPost('data');
            if (!empty($id)) {
                $details = $this->crud->select('authletter', '', array('id' => $id), '', true);
                if (!empty($details)) {
                    if ($this->crud->updateData('authletter', ['id' => $id], ['is_deleted' => 'Yes'])) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Authorization letter has been succesfully deleted';
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


    function generate_authletter()
    {
        if($this->request->getMethod() == "post"){
            if ($this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();

                if (strlen($this->request->getPost('owner_name')) == 0) {
                    $this->data['id'] = '#owner_name';
                    $this->data['message'] = 'Please enter owner name.';
                    error($this->data);
                }
                if (strlen($_FILES['image']['tmp_name']) == 0 && (empty($this->request->getPost('oldImage'))) ) {
                    $this->data['message'] = 'Please select owner image.';
                    echo json_encode($this->data); die;
                }elseif(strlen($_FILES['image']['tmp_name']) > 0 ){
                    $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
                    $width = $fileinfo[0];
                    $height = $fileinfo[1];
                    if( $width != 150 || $height != 150){
                        $this->data['message'] = 'Image dimention should be 150x150';
                        echo json_encode($this->data); die;
                    }
                }
                if (strlen($this->request->getPost('registration_date')) == 0) {
                    $this->data['id'] = '#registration_date';
                    $this->data['message'] = 'Please enter registration date.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('renewal_date')) == 0) {
                    $this->data['id'] = '#renewal_date';
                    $this->data['message'] = 'Please enter renewal date.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('issue_date')) == 0) {
                    $this->data['id'] = '#issue_date';
                    $this->data['message'] = 'Please enter issue date.';
                    error($this->data);
                }

                $postData = $this->request->getPost();
                $postData['registration_date'] = strtotime($postData['registration_date']);
                $postData['renewal_date'] = strtotime($postData['renewal_date']);
                $postData['issue_date'] = strtotime($postData['issue_date']);
                if(@$postData['branch_id']){
                    $postData['branch_id'] = $postData['branch_id'];
                }
                
                $postData['created_at'] = time();

                if (strlen($_FILES['image']['tmp_name']) != 0) {
                    $postData['image'] = uploadFile('upload/files/branch/branch-image', 'image', $this->request->getPost('image'));
                }else{
                    $postData['image'] = $postData['oldImage'];
                }
                $academy_name = $postData['academy_name'];
                $branch_code = $postData['branch_code'];
                unset($postData['academy_name']);
                unset($postData['branch_code']);

                unset($postData['oldImage']);
                if( isset( $postData['letter_code'])){
                    $letter_code = $last_id = $postData['letter_code'];
                    unset($postData['letter_code']);
                    $this->crud->updateData('authletter', array('id'=>$letter_code), $postData); 
                }else{
                    $last_id = $this->crud->add('authletter', $postData);
                    $this->crud->updateData('branch', array('id'=>$postData['branch_id']), array('renewal_date'=> $postData['renewal_date']) ); 
                }
                

                if ($last_id) {
                    $postData['academy_name'] = $academy_name;
                    $postData['branch_code'] = $branch_code;
                    $letter = $this->letter_generate($postData);
                    $this->crud->updateData('authletter', array('id'=>$last_id), array('pdf'=>$letter));
                    $this->crud->updateData('branch', array('id' => $postData['branch_id']), ['auth_letter' => $letter]);
                    $this->data['success'] = true;
                    $this->data['message'] = 'Data has been successfully added';
                    echo json_encode($this->data); die;
                }else{
                    $this->data['message'] = 'Something went wrong!';
                    echo json_encode($this->data); die;
                }
            }
        }else if($this->request->getMethod() == "get"){

            if( isset($_GET['letter_code']) ){
                $this->data['title'] = "Edit Authorization letter.";
                $id = @($_GET['letter_code'])?($_GET['letter_code']):'';
                $details = $this->crud->select('authletter', '*', array('id' =>$id), '', true);
                $this->data['branch_details'] = $this->crud->select('branch', 'id,branch_code,academy_name', array('id' =>$details->branch_id), '', true);
                $this->data['details'] = $details;
                return view('headoffice/letter/new-letter', $this->data);
            }else{
                $id = @($_GET['branch_code'])?($_GET['branch_code']):'';
                $this->data['branch_details'] = $this->crud->select('branch', 'id,branch_code,academy_name', array('branch_code' =>$id), '', true);
                $this->data['title'] = "Create new Authorization Letter of branch ".$id;
                $this->data['details'] = array();
                $this->data['id'] = $id;
                return view('headoffice/letter/new-letter', $this->data);
            }
        }
    }

    public function letter_generate($data = array()){
            $path ='upload/branch-files/auth-letter';
            $background = site_url().'public/auth-letter/letter.jpg';
            $chairman = site_url().'public/upload/settings/'.config('SiteConfig')->media['SIGN_CHAIRMAN'];
            $profile_image = site_url().'public/upload/files/branch/branch-image/'.$data['image'];

            $this->pdf = new FPDF('L','mm',array(284,203));
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AddPage();
            $this->pdf->Image($background, -5, -3.5, 294, 0);

            $this->pdf->Image($profile_image, 236,49,28,0);

            $this->pdf->Image($chairman, 230,154,32,0);
            
            $this->pdf->SetXY(0,78);
            $this->pdf->SetFont('Arial','B',30);
            $this->pdf->Cell(278,30,$data['owner_name'],0,0,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetTextColor(39,20,118);
            $this->pdf->SetXY(95,134.5);
            $this->pdf->SetFont('Arial','B',14);
            $this->pdf->Cell(43,6,$data['branch_code'],0,0,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetXY(65,135);
            $this->pdf->SetFont('Arial','B',14);
            $this->pdf->Cell(100,20, date('d/m/Y',$data['registration_date']) ,0,0,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetXY(151,138.5);
            $this->pdf->SetFont('Arial','B',12);
            $this->pdf->MultiCell(90,6, $data['academy_name'] ,0,'T',false);
            $this->pdf->Ln(10);

            $this->pdf->SetTextColor(255,255,255);
            $this->pdf->SetXY(65,145);
            $this->pdf->SetFont('Arial','B',14);
            $this->pdf->Cell(100,20,date('d/m/Y',$data['renewal_date']),0,0,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetTextColor(39,20,118);
            $this->pdf->SetXY(55,161);
            $this->pdf->SetFont('Arial','B',15);
            $this->pdf->Cell(100,20,date('d/m/Y',$data['issue_date']),0,0,'C');
            $this->pdf->Ln(10);

            $this->response->setHeader('Content-Type', 'application/pdf');
            $rawFileName = encrypt($data['renewal_date']);
            $fileName = $rawFileName.'.pdf';
            $this->pdf->output($path.'/'.$fileName, 'F');
            return $fileName;
        }
    /*AJAX REQUESTS*/

    public function ajax_dt_get_authletter_list()
    {
        $postData = $this->request->getPost();

        $branchCode = trim($postData['data']['branchCode']);

        $branch_id = $this->crud->select('branch', 'id', array('branch_code' =>$branchCode), '', true);
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

        ## Total number of records without filtering
        $totalRecords = get_count('authletter', array('branch_id' => $branch_id->id, 'is_deleted' => 2));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;

        ## Fetch records
        $records = $this->dt->getAjaxDatatableAuthLetterList($branch_id->id, $columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;

        

        foreach($records as $record ){

            $actions = '<a href="'.site_url('/head-office/generate-authletter?letter_code=').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-pen-to-square"></i></a>';

             $actions .= '<a download="'.$record->branch_code.'" href="'.site_url('/public/upload/branch-files/auth-letter/').$record->pdf.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-download"></i></a>';

             $actions .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deleteLetter" data-id="'.$record->id.'" data-toggle="tooltip" title="Delete Letter"><i class="fa-solid fa-trash"></i></a>';

        
            $data[] = array( 
                "slNo" => $i++,
                "branch_name" => $record->branch_name.'<br>'.$record->branch_code,
                "registration_date" => date("F j, Y",$record->registration_date),
                "issue_date" => date("F j, Y",$record->issue_date),
                "renewal_date" => date("F j, Y",$record->renewal_date),
                "action" => $actions,
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
