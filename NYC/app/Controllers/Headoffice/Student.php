<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Models\Notification_model;


class Student extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);
		$this->dt = new Datatable_model($db);
		$this->notification = new Notification_model($db);

		//load helper
		helper('custom');
	}

	public function index($type = 0)
	{
		if ($this->request->getMethod() == 'get') {
			$this->data['title'] = 'Students';
			return view('headoffice/student/student-list', $this->data);
		}
	}

	public function manage_admission()
	{
		if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
			$this->data['title'] = 'Admissions';
			return view('headoffice/student/manage-admission', $this->data);
		}
	}

	public function details($id = 0)
	{
		if ($this->request->getMethod() == 'get') {
			if ($id && is_numeric($id)) {
				$this->data['title'] = 'Student Details';
				$this->data['details'] = $this->crud->select('student', '', array('id' => $id), '', true);
				// pr($this->data);
				return view('headoffice/student/student-details', $this->data);
			}else{
				$this->session->setFlashdata('message', 'Something went wrong!');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/student'); die;
			}
			
		}
	}

	public function change_status($id,$val)
	{
		if ($this->request->getMethod() == 'get') {
			if (is_headoffice()) {
				if ($this->crud->updateData('student', array('id' => $id), array('status' => $val))) {

					$student_table_details = $this->crud->select('student', '', array('id' => $id), '', true);
					$branch_id = $student_table_details->branch_id;

					$notiArr = array(
						'from_id' => $this->session->userData['id'],
						'form_id_type' => 1,
						'to_id' => $branch_id,
						'to_id_type' => 2,
						'old_status' => $val,
						'type' => 4,
						'slug' => 'student-status',
						'date' => strtotime('now'),
					);
					$this->notification->addNotification('notifications', $notiArr);
					
					$this->session->setFlashdata('message', 'Student status has been changed');
					$this->session->setFlashdata('message_type', 'success');
					return redirect()->to('/head-office/student'); die;
				}else {
					$this->session->setFlashdata('message', 'Something went wrong!');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to('/head-office/student'); die;
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to('/head-office/student'); die;
		}
	}

	public function delete_student($id)
    {
        if ($this->request->getMethod() == 'get') {
            if (is_numeric($id)){
                if ($this->crud->updateData('student', array('id' => $id), array('is_deleted' => 1, 'status' => 2))) {
                   $this->session->setFlashData('message', 'Student has been deleted successfully');
                   $this->session->setFlashData('message_type', 'success');
                   return redirect()->to('/head-office/student'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Access Denied!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/head-office/student'); die;
            }
        }
    }

	/*AJAX REQUESTS*/
	public function ajax_dt_get_student_list()
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
    	$status = $dtpostData['status'];
    	$keyword = $dtpostData['keyword'];
    	$gender = $dtpostData['gender'];

     	## Total number of records without filtering
    	$totalRecords = $this->dt->getStudListCount(array('is_deleted' => 0));
     	## Total number of records with filtering
     	$totalRecordwithFilter = $totalRecords;
     	if (!empty($status)) {
     		$where .= "`student.status`=$status";
     	}
     	if (!empty($gender)) {
     		$where .= empty($where)?"`student.gender`='$gender'":" AND `student.gender`='$gender'";
     	}
     	if (!empty($keyword)) {
     		$where .= empty($where)?"`br.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!'":" AND `br.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!'";
     	}
     	if (!empty($where)) {
     		$totalRecordwithFilter = $this->dt->getStudListCount($where);
     	}


     	## Fetch records
    	$records = $this->dt->getAjaxDatatableStudentList($status, $keyword, $gender, $columnSortOrder, $rowperpage, $start);
    	$data = array();
    	$i = $start+1;
    	foreach($records as $record ){
    		if ($record->status == 1) {
    			$statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeStudentStatus" data-id="'.$record->id.'" data-val="2"><span class="badge badge-success-lighten">Active</span></a>';
    		}else {
    			$statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to active" class="changeStudentStatus" data-id="'.$record->id.'" data-val="1"><span class="badge badge-danger-lighten">Inactive</span></a>';
    		}

            $actions = '<a href="'.site_url('head-office/student/student-details/').$record->id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';
            $actions .= '<a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deleteStud" data-toggle="tooltip" title="Details"><i class="fa-solid fa-trash"></i></a>';

    		$data[] = array( 
    			"slNo" => $i++,
    			"registration_number" => $record->registration_number,
    			"student_name" => $record->student_name,
    			"gender" => $record->gender,
    			"mobile" => $record->mobile,
    			"branch_name" => $record->branch_name,
    			"status" => $statusHtml,
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

	public function ajax_dt_get_admission_list()
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
        $totalRecords = get_count('admission', 'id<>0');
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "";
        if (!empty($keyword)) {
            $where .= empty($where)?"`admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admission.student_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_code` LIKE '%$keyword%' ESCAPE '!' OR `crt.course_type` LIKE '%$keyword%' ESCAPE '!' OR `br.branch_name` LIKE '%$keyword%' ESCAPE '!'":" AND `admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admission.student_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_code` LIKE '%$keyword%' ESCAPE '!' OR `crt.course_type` LIKE '%$keyword%' ESCAPE '!' OR `br.branch_name` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getAdmissionListCount($where);
        }
       


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoAdmissionList($keyword, $columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){

            $data[] = array( 
                "slNo" => $i++,
                "branch_name" => $record->branch_name,
                "enrollment_number" => $record->enrollment_number,
                "student_name" => $record->student_name,
                "course_name" => $record->course_name,
                "course_code" => $record->course_code,
                "course_type" => $record->course_type,
                "course_duration" => ($record->course_duration > 1)?$record->course_duration.' Months':$record->course_duration.' Month',
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
